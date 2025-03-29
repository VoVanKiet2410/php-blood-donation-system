<?php
// routes.php

require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/AppointmentController.php';
require_once 'app/controllers/BloodInventoryController.php';
require_once 'app/controllers/DonationUnitController.php';
require_once 'app/controllers/EventController.php';
require_once 'app/controllers/FaqController.php';
require_once 'app/controllers/HealthcheckController.php';
require_once 'app/controllers/NewsController.php';
require_once 'app/controllers/PasswordResetController.php';

// Initialize controllers
$authController = new AuthController();
$userController = new UserController();
$appointmentController = new AppointmentController();
$bloodInventoryController = new BloodInventoryController();
$donationUnitController = new DonationUnitController();
$eventController = new EventController();
$faqController = new FaqController();
$healthcheckController = new HealthcheckController();
$newsController = new NewsController();
$passwordResetController = new PasswordResetController();

// Define routes
$routes = [
    // Authentication routes
    'GET' => [
        '/' => [$authController, 'showLogin'],
        '/register' => [$authController, 'showRegister'],
        '/reset_password' => [$authController, 'showResetPassword'],
    ],
    'POST' => [
        '/login' => [$authController, 'login'],
        '/register' => [$authController, 'register'],
        '/reset_password' => [$authController, 'resetPassword'],
    ],

    // User routes
    'GET' => [
        '/users' => [$userController, 'index'],
        '/users/create' => [$userController, 'create'],
        '/users/edit/{id}' => [$userController, 'edit'],
    ],
    'POST' => [
        '/users/store' => [$userController, 'store'],
        '/users/update/{id}' => [$userController, 'update'],
        '/users/delete/{id}' => [$userController, 'delete'],
    ],

    // Appointment routes
    'GET' => [
        '/appointments' => [$appointmentController, 'index'],
        '/appointments/create' => [$appointmentController, 'create'],
        '/appointments/edit/{id}' => [$appointmentController, 'edit'],
    ],
    'POST' => [
        '/appointments/store' => [$appointmentController, 'store'],
        '/appointments/update/{id}' => [$appointmentController, 'update'],
        '/appointments/delete/{id}' => [$appointmentController, 'delete'],
    ],

    // Blood Inventory routes
    'GET' => [
        '/blood_inventory' => [$bloodInventoryController, 'index'],
        '/blood_inventory/create' => [$bloodInventoryController, 'create'],
        '/blood_inventory/edit/{id}' => [$bloodInventoryController, 'edit'],
    ],
    'POST' => [
        '/blood_inventory/store' => [$bloodInventoryController, 'store'],
        '/blood_inventory/update/{id}' => [$bloodInventoryController, 'update'],
        '/blood_inventory/delete/{id}' => [$bloodInventoryController, 'delete'],
    ],

    // Donation Unit routes
    'GET' => [
        '/donation_units' => [$donationUnitController, 'index'],
        '/donation_units/create' => [$donationUnitController, 'create'],
        '/donation_units/edit/{id}' => [$donationUnitController, 'edit'],
    ],
    'POST' => [
        '/donation_units/store' => [$donationUnitController, 'store'],
        '/donation_units/update/{id}' => [$donationUnitController, 'update'],
        '/donation_units/delete/{id}' => [$donationUnitController, 'delete'],
    ],

    // Event routes
    'GET' => [
        '/events' => [$eventController, 'index'],
        '/events/create' => [$eventController, 'create'],
        '/events/edit/{id}' => [$eventController, 'edit'],
    ],
    'POST' => [
        '/events/store' => [$eventController, 'store'],
        '/events/update/{id}' => [$eventController, 'update'],
        '/events/delete/{id}' => [$eventController, 'delete'],
    ],

    // FAQ routes
    'GET' => [
        '/faqs' => [$faqController, 'index'],
        '/faqs/create' => [$faqController, 'create'],
        '/faqs/edit/{id}' => [$faqController, 'edit'],
    ],
    'POST' => [
        '/faqs/store' => [$faqController, 'store'],
        '/faqs/update/{id}' => [$faqController, 'update'],
        '/faqs/delete/{id}' => [$faqController, 'delete'],
    ],

    // Healthcheck routes
    'GET' => [
        '/healthchecks' => [$healthcheckController, 'index'],
        '/healthchecks/create' => [$healthcheckController, 'create'],
        '/healthchecks/edit/{id}' => [$healthcheckController, 'edit'],
    ],
    'POST' => [
        '/healthchecks/store' => [$healthcheckController, 'store'],
        '/healthchecks/update/{id}' => [$healthcheckController, 'update'],
        '/healthchecks/delete/{id}' => [$healthcheckController, 'delete'],
    ],

    // News routes
    'GET' => [
        '/news' => [$newsController, 'index'],
        '/news/create' => [$newsController, 'create'],
        '/news/edit/{id}' => [$newsController, 'edit'],
    ],
    'POST' => [
        '/news/store' => [$newsController, 'store'],
        '/news/update/{id}' => [$newsController, 'update'],
        '/news/delete/{id}' => [$newsController, 'delete'],
    ],
];

// Route handling logic
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

// Simple routing mechanism
foreach ($routes as $method => $route) {
    if ($requestMethod === $method) {
        foreach ($route as $uri => $action) {
            if (preg_match("#^$uri$#", $requestUri, $matches)) {
                array_shift($matches); // Remove the full match
                call_user_func_array($action, $matches);
                exit;
            }
        }
    }
}

// Handle 404 Not Found
http_response_code(404);
echo "404 Not Found";
?>