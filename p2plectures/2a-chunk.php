<?php
session_start();
include("db_conn.php");
include("nav.php");

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to the login page if not logged in
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LQZH0H9VYX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-LQZH0H9VYX');
</script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap');

body {
    font-family: 'Quicksand', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        #list {
            margin-bottom: 20px;
        }

        #pick {
            background-color: #45a049;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        #pick:hover {
            background-color: #3c873a;
        }

        .lecture {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .lecture p {
            margin: 5px 0;
        }

        .edit-link {
            background-color: #45a049;
            color: #ffffff;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .edit-link:hover {
            background-color: #3c873a;
        }
    </style>
</head>

<body>
    <!-- (A) UPLOAD BUTTON & FILE LIST -->
    <form>
        <div id="list"></div>
        <input type="button" id="pick" value="Upload">
    </form>

        <!-- Display uploaded lectures with "Edit Lecture" button -->
        <?php



    // Fetch all lectures uploaded by the current user
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM audio WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    // Check if lectures are found
    if ($result->num_rows > 0) {
        while ($lecture = $result->fetch_assoc()) {
            $audio_id = $lecture['audio_id'];
            $module_name = $lecture['module_name'];
            $lecturer_name = $lecture['lecturer_name'];
            $file_path = $lecture['file_path'];

            // Display lecture details
            echo "<div class='lecture'>";
            echo "<p>Module Name: $module_name</p>";
            echo "<p>Lecturer's Name: $lecturer_name</p>";
            echo "<p>File Path: $file_path</p>";
            
            // Edit Lecture button linking to edit_lecture.php with audio_id
            echo "<a class='edit-link' href='edit_lecture.php?audio_id=$audio_id'>Edit Lecture</a>";
            echo "</div>";
        }
    } else {
        // Display a message if no lectures are found
        echo "<p>No lectures uploaded yet.</p>";
    }
    ?>
    <!-- (B) LOAD PLUPLOAD FROM CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/plupload/3.1.5/plupload.full.min.js"></script>
    <script>
    // (C) INITIALIZE UPLOADER
    window.onload = () => {
        // (C1) GET HTML FILE LIST
        var list = document.getElementById("list");
        
        // (C2) INIT PLUPLOAD
        var uploader = new plupload.Uploader({
            runtimes: "html5",
            browse_button: "pick",
            url: "2b-chunk.php",
            chunk_size: "10mb",
            init: {
                PostInit: () => list.innerHTML = "<div>Ready</div>",
                FilesAdded: (up, files) => {
                    plupload.each(files, file => {
                        let row = document.createElement("div");
                        row.id = file.id;
                        row.innerHTML = `${file.name} (${plupload.formatSize(file.size)}) <strong></strong>`;
                        list.appendChild(row);
                    });
                    uploader.start();
                },
                UploadProgress: (up, file) => {
                    document.querySelector(`#${file.id} strong`).innerHTML = `${file.percent}%`;
                },
                Error: (up, err) => console.error(err)
            }
        });
        uploader.init();
    };
    </script>
</body>
</html>
