<?php
session_start();
include 'config.php'; // Ensure this file contains your database connection

$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

$query = "SELECT * FROM user_goals WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$goals = [];
while ($row = $result->fetch_assoc()) {
    $goals[] = $row;
}

echo json_encode($goals);

$stmt->close();
$conn->close();
?>
