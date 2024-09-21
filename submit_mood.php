<?php
session_start(); // Start the session to access user_id

// Database configuration
$servername = "localhost"; // Change if needed
$username = "root"; // Change if needed
$password = ""; // Change if needed
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

// Get form data
$mood_level = $_POST['mood_level'];
$mood_comments = $_POST['mood_comments'];
$mood_triggers = $_POST['mood_triggers'];

// Validate and sanitize input
$mood_level = $conn->real_escape_string($mood_level);
$mood_comments = $conn->real_escape_string($mood_comments);
$mood_triggers = $conn->real_escape_string($mood_triggers);

// Prepare and execute SQL query
$sql = "INSERT INTO mood_data (user_id, mood_level, mood_comments, mood_triggers) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Prepare failed: " . $conn->error;
    exit;
}

$stmt->bind_param("iiss", $user_id, $mood_level, $mood_comments, $mood_triggers);

if ($stmt->execute()) {
    echo "Mood reflection submitted successfully! Relod the page to update your Mood-Chart :)";
} else {
    echo "Execute failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
