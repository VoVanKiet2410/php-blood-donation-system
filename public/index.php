<?php

require_once '../vendor/autoload.php';
require_once '../config/database.php'; // Include the database configuration

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Create logs directory if it doesn't exist
$logDir = dirname(__DIR__) . '/logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0777, true);
}

// Log errors to a file
ini_set('log_errors', 1);
ini_set('error_log', $logDir . '/php_errors.log');

// Include session configuration BEFORE starting the session
require_once '../config/session.php';
// session_start() is now in session.php

// Define base URL to use across the application
define('BASE_URL', '/php-blood-donation-system/public');

require_once '../config/database.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/AppointmentController.php';
require_once '../app/controllers/BloodInventoryController.php';
require_once '../app/controllers/DonationUnitController.php';
require_once '../app/controllers/EventController.php';
require_once '../app/controllers/FaqController.php';
require_once '../app/controllers/HealthcheckController.php';
require_once '../app/controllers/NewsController.php';
require_once '../app/controllers/PasswordResetController.php';

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\AppointmentController;
use App\Controllers\BloodInventoryController;
use App\Controllers\DonationUnitController;
use App\Controllers\EventController;
use App\Controllers\FaqController;
use App\Controllers\HealthcheckController;
use App\Controllers\NewsController;
use App\Controllers\PasswordResetController;

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

try {
    $controllerClass = "App\\Controllers\\{$controller}Controller";
    if (class_exists($controllerClass)) {
        $controllerInstance = new $controllerClass($mysqli);
        if (method_exists($controllerInstance, $action)) {
            $controllerInstance->$action();
        } else {
            throw new Exception("Action '{$action}' not found in {$controllerClass}");
        }
    } else {
        throw new Exception("Controller '{$controller}' not found");
    }
} catch (\Exception $e) {
    error_log("Error in controller: " . $e->getMessage());
    http_response_code(500);
    echo "An error occurred. Please check the error log for details.";
}
?>