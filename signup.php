<?php
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

// Get form data
$user = $_POST['username'];
$email = $_POST['email'];
$pass = $_POST['password'];

// Validate and sanitize input
$user = $conn->real_escape_string($user);
$email = $conn->real_escape_string($email);
$pass = $conn->real_escape_string($pass);

// Hash the password
$passwordHash = password_hash($pass, PASSWORD_BCRYPT);

// Prepare and execute SQL query
$sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $user, $email, $passwordHash);

if ($stmt->execute()) {
    echo "User registered successfully!";
    header("Location: login.html"); // Redirect to login page
    exit();
} else {
    die("Error: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
