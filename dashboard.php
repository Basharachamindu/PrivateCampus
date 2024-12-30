<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <a href="register.php">Register Student</a> |
        <a href="search.php">Search Student</a> |
        <a href="update.php">Update Student</a> |
        <a href="delete.php">Remove Student</a> |
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
