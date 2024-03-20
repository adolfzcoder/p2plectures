<?php
include 'db_conn.php';

// Fetch all faculties
$sql = "SELECT * FROM faculties";
$result = $conn->query($sql);

// Fetch all years
$years = range(date("Y"), date("Y") - 10); // Assuming a range of 10 years

// Initialize variables
$selected_faculty = "";
$selected_year = "";
$selected_module = "";
$upload_status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_faculty = $_POST["faculty"];
    $selected_year = $_POST["year"];
    $selected_module = $_POST["module"];

    // Check if a file is selected
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $file_name = $_FILES["file"]["name"];
        $file_temp = $_FILES["file"]["tmp_name"];
        $file_type = $_FILES["file"]["type"];
        $file_size = $_FILES["file"]["size"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Allowed file types
        $allowed_ext = array("pdf", "doc", "docx", "png", "jpg", "jpeg");

        // Check if the file extension is allowed
        if (in_array($file_ext, $allowed_ext)) {
            // Directory where the uploaded files will be saved
            $upload_dir = "question_papers/";

            // Generate a unique file name to prevent overwriting
            $unique_file_name = uniqid() . '.' . $file_ext;

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($file_temp, $upload_dir . $unique_file_name)) {
                // File uploaded successfully
                $file_path = $upload_dir . $unique_file_name;

                // Insert record into the question_papers table
                $sql = "INSERT INTO question_papers (module_id, file_path) VALUES ('$selected_module', '$file_path')";
                if ($conn->query($sql) === TRUE) {
                    $upload_status = "File uploaded successfully.";
                } else {
                    $upload_status = "Error uploading file: " . $conn->error;
                }
            } else {
                $upload_status = "Error moving file to upload directory.";
            }
        } else {
            $upload_status = "Invalid file format. Only PDF, DOC, DOCX, PNG, JPG, and JPEG files are allowed.";
        }
    } else {
        $upload_status = "Please select a file to upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Question Paper</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-bootstrap/0.5pre/css/custom-theme/jquery-ui-1.10.0.custom.css" integrity="sha512-UU2MyJEMUnGrVszzU9hrgLQfc6S4DZYhQGGpL3olOy04KGL1WaxK96xJm9s8mcCSDieglbThgULflBKwlrODmQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-T0yKOJv72j7P1we5rh6B3reFl8FJSu7dbtqWlg6LRCI=" crossorigin="anonymous"></script>
</head>
<body>
    <h2>Upload Question Paper</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="faculty">Select Faculty:</label>
        <select name="faculty" id="faculty">
            <option value="">Select Faculty</option>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <option value="<?php echo $row['faculty_id']; ?>" <?php echo ($selected_faculty == $row['faculty_id']) ? 'selected' : ''; ?>><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="year">Select Year:</label>
        <select name="year" id="year">
            <option value="">Select Year</option>
            <?php foreach ($years as $year) : ?>
                <option value="<?php echo $year; ?>" <?php echo ($selected_year == $year) ? 'selected' : ''; ?>><?php echo $year; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="module">Select Module:</label>
        <input type="text" name="module" id="module"><br><br>

        <label for="file">Select File:</label>
        <input type="file" name="file" id="file"><br><br>

        <input type="submit" value="Upload">
    </form>

    <p><?php echo $upload_status; ?></p>

    <script>
        $(function() {
            // Autocomplete for module input field
            $("#module").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "get_module_suggestions.php",
                        dataType: "json",
                        data: {
                            query: request.term
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.name,
                                    value: item.name
                                };
                            }));
                        }
                    });
                },
                minLength: 1
            });
        });
    </script>
</body>
</html>
