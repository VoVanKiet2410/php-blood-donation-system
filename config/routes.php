<?php

/**
 * Constants for all routes in the application
 * This avoids hardcoding routes in multiple files and makes route changes easier
 */
if (!defined('BASE_URL')) {
    define('BASE_URL', '/php-blood-donation-system');
}
//Home
define('HOME', BASE_URL . '/index.php?controller=Home&action=index');
// Authentication routes
define('HOME_ROUTE', BASE_URL . '/index.php?controller=Home&action=index');
define('LOGIN_ROUTE', BASE_URL . '/index.php?controller=Auth&action=login');
define('REGISTER_ROUTE', BASE_URL . '/index.php?controller=Auth&action=register');
define('LOGOUT_ROUTE', BASE_URL . '/index.php?controller=Auth&action=logout');
define('RESET_PASSWORD_ROUTE', BASE_URL . '/index.php?controller=PasswordReset&action=request');

// Admin routes
define('DASHBOARD_ROUTE', '?controller=Admin&action=index');
define('USER_ROUTE', '?controller=User&action=adminIndex');
define('BLOOD_DONATION_HISTORY_ROUTE', '?controller=BloodInventory&action=adminIndex');
define('EVENT_BLOOD_DONATION_ROUTE', '?controller=Event&action=adminIndex');
define('EVENT_BLOOD_DONATION_ADD_ROUTE', '?controller=Event&action=adminCreate');
define('HEALTH_CHECK_ROUTE', '?controller=Healthcheck&action=adminIndex');

// Client-side routes
define('CLIENT_EVENT_ROUTE', BASE_URL . '/index.php?controller=Event&action=clientIndex');
define('EVENT_BOOKING_ROUTE', BASE_URL . '/index.php?controller=Event&action=bookAppointment');
define('APPOINTMENT_CREATE_ROUTE', BASE_URL . '/index.php?controller=Appointment&action=create');

// Additional client-side routes needed for navigation
define('APPOINTMENTS_ROUTE', BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
define('HISTORYAPPOINT_ROUTE', BASE_URL . '/index.php?controller=Appointment&action=viewAppointment');
define('CERTIFICATE_ROUTE', BASE_URL . '/index.php?controller=Certificate&action=index');
define('FAQ_ROUTE', BASE_URL . '/index.php?controller=Faq&action=ClientIndex');
define('NEWS_ROUTE', BASE_URL . '/index.php?controller=News&action=index');
define('CONTACT_ROUTE', BASE_URL . '/index.php?controller=Contact&action=index');
define('PROFILE_ROUTE', BASE_URL . '/index.php?controller=User&action=profile');
define('SETTINGS_ROUTE', BASE_URL . '/index.php?controller=User&action=settings');
