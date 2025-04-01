<?php

use Illuminate\Database\Capsule\Manager as Capsule;

// Load environment variables
require_once __DIR__ . '/env.php';
require_once '../vendor/autoload.php';

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

    // Debugging: Confirm connection
    error_log("Database connection successful: {$host}, {$db_name}");

    // Set character set
    $mysqli->set_charset('utf8mb4');
    
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

// More detailed debugging for Capsule connection
try {
    $capsule = new Capsule;

    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => $host,
        'database'  => $db_name,
        'username'  => $username,
        'password'  => $password,
        'charset'   => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix'    => '',
        'port'      => $port,
    ]);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    // Verify Eloquent connection
    $pdo = $capsule->getConnection()->getPdo();
    error_log("Eloquent connection established successfully");
    
} catch (\Exception $e) {
    error_log("Eloquent connection error: " . $e->getMessage());
    die("Database connection error for Eloquent: " . $e->getMessage());
}
?>