<?php
session_start();
require 'config.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id']) && isset($_POST['goal'])) {
        $userId = $_SESSION['user_id'];
        $goal = $_POST['goal'];

        // Sanitize input
        $goal = htmlspecialchars($goal);

        // Prepare and execute the query
        $stmt = $conn->prepare("INSERT INTO user_goals (user_id, goal_description) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $goal);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
