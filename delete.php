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

    // Retrieve and sanitize input
    $nic = trim($_POST['nic']);

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
        // Delete the student record
        $deleteSql = "DELETE FROM students WHERE nic = ?";
        $deleteStmt = $conn->prepare($deleteSql);

        if (!$deleteStmt) {
            die("SQL error: " . $conn->error);
        }

        $deleteStmt->bind_param("s", $nic);
        $deleteStmt->execute();

        if ($deleteStmt->affected_rows > 0) {
            echo "Student with NIC $nic removed successfully!";
        } else {
            echo "Failed to remove the student with NIC $nic.";
        }

        $deleteStmt->close();
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
    <title>Delete Student</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Delete Student</h1>
        <form action="delete.php" method="POST">
            <label for="nic">Enter NIC:</label>
            <input type="text" id="nic" name="nic" required>
            <button type="submit">Delete</button>
            <a href="dashboard.php" class="back-button">Back to Dashboard</a>
        </form>
    </div>
</body>
</html>
