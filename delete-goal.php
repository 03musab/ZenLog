<?php
// Include your database connection
require 'config.php';

// Check if the 'id' parameter is set in the query string
if (isset($_GET['id'])) {
    $goalId = intval($_GET['id']); // Sanitize the input to prevent SQL injection

    // Prepare the DELETE query
    $sql = "DELETE FROM user_goals WHERE goal_id = ?";

    // Use prepared statements for security
    if ($stmt = $conn->prepare($sql)) {
        // Bind the goal ID parameter
        $stmt->bind_param("i", $goalId);

        // Execute the query
        if ($stmt->execute()) {
            // Success response
            echo json_encode(['success' => true]);
        } else {
            // Failure response if the delete operation fails
            echo json_encode(['success' => false, 'error' => 'Failed to delete goal']);
        }

        // Close the statement
        $stmt->close();
    } else {
        // Failure response if the query couldn't be prepared
        echo json_encode(['success' => false, 'error' => 'Failed to prepare statement']);
    }
} else {
    // Error response if no goal ID is provided
    echo json_encode(['success' => false, 'error' => 'No goal ID provided']);
}

// Close the database connection
$conn->close();
?>
