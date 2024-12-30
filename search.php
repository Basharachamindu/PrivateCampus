<?php
$results = [];

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

    // Retrieve and sanitize NIC from POST request
    $nic = trim($_POST['nic']);

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM students WHERE nic = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("s", $nic);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $results[] = $row; // Fetch all rows matching the NIC
        }
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
    <title>Search Student</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Search Student</h1>
        <form action="search.php" method="POST">
            <label for="nic">Enter NIC:</label>
            <input type="text" id="nic" name="nic" required>
            <button type="submit">Search</button>
            <a href="dashboard.php" class="back-button">Back to Dashboard</a>
        </form>
        <?php if (!empty($results)): ?>
            <h2>Results:</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIC</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Tel</th>
                        <th>Course</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result): ?>
                        <tr>
                            <td><?= htmlspecialchars($result['id']) ?></td>
                            <td><?= htmlspecialchars($result['nic']) ?></td>
                            <td><?= htmlspecialchars($result['name']) ?></td>
                            <td><?= htmlspecialchars($result['address']) ?></td>
                            <td><?= htmlspecialchars($result['tel']) ?></td>
                            <td><?= htmlspecialchars($result['course']) ?></td>
                            <td><?= htmlspecialchars($result['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p>No student found with the provided NIC.</p>
        <?php endif; ?>
    </div>
</body>
</html>
