<?php
session_start(); // Start session for user login

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
$login = $_POST['login'];
$pass = $_POST['password'];

// Validate and sanitize input
$login = $conn->real_escape_string($login);
$pass = $conn->real_escape_string($pass);

// Prepare SQL query to find user by username or email
$sql = "SELECT user_id, password_hash FROM users WHERE username = ? OR email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $login, $login);
$stmt->execute();
$stmt->store_result();

// Check if user exists
if ($stmt->num_rows === 1) {
    $stmt->bind_result($userId, $passwordHash);
    $stmt->fetch();

    // Verify password
    if (password_verify($pass, $passwordHash)) {
        // Set session variables
        $_SESSION['user_id'] = $userId;
        header("Location: dashboard.html"); // Redirect to user dashboard
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No account found with that username or email.";
}

$stmt->close();
$conn->close();
?>
