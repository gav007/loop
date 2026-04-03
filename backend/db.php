<?php
$configPath = __DIR__ . "/db.local.php";

if (!file_exists($configPath)) {
  $configPath = __DIR__ . "/db.example.php";
}

$config = require $configPath;

$servername = $config["servername"];
$username = $config["username"];
$password = $config["password"];
$dbname = $config["dbname"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
