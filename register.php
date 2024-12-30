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

    // Retrieve and sanitize user inputs
    $nic = trim($_POST['nic']);
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $tel = trim($_POST['tel']);
    $course = trim($_POST['course']);

    // Validate required fields
    if (empty($nic) || empty($name) || empty($address) || empty($tel) || empty($course)) {
        echo "All fields are required!";
        exit();
    }

    // Prepare and execute the SQL query
    $sql = "INSERT INTO students (nic, name, address, tel, course, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("sssss", $nic, $name, $address, $tel, $course);

    if ($stmt->execute()) {
        echo "Student Registered Successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Register Student</h1>
        <form action="register.php" method="POST">
            <label for="nic">NIC:</label>
            <input type="text" id="nic" name="nic" required>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            <label for="tel">Tel No:</label>
            <input type="text" id="tel" name="tel" required>
            <label for="course">Course:</label>
            <input type="text" id="course" name="course" required>
            <button type="submit">Register</button>
            <a href="dashboard.php" class="back-button">Back to Dashboard</a>
        </form>
    </div>
</body>
</html>
