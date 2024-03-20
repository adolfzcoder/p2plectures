<?php
include 'db_conn.php';

// Fetch faculties
$sql = "SELECT * FROM faculties";
$result = $conn->query($sql);
include("nav.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculties</title>
    <style>
                @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap');

        body {
            font-family: 'Quicksand', sans-serif;
            color: #302f49;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h2 {
            color: #302f49;
            text-align: center;
        }

        .faculty-card {
            border: 1px solid #45a049; /* Secondary color */
            border-radius: 5px;
            padding: 20px;
            margin: 10px;
            width: 200px;
            display: inline-block;
            background-color: #ffffff; /* White */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow effect */
            text-align: center;
        }

        .faculty-card a {
            text-decoration: none;
            color: #302f49; /* Primary color */
            font-weight: bold;
        }

        .faculty-card:hover {
            transform: translateY(-3px);
            transition: transform 0.3s ease;
        }
        .container {
            margin: 0 auto;
        }

    </style>
</head>
<body>
    <h2 style="text-align:center;">Faculties</h2>
    <div class="conatiner">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $faculty_id = $row['faculty_id'];
                $name = $row['name'];
                echo "<div class='faculty-card'>";
                echo "<a href='modules.php?faculty_id=$faculty_id'>$name</a>";
                echo "</div>";
            }
        } else {
            echo "No faculties found.";
        }
        ?>
    </div>
</body>
</html>
