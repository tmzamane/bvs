<?php
// db.php - This file establishes the database connection

// Configuration details
define('DB_HOST', 'localhost');
define('DB_USER', 'pbxadmin');
define('DB_PASS', 'BvsCalls@2025!');
define('DB_NAME', 'pbx');

// Create the connection object and assign it to the $conn variable
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check for connection errors and stop the script if it fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
