
<?php
// PHP - Handle Like/Dislike Actions
session_start();
include 'db_conn.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
}

include("nav.php");

// Check if name is provided in the URL
if (!isset($_GET['module_name'])) {
    // Redirect or display an error message
    echo "Module name is missing.";
    echo "Please Signup, in order to like/dislike";
    exit();
}

$name = $_GET['module_name'];

$sql1 = "SELECT name FROM modules WHERE name=?";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $module_name = $row['name'];
    }
} else {
    echo "Error occurred displaying module name.";
}
echo "<h2>Listen to Lectures - " . $module_name . "</h2>";

// Handle like action
if (isset($_GET['like']) && isset($_GET['audio_id'])) {
    $audio_id = $_GET['audio_id'];
    $user_id = $_SESSION['user_id'];

    // Check if the user has already liked the audio file
    $sql = "SELECT * FROM likes WHERE audio_id = $audio_id AND user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // User hasn't liked the audio file yet, insert a new like
        $sql = "INSERT INTO likes (audio_id, user_id) VALUES ($audio_id, $user_id)";
        if ($conn->query($sql) === TRUE) {
            echo "Audio file liked successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "You have already liked this audio file.";
    }
}

// Handle dislike action
if (isset($_GET['dislike']) && isset($_GET['audio_id'])) {
    $audio_id = $_GET['audio_id'];
    $user_id = $_SESSION['user_id'];

    // Check if the user has already disliked the audio file
    $sql = "SELECT * FROM dislikes WHERE audio_id = $audio_id AND user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // User hasn't disliked the audio file yet, insert a new dislike
        $sql = "INSERT INTO dislikes (audio_id, user_id) VALUES ($audio_id, $user_id)";
        if ($conn->query($sql) === TRUE) {
            echo "Audio file disliked successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "You have already disliked this audio file.";
    }
}


// Display audio files for the specified module
$sql = "SELECT a.audio_id, a.user_id, a.title, a.file_path, a.upload_date, 
               COUNT(l.audio_id) AS likes, COUNT(d.audio_id) AS dislikes 
        FROM audio a
        LEFT JOIN likes l ON a.audio_id = l.audio_id
        LEFT JOIN dislikes d ON a.audio_id = d.audio_id
        WHERE a.module_name = '$name'
        GROUP BY a.audio_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $audio_id = $row['audio_id'];
        $title = $row['title'];
        $file_path = $row['file_path'];
        $upload_date = $row['upload_date'];
        

        $user_id = $row['user_id'];
        $sql2 = "SELECT users.username FROM users WHERE user_id ='$user_id'";
        $result2 = $conn->query($sql2);
        if ($result2 !== null && $result2->num_rows > 0) {
            while ($row2 = $result2->fetch_assoc()) {
                $username = $row2['username'];
            }
        } else {
        }
        




        $likes = $row['likes'];
        $dislikes = $row['dislikes'];
        $like_url = "{$_SERVER['PHP_SELF']}?like=true&audio_id=$audio_id";
        $dislike_url = "{$_SERVER['PHP_SELF']}?dislike=true&audio_id=$audio_id";
        if(isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            echo "<p style='text-align: center;'>Welcome, $username!</p>";
        } else {
        }
        
        
        echo '<div class = "container">';
        echo "<div class='audio-file'>";
        echo "<span>Preview: <a href='$file_path' target='_blank'>$title</a></span>";
        echo "<p><a download href='$file_path' target='_blank'>Download</a></p>";

        echo "<h3>Uploaded by: $username @ $upload_date</h3>";
        // echo "<div>Likes: $likes <i class='fas fa-thumbs-up'></i></div>";
        // echo "<div>Dislikes: $dislikes <i class='fas fa-thumbs-down'></i></div>";
        //echo "<audio controls><source src='$file_path' type='audio/mp3'>Your browser does not support the audio element.</audio>";
        // echo "<button class='like-btn' onclick=\"window.location.href='$like_url';\">Like</button>";
        // echo "<button class='dislike-btn' onclick=\"window.location.href='$dislike_url';\">Dislike</button>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No audio files found for this module.";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listen to Lectures</title>
    <!-- Font Awesome CDN for icons -->
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LQZH0H9VYX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-LQZH0H9VYX');
</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap');

        body {
            font-family: 'Quicksand', sans-serif;
            color: #302f49;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #302f49;
            text-align: center;
        }

        .audio-files {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .audio-file {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .audio-file span {
            font-weight: bold;
            font-size: 18px;
        }

        .audio-file h3 {
            font-size: 14px;
            color: #666666;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        .audio-file div {
            margin-bottom: 10px;
        }
        .container {
            max-width: 480px;
            margin: 0 auto;
        }

        audio {
            width: 100%;
            margin-bottom: 10px;
        }

        .like-btn, .dislike-btn {
            cursor: pointer;
            margin-right: 10px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            color: #ffffff;
        }

        .like-btn {
            background-color: #4CAF50; /* Green */
        }

        .dislike-btn {
            background-color: #f44336; /* Red */
        }

        .like-btn:hover, .dislike-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    
    <div class="audio-files">
        <!-- Audio files will be displayed here -->
    </div>
</body>
</html>
