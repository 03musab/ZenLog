<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zenlog";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to submit mood data.");
}

// Get form data
$moodLevel = $_POST['moodLevel'] ?? '';
$moodComments = $_POST['moodComments'] ?? '';
$moodTriggers = $_POST['moodTriggers'] ?? '';

// Validate input
if (empty($moodLevel) || empty($moodComments) || empty($moodTriggers)) {
    die("All fields are required.");
}

// Get user ID from session
$userId = $_SESSION['user_id'];

// Insert mood data into the database
$sql = "INSERT INTO mood_data (user_id, mood_level, mood_comments, mood_triggers, created_at) VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("iiss", $userId, $moodLevel, $moodComments, $moodTriggers);

if ($stmt->execute()) {
    echo "Mood data submitted successfully!";
} else {
    die("Error: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
