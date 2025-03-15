<?php
session_start(); // Start the session to access user_id

// Database configuration
$servername = "localhost"; // Change if needed
$username = "root"; // Change if needed
$password = "musab"; // Change if needed
$dbname = "zenlog";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

// Prepare and execute SQL query
$sql = "SELECT created_at, mood_level FROM mood_data WHERE user_id = ? ORDER BY created_at ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch mood data
$labels = [];
$values = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = date('M d', strtotime($row['created_at']));
    $values[] = $row['mood_level'];
}

// Return data as JSON
echo json_encode(['labels' => $labels, 'values' => $values]);

$stmt->close();
$conn->close();
?>
