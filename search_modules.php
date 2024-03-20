<?php
include 'db_conn.php';

// Check if the user input is provided
if (isset($_GET['term'])) {
    $term = $_GET['term'];
    
    // Query the database for module names matching the user input
    $sql = "SELECT name FROM modules WHERE name LIKE '%$term%' ORDER BY name ASC";
    $result = $conn->query($sql);
    
    // Fetch module names and store them in an array
    $modules = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $modules[] = $row['name'];
        }
    }
    
    // Return module names as JSON
    echo json_encode($modules);
}
?>
