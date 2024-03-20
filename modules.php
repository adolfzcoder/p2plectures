<?php
include 'db_conn.php';

// Check if faculty_id is provided in the URL
if (!isset($_GET['faculty_id'])) {
    // Redirect or display an error message
    header("Location: index.php");
    exit();
}


$faculty_id = $_GET['faculty_id'];

// Fetch modules of the selected faculty
$sql = "SELECT * FROM modules WHERE faculty_id = $faculty_id";
$result = $conn->query($sql);


$sql2 = "SELECT DISTINCT year FROM modules WHERE faculty_id = $faculty_id ORDER BY year ASC";
$year_result = $conn->query($sql2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LQZH0H9VYX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-LQZH0H9VYX');
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modules</title>
    <style>
                
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap');

        body {
            font-family: 'Quicksand', sans-serif;
            color: #302f49; /* Primary color */
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
        }

        .module-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 0 auto;
        }

        .module-card {
            border: 1px solid #45a049; /* Secondary color */
            border-radius: 5px;
            padding: 20px;
            margin: 10px;
            width: calc(20% - 20px); /* Adjusted width to display 5 modules per row */
            max-width: 200px;
            background-color: #ffffff; /* White */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow effect */
            text-align: center;
        }

        .module-card a {
            text-decoration: none;
            color: #302f49; /* Primary color */
            font-weight: bold;
        }

        .module-card:hover {
            transform: translateY(-3px);
            transition: transform 0.3s ease;
        }
        .modules-container {
            margin: 0 auto;
            align-items: center;
        }

        /* Responsive styles */
        @media screen and (max-width: 768px) {
            .module-card {
                width: calc(33.33% - 20px); /* Adjusted width for smaller screens */
            }
        }

        @media screen and (max-width: 480px) {
            .module-card {
                width: calc(50% - 20px); /* Adjusted width for smaller screens */
            }
        }

        @media screen and (max-width: 360px) {
            .module-card {
                width: calc(100% - 20px); /* Adjusted width for even smaller screens */
            }
        }
        
    </style>
</head>
<body>
    <?php 
    include("nav.php");
    ?>
    <h2>Modules</h2>
    <!-- <form action="modules.php" method="GET">
        <input type="hidden" name="faculty_id" value="<?php echo $faculty_id; ?>">
        <label for="search">Search Modules:</label>
        <input type="text" id="search" name="search">
        <input type="submit" value="Search">
    </form> -->
    <div class="modules-container">
        <?php
        if ($year_result->num_rows > 0) {
            // Iterate over each year
            while ($year_row = $year_result->fetch_assoc()) {
                $year = $year_row['year'];
                echo "<h3>Year $year</h3>";
                
                // Fetch modules for the current year
                $year_modules_sql = "SELECT * FROM modules WHERE faculty_id = $faculty_id AND year = $year";
                $year_modules_result = $conn->query($year_modules_sql);

                // Display modules for the current year
                if ($year_modules_result->num_rows > 0) {
                    echo "<div class='module-container'>";
                    while ($row = $year_modules_result->fetch_assoc()) {
                        $module_id = $row['module_id'];
                        $name = $row['name'];
                        echo "<div class='module-card'>";
                        echo "<a href='listen-to-lectures.php?module_name=$name'>$name</a>";
                        echo "</div>";
                    }
                    echo "</div>"; // Close module-container div
                } else {
                    echo "<p>No modules found for Year $year.</p>";
                }
            }
        } else {
            echo "<p>No modules found for this faculty.</p>";
        }
        ?>
    </div>
</body>
</html>
