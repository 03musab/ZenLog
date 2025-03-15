<?php
$host = 'localhost';
$db = 'zenlog';
$user = 'root';
$pass = 'musab';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
