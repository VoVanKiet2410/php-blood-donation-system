<?php
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

session_start();

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
        if (method_exists($userController, $action)) {
            $userController->$action();
        } else {
            $userController->index();
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
?>
