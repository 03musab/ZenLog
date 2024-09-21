<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zenlog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

// Fetch mood data for the user
$sql = "SELECT mood_level, mood_comment, mood_trigger, date FROM mood_data WHERE user_id = ? ORDER BY date DESC";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$mood_data = [];
while ($row = $result->fetch_assoc()) {
    $mood_data[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - ZenLog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Your Mood Data</h1>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Mood Level</th>
                            <th>Comments</th>
                            <th>Trigger</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mood_data as $data): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($data['date']); ?></td>
                                <td><?php echo htmlspecialchars($data['mood_level']); ?></td>
                                <td><?php echo htmlspecialchars($data['mood_comment']); ?></td>
                                <td><?php echo htmlspecialchars($data['mood_trigger']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
