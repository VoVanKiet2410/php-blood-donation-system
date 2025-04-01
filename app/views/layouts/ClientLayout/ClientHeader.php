<?php
// Include session management
require_once __DIR__ . '/../../../../config/session.php';

// Include routes constants
require_once __DIR__ . '/../../../../config/routes.php';

// Define BASE_URL constant if not already defined
if (!defined('BASE_URL')) {
    define('BASE_URL', '/php-blood-donation-system');
}

// Check if user is logged in
$isAuthenticated = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$userName = $isAuthenticated ? $_SESSION['username'] : '';

// Get current URL for active navigation
$current_url = $_SERVER['REQUEST_URI'];

function renderNavLink($route, $label, $current_url) {
    $activeClass = strpos($current_url, $route) !== false ? 'active fw-bold' : '';
    echo "<li class='nav-item'><a class='nav-link {$activeClass}' href='{$route}'>{$label}</a></li>";
}
?>

<!-- Header Top -->
<div class="container-fluid bg-light py-2">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4">
                <a href="#" class="text-decoration-none fw-bold me-2">VN</a> |
                <a href="#" class="text-decoration-none text-muted fw-bold ms-2">EN</a>
            </div>
            <div class="col-md-4 text-center">
                <a href="<?= HOME_ROUTE ?>">
                    <img src="<?= BASE_URL ?>/images/logo-hutech.png" alt="Logo" class="img-fluid"
                        style="height: 50px;">
                </a>
            </div>
            <div class="col-md-4 text-end">
                <?php if ($isAuthenticated): ?>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <?= htmlspecialchars($userName) ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="<?= PROFILE_ROUTE ?>">Thông tin cá nhân</a></li>
                        <li><a class="dropdown-item" href="<?= SETTINGS_ROUTE ?>">Thiết lập cá nhân</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= LOGOUT_ROUTE ?>">Đăng xuất tài khoản</a></li>
                    </ul>
                </div>
                <?php else: ?>
                <a href="<?= LOGIN_ROUTE ?>" class="btn btn-outline-primary me-2">Đăng nhập</a>
                <a href="<?= REGISTER_ROUTE ?>" class="btn btn-outline-success">Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarMain">
            <ul class="navbar-nav">
                <?php renderNavLink(HOME_ROUTE, 'TRANG CHỦ', $current_url); ?>
                <?php renderNavLink(CLIENT_EVENT_ROUTE, 'SỰ KIỆN HIẾN MÁU', $current_url); ?>
                <?php if ($isAuthenticated): ?>
                <?php renderNavLink(APPOINTMENTS_ROUTE, 'LỊCH HẸN CỦA BẠN', $current_url); ?>
                <?php renderNavLink(HISTORYAPPOINT_ROUTE, 'LỊCH SỬ ĐẶT HẸN', $current_url); ?>
                <?php renderNavLink(CERTIFICATE_ROUTE, 'CHỨNG NHẬN', $current_url); ?>
                <?php endif; ?>
                <?php renderNavLink(FAQ_ROUTE, 'HỎI - ĐÁP', $current_url); ?>
                <?php renderNavLink(NEWS_ROUTE, 'TIN TỨC', $current_url); ?>
                <?php renderNavLink(CONTACT_ROUTE, 'LIÊN HỆ', $current_url); ?>
            </ul>
        </div>
    </div>
</nav>