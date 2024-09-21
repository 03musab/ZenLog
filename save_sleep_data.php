<?php
// Database connection
$host = 'localhost';
$db   = 'zenlog';
$user = 'root';  // Replace with your DB username
$pass = '';      // Replace with your DB password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Check if age and hoursSlept are set via POST
if (isset($_POST['age']) && isset($_POST['hoursSlept'])) {
    $age = intval($_POST['age']);
    $hoursSlept = floatval($_POST['hoursSlept']);

    // Insert data into the database
    $stmt = $pdo->prepare('INSERT INTO sleep_data (user_age, hours_slept) VALUES (:age, :hoursSlept)');
    $stmt->execute(['age' => $age, 'hoursSlept' => $hoursSlept]);

    // Return success response
    echo json_encode(['success' => true]);
} else {
    // Return error if data is missing
    echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
}
?>
