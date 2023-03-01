<?php
// MySQL database configuration
$host = 'localhost';
$dbname = 'real_estate_agency';
$user = 'root';
$password = '';

// Establish database connection using PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
