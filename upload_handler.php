<?php
session_start();
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["audio_file"])) {
    $user_id = $_SESSION['user_id'];
    $title = $_FILES["audio_file"]["name"];
    $file_tmp = $_FILES["audio_file"]["tmp_name"];
    $file_type = $_FILES["audio_file"]["type"];
    $file_size = $_FILES["audio_file"]["size"];

    $target_dir = "audios/";
    $target_file = $target_dir . basename($title);
    $uploadOk = 1;

    // Check file size (max: 150MB)
    if ($file_size > 150 * 1024 * 1024) { // 150 MB in bytes
        echo "Sorry, your file is too large. Maximum file size allowed is 150 MB.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Create a ZIP archive
        $zip = new ZipArchive();
        $zipFileName = $target_dir . pathinfo($title, PATHINFO_FILENAME) . '.zip';
        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($file_tmp, $title);
            $zip->close();

            // Insert audio info into database
            $sql = "INSERT INTO audio (user_id, title, file_path) VALUES ('$user_id', '$title', '$zipFileName')";
            if ($conn->query($sql) === TRUE) {
                echo "The file ". basename($title). " has been uploaded.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error: Failed to create ZIP archive.";
        }
    }
} else {
    echo "No file selected for upload.";
}
?>
