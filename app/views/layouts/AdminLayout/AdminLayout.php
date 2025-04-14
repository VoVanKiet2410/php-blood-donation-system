<?php
// This file should not produce any output before potential header() calls
// Start the session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define routes constants
require_once __DIR__ . '/../../../../config/routes.php';

// Define BASE_URL constant if not already defined
if (!defined('BASE_URL')) {
    define('BASE_URL', '/php-blood-donation-system');
}

// Check if user is logged in and has admin rights - no output before this!
if (!isset($_SESSION['username']) || $_SESSION['user_role'] !== 'ADMIN') {
    // Use an alternate approach that doesn't rely on header redirects if headers were already sent
    if (headers_sent()) {
        echo '<script>window.location.href="' . LOGIN_ROUTE . '";</script>';
        echo '<noscript><meta http-equiv="refresh" content="0;url=' . LOGIN_ROUTE . '"></noscript>';
        exit;
    } else {
        header('Location: ' . LOGIN_ROUTE);
        exit;
    }
}

// Get current page for menu highlighting
$current_page = $_SERVER['REQUEST_URI'];
$current_controller = '';

// Extract controller from URL for better menu highlighting
if (preg_match('/controller=([^&]+)/', $current_page, $matches)) {
    $current_controller = strtolower($matches[1]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Blood Donation System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Ant Design CSS -->
    <link href="https://cdn.jsdelivr.net/npm/antd@5.8.4/dist/reset.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin.css">

    <link rel="icon" href="<?= BASE_URL ?>/images/logo-hutech-short.png" type="image/x-icon">
    <style>
    </style>
</head>

<body>
    <!-- Header -->
    <header class="app-header">
        <div class="d-flex align-items-center">
            <button class="mobile-menu-toggle me-3" data-bs-toggle="sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <div class="header-brand">
                <img src="<?= BASE_URL ?>/images/logo-hutech.png" alt="Logo">
                <span>Quản Lý Hiến Máu</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="user-menu dropdown">
                <div class="d-flex align-items-center" data-bs-toggle="dropdown">
                    <div class="user-avatar"><?= substr($_SESSION['username'] ?? 'A', 0, 1) ?></div>
                    <div class="user-info ms-2">
                        <div class="user-name"><?= $_SESSION['username'] ?? 'Admin' ?></div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li>
                        <a class="dropdown-item" href="<?= PROFILE_ROUTE ?>">
                            <i class="fas fa-user me-2"></i>Thông tin cá nhân
                        </a>
                    </li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Cài đặt</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="<?= LOGOUT_ROUTE ?>"><i
                                class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="app-sidebar">
        <nav class="sidebar-menu">
            <div class="menu-item">
                <a href="<?= DASHBOARD_ROUTE ?>"
                    class="menu-link <?= (strpos($current_page, 'adminDashboard') !== false || $current_controller == 'User') ? 'active' : '' ?>">
                    <i class="menu-icon fas fa-tachometer-alt"></i>
                    <span>Tổng quan</span>
                </a>
            </div>

            <div class="menu-category">Quản lý hiến máu</div>

            <div class="menu-item">
                <a href="index.php?controller=BloodInventory&action=index"
                    class="menu-link <?= ($current_controller == 'bloodinventory') ? 'active' : '' ?>">
                    <i class="menu-icon fas fa-warehouse"></i>
                    <span>Quản lý máu</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="index.php?controller=Appointment&action=AdminIndex"
                    class="menu-link <?= ($current_controller == 'appointment') ? 'active' : '' ?>">
                    <i class="menu-icon fas fa-vial"></i>
                    <span>Lịch hẹn hiến máu</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="index.php?controller=DonationUnit&action=index"
                    class="menu-link <?= ($current_controller == 'donationunit') ? 'active' : '' ?>">
                    <i class="menu-icon fas fa-hospital"></i>
                    <span>Đơn vị hiến máu</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="index.php?controller=Event&action=AdminIndex"
                    class="menu-link <?= ($current_controller == 'event') ? 'active' : '' ?>">
                    <i class="menu-icon fas fa-calendar-day"></i>
                    <span>Sự kiện hiến máu</span>
                </a>
            </div>

            <div class="menu-category">Kiểm tra</div>

            <div class="menu-item">
                <a href="<?= HEALTH_CHECK_ROUTE ?>"
                    class="menu-link <?= (strpos($current_page, 'healthcheck') !== false || $current_controller == 'healthcheck') ? 'active' : '' ?>">
                    <i class="menu-icon fas fa-heartbeat"></i>
                    <span>Kiểm tra sức khỏe</span>
                </a>
            </div>

            <div class="menu-category">Nội dung</div>

            <div class="menu-item">
                <a href="index.php?controller=NewsAdmin&action=index"
                    class="menu-link <?= ($current_controller == 'newsadmin') ? 'active' : '' ?>">
                    <i class="menu-icon fas fa-newspaper"></i>
                    <span>Tin tức</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="index.php?controller=FAQAdmin&action=index"
                    class="menu-link <?= ($current_controller == 'faqadmin') ? 'active' : '' ?>">
                    <i class="menu-icon fas fa-question-circle"></i>
                    <span>FAQ</span>
                </a>
            </div>

            <div class="menu-category">Hệ thống</div>

            <div class="menu-item">
                <a href="<?= PROFILE_ROUTE ?>"
                    class="menu-link <?= (strpos($current_page, 'profile') !== false && $current_controller == 'user') ? 'active' : '' ?>">
                    <i class="menu-icon fas fa-users"></i>
                    <span>Người dùng</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="index.php?controller=UserAdmin&action=index"
                    class="menu-link <?= ($current_controller == 'useradmin') ? 'active' : '' ?>">
                    <i class="menu-icon fas fa-users"></i>
                    <span>Quản lý người dùng</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="app-content">
        <?php
        if (is_callable($content)) {
            $content($data ?? []);
        } else {
            include_once $content;
        }
        ?>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Ant Design JS - Not using the full JS library just for styling -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const sidebarToggle = document.querySelector('[data-bs-toggle="sidebar"]');
            const sidebar = document.querySelector('.app-sidebar');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('show');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 768 &&
                    !e.target.closest('.app-sidebar') &&
                    !e.target.closest('[data-bs-toggle="sidebar"]') &&
                    sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>
</body>

</html>