<?php
session_start();
include 'db_conn.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if audio_id is provided in the URL
if (!isset($_GET['audio_id'])) {
    // Redirect to homepage or display an error message
    header("Location: index.php");
    exit();
}
include("nav.php");


// Get the audio ID from the URL
$audio_id = $_GET['audio_id'];

// Check if the user uploaded the audio with the provided audio_id
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM audio WHERE audio_id = '$audio_id' AND user_id = '$user_id'";
$result = $conn->query($sql);

// Check if the audio exists and belongs to the current user
if ($result->num_rows == 0) {
    // Redirect to homepage or display an error message
    header("Location: index.php");
    exit();
}

// Fetch the audio details
$audio = $result->fetch_assoc();
$title = $audio['title'];
$file_path = $audio['file_path'];
$upload_date = $audio['upload_date'];
$module_name = $audio['module_name'];
$lecturer_name = $audio['lecturer_name'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated values from the form
    $new_module_name = $_POST['module_name'];
    $new_lecturer_name = $_POST['lecturer_name'];

    // Update the audio details in the database
    $update_sql = "UPDATE audio SET module_name = '$new_module_name', lecturer_name = '$new_lecturer_name' WHERE audio_id = '$audio_id' AND user_id = '$user_id'";
    if ($conn->query($update_sql) === TRUE) {
        echo "Audio details updated successfully.";
    } else {
        echo "Error updating audio details: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Audio Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <style>
        
        
         @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap');

body {
    font-family: 'Quicksand', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            z-index: 1000;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #333;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        $(function() {
            // Autocomplete for module name input
            $("#module_name").autocomplete({
                source: "search_modules.php", // Path to the PHP file that handles module search
                minLength: 2, // Minimum length of input before autocomplete triggers
            });
        });
    </script>
</head>
<body>
    <h2>Edit Audio Details</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?audio_id=' . $audio_id); ?>">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $title; ?>" required disabled><br><br>
        
        <!-- Select input for faculty -->
        <label for="faculty">Faculty:</label>
        <select id="faculty" name="faculty">
            <option value="1">Computer Science</option>
            <option value="2">Engineering</option>
            <option value="3">Accounting</option>
        </select><br><br>

        <!-- Input for module name with autocomplete -->
        <label for="module_name">Module Name:</label>
        <input type="text" id="module_name" name="module_name" value="<?php echo $module_name; ?>" required><br><br>

        <label for="lecturer_name">Lecturer's Name:</label>
        <input type="text" id="lecturer_name" name="lecturer_name" value="<?php echo $lecturer_name; ?>" required><br><br>

        <label for="file_path">File Path:</label>
        <input type="text" id="file_path" name="file_path" value="<?php echo $file_path; ?>" readonly disabled><br><br>

        <label for="upload_date">Upload Date:</label>
        <input type="text" id="upload_date" name="upload_date" value="<?php echo $upload_date; ?>" readonly disabled><br>
        <input type="submit" value="Save Changes">
        
        
    </form>
</body>
</html>