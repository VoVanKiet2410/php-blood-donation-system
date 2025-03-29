<?php
// Load environment variables
require_once __DIR__ . '/env.php';

$host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_DATABASE') ?: 'giotmauvang';
$username = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$port = getenv('DB_PORT') ?: 3306;

try {
    $mysqli = new mysqli($host, $username, $password, $db_name, $port);

    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }
    
    // Set character set
    $mysqli->set_charset('utf8mb4');
    
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}
?>
