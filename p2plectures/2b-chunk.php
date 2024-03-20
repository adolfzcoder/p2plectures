<?php
// (A) HELPER FUNCTION - SERVER RESPONSE
function verbose($ok = 1, $info = "") {
    if ($ok == 0) {
        http_response_code(400);
    }
    exit(json_encode(["ok" => $ok, "info" => $info]));
}

// (B) INVALID UPLOAD
if (empty($_FILES) || $_FILES["file"]["error"]) {
    verbose(0, "Failed to move uploaded file.");
}

// (C) UPLOAD DESTINATION - CHANGE FOLDER IF REQUIRED!
$filePath =  "audios";
if (!file_exists($filePath)) {
    if (!mkdir($filePath, 0777, true)) {
        verbose(0, "Failed to create $filePath");
    }
}
$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
$filePath = $filePath . DIRECTORY_SEPARATOR . $fileName;

// (D) DEAL WITH CHUNKS
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
$out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
if ($out) {
    $in = @fopen($_FILES["file"]["tmp_name"], "rb");
    if ($in) {
        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }
    } else {
        verbose(0, "Failed to open input stream");
    }
    @fclose($in);
    @fclose($out);
    @unlink($_FILES["file"]["tmp_name"]);
} else {
    verbose(0, "Failed to open output stream");
}

// (E) CHECK IF FILE HAS BEEN UPLOADED
if (!$chunks || $chunk == $chunks - 1) {
    rename("{$filePath}.part", $filePath);

    // (F) INSERT FILE PATH AND USER ID INTO DATABASE
    session_start();
    include 'db_conn.php';

    $user_id = $_SESSION['user_id'];

    // Escape variables for security
    $title = mysqli_real_escape_string($conn, $fileName);
    $filePath = mysqli_real_escape_string($conn, $filePath);

    $sql = "INSERT INTO audio (user_id, title, file_path) VALUES ('$user_id', '$title', '$filePath')";
    if ($conn->query($sql) === TRUE) {
        verbose(1, "Upload OK");
    } else {
        verbose(0, "Error: " . $sql . "<br>" . $conn->error);
    }
}
verbose(1, "Chunk uploaded successfully");
?>
