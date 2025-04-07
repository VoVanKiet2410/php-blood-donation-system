<?php
require_once __DIR__ . '/../../../../config/routes.php';

// Define BASE_URL constant if not already defined
if (!defined('BASE_URL')) {
    define('BASE_URL', '/php-blood-donation-system');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Trang không tìm thấy</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow-sm p-5 text-center" style="max-width: 500px;">
            <div class="mb-4">
                <img src="<?= BASE_URL ?>/public/images/logo-hutech.png" alt="Logo" class="img-fluid" style="max-height: 80px;">
            </div>
            
            <h1 class="display-1 text-danger fw-bold">404</h1>
            <h2 class="fs-3 mb-3">Trang không tìm thấy</h2>
            
            <p class="text-muted mb-4">
                Xin lỗi, trang bạn đang tìm kiếm không tồn tại hoặc đã bị di chuyển.
            </p>
            
            <div class="d-grid gap-3">
                <a href="<?= HOME_ROUTE ?>" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>Quay về trang chủ
                </a>
                <button onclick="history.back()" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại trang trước
                </button>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
