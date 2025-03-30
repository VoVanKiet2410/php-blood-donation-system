<?php
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
$id = isset($_GET['id']) ? $_GET['id'] : null;

try {
    switch ($controller) {
        case 'Auth':
            $authController = new AuthController($mysqli);
            if (method_exists($authController, $action)) {
                $authController->$action();
            } else {
                $authController->login();
            }
            break;

        case 'User':
            $userController = new UserController($mysqli);
            if ($action === 'edit' || $action === 'delete' || $action === 'update') {
                if ($id === null) {
                    throw new Exception('ID is required');
                }
                $userController->$action($id);
            } else {
                if (method_exists($userController, $action)) {
                    $userController->$action();
                } else {
                    $userController->index();
                }
            }
            break;

        case 'Appointment':
            $appointmentController = new AppointmentController($mysqli);
            if (method_exists($appointmentController, $action)) {
                $appointmentController->$action();
            } else {
                $appointmentController->index();
            }
            break;

        case 'BloodInventory':
            $bloodInventoryController = new BloodInventoryController($mysqli);
            if (method_exists($bloodInventoryController, $action)) {
                $bloodInventoryController->$action();
            } else {
                $bloodInventoryController->index();
            }
            break;

        case 'DonationUnit':
            $donationUnitController = new DonationUnitController($mysqli);
            if (method_exists($donationUnitController, $action)) {
                $donationUnitController->$action();
            } else {
                $donationUnitController->index();
            }
            break;

        case 'Event':
            $eventController = new EventController($mysqli);
            if (method_exists($eventController, $action)) {
                $eventController->$action();
            } else {
                $eventController->index();
            }
            break;

        case 'Faq':
            $faqController = new FaqController($mysqli);
            if (method_exists($faqController, $action)) {
                $faqController->$action();
            } else {
                $faqController->index();
            }
            break;

        case 'Healthcheck':
            $healthcheckController = new HealthcheckController($mysqli);
            if (method_exists($healthcheckController, $action)) {
                $healthcheckController->$action();
            } else {
                $healthcheckController->index();
            }
            break;

        case 'News':
            $newsController = new NewsController($mysqli);
            if (method_exists($newsController, $action)) {
                $newsController->$action();
            } else {
                $newsController->index();
            }
            break;

        case 'PasswordReset':
            $passwordResetController = new PasswordResetController($mysqli);
            if (method_exists($passwordResetController, $action)) {
                $passwordResetController->$action();
            } else {
                $passwordResetController->request();
            }
            break;

        default:
            $authController = new AuthController($mysqli);
            $authController->login();
            break;
    }
} catch (Exception $e) {
    // Handle error
    die("Error: " . $e->getMessage());
}
