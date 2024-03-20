<?php
// Include database connection
include 'db_conn.php';

// Check if faculty_id is set in the POST request
if (isset($_POST['faculty_id'])) {
    // Sanitize the input
    $facultyId = $_POST['faculty_id'];

    // Prepare and execute the SQL query to fetch modules based on the selected faculty
    $sql = "SELECT module_id, name AS module_name FROM modules WHERE faculty_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $facultyId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the results into an associative array
    $modules = array();
    while ($row = $result->fetch_assoc()) {
        $modules[] = $row;
    }

    // Return the fetched modules as JSON
    echo json_encode($modules);
}
?>
