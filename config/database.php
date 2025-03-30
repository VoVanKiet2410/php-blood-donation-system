<?php
// Load environment variables
require_once __DIR__ . '/env.php';

class Database
{
    private static $instance = null;
    private static $connection = null;

    private function __construct()
    {
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'giotmauvang';

        self::$connection = new mysqli($host, $username, $password, $database);

        if (self::$connection->connect_error) {
            die("Connection failed: " . self::$connection->connect_error);
        }

        self::$connection->set_charset('utf8mb4');
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function getConnection()
    {
        if (self::$connection === null) {
            self::getInstance();
        }
        return self::$connection;
    }
}

// Tạo kết nối global
$mysqli = Database::getConnection();

// Kiểm tra kết nối
if (!$mysqli) {
    die("Connection failed: Unable to establish database connection");
}
