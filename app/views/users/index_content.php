<?php
// This file contains only the content part of the user profile
// It's designed to be included by both client and admin layouts
?>
<div class="container-fluid py-4">
    <!-- Page Header with gradient background -->
    <div class="ant-page-header mb-4 rounded"
        style="background: linear-gradient(120deg, #4a6cf7, #6a75ca); padding: 24px; color: white;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 text-white">Hồ Sơ Người Dùng</h4>
                <p class="mb-0 mt-1 text-white opacity-75">Thông tin cá nhân và các tùy chọn quản lý</p>
            </div>
            <div>
                <a href="<?= BASE_URL ?>/index.php?controller=User&action=editProfile" class="btn text-white"
                    style="background-color: rgba(255,255,255,0.2);">
                    <i class="fas fa-user-edit me-2"></i>Chỉnh sửa thông tin
                </a>
            </div>
        </div>
    </div>

    <!-- User Information Card -->
    <div class="row g-4 py-3">
        <div class="col-lg-8">
            <div class="ant-card mb-4" style="border-top: 3px solid #4a6cf7; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                <div class="ant-card-head">
                    <div class="ant-card-head-title">
                        <i class="fas fa-user me-2" style="color: #4a6cf7;"></i>Thông Tin Cá Nhân
                    </div>
                </div>
                <div class="ant-card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="info-label">CCCD/CMND</label>
                            <div class="info-value fw-bold">
                                <?= htmlspecialchars($user['cccd'] ?? 'Chưa cung cấp') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="info-label">Họ và tên</label>
                            <div class="info-value">
                                <?= htmlspecialchars($user['full_name'] ?? 'Chưa cung cấp') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="info-label">Email</label>
                            <div class="info-value">
                                <?= htmlspecialchars($user['email'] ?? 'Chưa cung cấp') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="info-label">Số điện thoại</label>
                            <div class="info-value">
                                <?= htmlspecialchars($user['phone'] ?? 'Chưa cung cấp') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="info-label">Địa chỉ</label>
                            <div class="info-value">
                                <?= htmlspecialchars($user['address'] ?? 'Chưa cung cấp') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="info-label">Ngày sinh</label>
                            <div class="info-value">
                                <?php if (isset($user['dob'])): ?>
                                    <?= date('d/m/Y', strtotime($user['dob'])) ?>
                                <?php else: ?>
                                    Chưa cung cấp
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="info-label">Giới tính</label>
                            <div class="info-value">
                                <?= isset($user['sex']) ? ($user['sex'] == 'male' ? 'Nam' : 'Nữ') : 'Chưa cung cấp' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Card -->
        <div class="col-lg-4">
            <div class="ant-card mb-4">
                <div class="ant-card-head">
                    <div class="ant-card-head-title">
                        <i class="fas fa-bolt me-2" style="color: #ffc107;"></i>Thao Tác Nhanh
                    </div>
                </div>
                <div class="ant-card-body">
                    <div class="d-grid gap-3">
                        <a href="<?= BASE_URL ?>/index.php?controller=Event&action=clientIndex"
                            class="btn btn-outline-primary w-100 text-start">
                            <i class="fas fa-calendar-day me-2"></i>Xem Sự Kiện Hiến Máu
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?controller=Appointment&action=index"
                            class="btn btn-outline-success w-100 text-start">
                            <i class="fas fa-calendar-check me-2"></i>Lịch Hẹn Của Tôi
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?controller=BloodDonationHistory&action=userHistory"
                            class="btn btn-outline-danger w-100 text-start">
                            <i class="fas fa-history me-2"></i>Lịch Sử Hiến Máu
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?controller=Faq&action=index"
                            class="btn btn-outline-info w-100 text-start">
                            <i class="fas fa-question-circle me-2"></i>FAQ Hiến Máu
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?controller=News&action=index"
                            class="btn btn-outline-secondary w-100 text-start">
                            <i class="fas fa-newspaper me-2"></i>Tin Tức
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?controller=Auth&action=logout"
                            class="btn btn-outline-dark w-100 text-start">
                            <i class="fas fa-sign-out-alt me-2"></i>Đăng Xuất
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styling for user profile */
    .info-label {
        display: block;
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 1rem;
        color: #343a40;
        margin-bottom: 10px;
    }

    /* Button hover effects */
    .btn-outline-primary,
    .btn-outline-success,
    .btn-outline-danger,
    .btn-outline-info,
    .btn-outline-secondary,
    .btn-outline-dark {
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover,
    .btn-outline-success:hover,
    .btn-outline-danger:hover,
    .btn-outline-info:hover,
    .btn-outline-secondary:hover,
    .btn-outline-dark:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>