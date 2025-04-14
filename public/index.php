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

require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/AppointmentController.php';
require_once '../app/controllers/admin/AppointmentController.php';
require_once '../app/controllers/BloodInventoryController.php';
require_once '../app/controllers/admin/BloodDonationUnits/DonationUnitController.php';
require_once '../app/controllers/EventController.php';
require_once '../app/controllers/FaqController.php';
require_once '../app/controllers/HealthcheckController.php';
require_once '../app/controllers/NewsController.php';
require_once '../app/controllers/PasswordResetController.php';
require_once '../app/controllers/BloodDonationHistoryController.php';
require_once '../app/controllers/NewsAdmin.php';
require_once '../app/controllers/FAQAdmin.php';

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\AppointmentController;
use App\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Controllers\BloodInventoryController;
use App\Controllers\DonationUnitController;
use App\Controllers\EventController;
use App\Controllers\FaqController;
use App\Controllers\HealthcheckController;
use App\Controllers\NewsController;
use App\Controllers\PasswordResetController;
use App\Controllers\BloodDonationHistoryController;
use App\Controllers\NewsAdmin;
use App\Controllers\FAQAdmin;
use App\Controllers\HomeController;

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'Auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

try {
    switch ($controller) {
        case 'Home':
            $homeController = new HomeController($mysqli);
            if (method_exists($homeController, $action)) {
                $homeController->$action();
            } else {
                $homeController->index();
            }
            break;
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
            // Check if the action is specifically for admin
            $isAdminAction = in_array($action, ['AdminIndex', 'admin', 'index', 'create', 'edit', 'update', 'delete', 'store']);

            // Handle special case for AdminIndex which should map to index in admin controller
            if ($action == 'AdminIndex') {
                $action = 'index';
            }

            // Map client-specific actions to their method names in the client controller
            $clientActionMap = [
                'create' => 'clientCreate',
                'store' => 'clientStore',
                'clientCreate' => 'clientCreate',
                'clientStore' => 'clientStore',
                'userAppointments' => 'userAppointments',
                'viewAppointment' => 'viewAppointment',
                'cancelAppointment' => 'cancelAppointment',
            ];

            // Determine if user is admin based on session
            $isUserAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'ADMIN';

            // For admin actions, ensure the user is an admin
            if ($isAdminAction) {
                if ($isUserAdmin) {
                    // Use Admin controller for admin users
                    $appointmentController = new AdminAppointmentController($mysqli);
                    $methodToCall = $action;
                } else {
                    // Redirect non-admin users to client page
                    header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=clientIndex');
                    exit;
                }
            } else {
                // Use Client controller for client actions
                $appointmentController = new AppointmentController($mysqli);

                // Map the client action if needed
                $methodToCall = isset($clientActionMap[$action]) ? $clientActionMap[$action] : $action;
            }

            if (method_exists($appointmentController, $methodToCall)) {
                // Check if the action requires an ID parameter
                if (isset($_GET['id']) && in_array($methodToCall, ['edit', 'update', 'delete', 'adminEdit', 'adminUpdate', 'adminDelete'])) {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($methodToCall, ['update', 'adminUpdate'])) {
                        // Pass ID for update methods
                        $appointmentController->$methodToCall($_GET['id']);
                    } else {
                        // Pass ID for other methods
                        $appointmentController->$methodToCall($_GET['id']);
                    }
                } else {
                    // Call the method without parameters
                    $appointmentController->$methodToCall();
                }
            } else {
                // Default fallback action based on controller type
                if ($appointmentController instanceof AdminAppointmentController) {
                    if (method_exists($appointmentController, 'index')) {
                        $appointmentController->index();
                    } else {
                        echo "Không tìm thấy hành động mặc định cho Admin Appointment Controller";
                    }
                } else {
                    if (method_exists($appointmentController, 'clientCreate')) {
                        $appointmentController->clientCreate();
                    } else {
                        echo "Không tìm thấy hành động mặc định cho Client Appointment Controller";
                    }
                }
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
                // Kiểm tra nếu action yêu cầu tham số id
                if (isset($_GET['id'])) {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update') {
                        // Truyền cả id và dữ liệu từ $_POST cho phương thức update
                        $donationUnitController->$action($_GET['id'], $_POST);
                    } else {
                        // Truyền id cho các action khác
                        $donationUnitController->$action($_GET['id']);
                    }
                } else {
                    $donationUnitController->$action(); // Gọi action không có tham số
                }
            } else {
                $donationUnitController->index();
            }
            break;

        case 'Event':
            $eventController = new EventController($mysqli);
            if (method_exists($eventController, $action)) {
                $eventController->$action();
            } else {
                $eventController->Clientindex();
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
                $healthcheckController->adminIndex();
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

        case 'BloodDonationHistory':
            $bloodDonationHistoryController = new BloodDonationHistoryController($mysqli);
            if (method_exists($bloodDonationHistoryController, $action)) {
                if (isset($_GET['id']) && in_array($action, ['view'])) {
                    $bloodDonationHistoryController->$action($_GET['id']);
                } else {
                    $bloodDonationHistoryController->$action();
                }
            } else {
                $bloodDonationHistoryController->index();
            }
            break;

        case 'NewsAdmin':
            $newsAdminController = new NewsAdmin($mysqli);
            if (method_exists($newsAdminController, $action)) {
                if (isset($_GET['id']) && in_array($action, ['edit', 'update', 'delete', 'view'])) {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update') {
                        $newsAdminController->$action($_GET['id']);
                    } else {
                        $newsAdminController->$action($_GET['id']);
                    }
                } else {
                    $newsAdminController->$action();
                }
            } else {
                $newsAdminController->index();
            }
            break;

        case 'FAQAdmin':
            $faqAdminController = new FAQAdmin($mysqli);
            if (method_exists($faqAdminController, $action)) {
                if (isset($_GET['id']) && in_array($action, ['edit', 'update', 'delete', 'view'])) {
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update') {
                        $faqAdminController->$action($_GET['id']);
                    } else {
                        $faqAdminController->$action($_GET['id']);
                    }
                } else {
                    $faqAdminController->$action();
                }
            } else {
                $faqAdminController->index();
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

        case 'UserAdmin':
            $userAdminController = new \App\Controllers\UserAdminController($mysqli);
            if (method_exists($userAdminController, $action)) {
                if (isset($_GET['cccd']) && in_array($action, ['edit', 'update', 'delete'])) {
                    $userAdminController->$action($_GET['cccd']);
                } else {
                    $userAdminController->$action();
                }
            } else {
                $userAdminController->index();
            }
            break;

        default:
            $authController = new AuthController($mysqli);
            $authController->login();
            break;
    }
} catch (\Exception $e) {
    error_log("Error in controller: " . $e->getMessage());
    http_response_code(500);
    echo "An error occurred. Please check the error log for details.";
}
