<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection details
    $host = 'localhost';
    $db = 'private_university';
    $user = 'root';
    $pass = '';

    // Create a database connection
    $conn = new mysqli($host, $user, $pass, $db);

    // Check database connection
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Retrieve and sanitize inputs
    $nic = trim($_POST['nic']);
    $name = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $tel = trim($_POST['tel'] ?? '');
    $course = trim($_POST['course'] ?? '');

    // Check if the student exists
    $checkSql = "SELECT * FROM students WHERE nic = ?";
    $checkStmt = $conn->prepare($checkSql);

    if (!$checkStmt) {
        die("SQL error: " . $conn->error);
    }

    $checkStmt->bind_param("s", $nic);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Update the student details
        $updateSql = "UPDATE students SET 
                      name = IF(? = '', name, ?), 
                      address = IF(? = '', address, ?), 
                      tel = IF(? = '', tel, ?), 
                      course = IF(? = '', course, ?) 
                      WHERE nic = ?";
        $updateStmt = $conn->prepare($updateSql);

        if (!$updateStmt) {
            die("SQL error: " . $conn->error);
        }

        $updateStmt->bind_param(
            "sssssss", 
            $name, $name, 
            $address, $address, 
            $tel, $tel, 
            $course, $course, 
            $nic
        );

        $updateStmt->execute();

        if ($updateStmt->affected_rows > 0) {
            echo "Student details updated successfully!";
        } else {
            echo "No changes were made to the student details.";
        }

        $updateStmt->close();
    } else {
        echo "Student with NIC $nic not found!";
    }

    $checkStmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Update Student Details</h1>
        <form action="update.php" method="POST">
            <label for="nic">NIC:</label>
            <input type="text" id="nic" name="nic" required>
            
            <label for="name">Name (optional):</label>
            <input type="text" id="name" name="name">
            
            <label for="address">Address (optional):</label>
            <input type="text" id="address" name="address">
            
            <label for="tel">Tel No (optional):</label>
            <input type="text" id="tel" name="tel">
            
            <label for="course">Course (optional):</label>
            <input type="text" id="course" name="course">
            
            <button type="submit">Update</button>
            <a href="dashboard.php" class="back-button">Back to Dashboard</a>
        </form>
    </div>
</body>
</html>
