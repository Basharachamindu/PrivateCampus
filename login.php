<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method Not Allowed";
    exit();
}

// Database connection details
$host = 'localhost';
$db = 'private_university';
$user = 'root';
$pass = '';

// Create a database connection
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Prepare and execute the query
$sql = "SELECT * FROM users WHERE username = ? AND password = MD5(?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL error: " . $conn->error);
}

$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION['loggedin'] = true;
    header('Location: dashboard.php');
    exit();
} else {
    header('Location: index.html?error=invalid_credentials');
    exit();
}

$stmt->close();
$conn->close();
?>
