<!-- filepath: c:\xampp\htdocs\php-blood-donation-system\app\views\donation_units\create.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Donation Unit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/styles.css">
    <style>
        :root {
            --primary-blue: #1a75ff;
            --deep-blue: #0056b3;
            --light-blue: #e6f0ff;
            --blood-red: #e63946;
            --soft-red: #ffebee;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e6f0ff 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 1rem;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .card-header {
            background-color: var(--primary-blue);
            color: white;
            font-weight: 600;
            padding: 1.5rem;
            border-bottom: none;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(26, 117, 255, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: var(--deep-blue);
            border-color: var(--deep-blue);
            transform: translateY(-2px);
        }
        
        .btn-outline-secondary {
            color: var(--primary-blue);
            border-color: var(--primary-blue);
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: 500;
        }
        
        .btn-outline-secondary:hover {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            color: white;
        }
        
        .page-title {
            color: var(--primary-blue);
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
        }
        
        .page-title:after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: -10px;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: var(--blood-red);
            border-radius: 2px;
        }
        
        .form-label {
            color: var(--deep-blue);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .blood-accent {
            color: var(--blood-red);
        }
        
        .input-group-text {
            background-color: var(--light-blue);
            border-color: #dee2e6;
            color: var(--deep-blue);
        }
        
        /* Responsive styles */
        @media (max-width: 576px) {
            .page-title {
                font-size: 1.8rem;
            }
            
            .card-header {
                padding: 1.25rem 1rem;
            }
            
            .card-body {
                padding: 1.25rem 1rem !important;
            }
            
            .input-group-text, .form-control {
                padding: 10px 12px;
            }
            
            .btn-primary, .btn-outline-secondary {
                padding: 10px 15px;
                font-size: 0.95rem;
            }
            
            .container {
                padding: 0 0.75rem;
            }
        }
        
        @media (min-width: 577px) and (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .container {
                padding: 0 1rem;
            }
        }
        
        @media (min-width: 992px) {
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            }
        }
        
        /* Animation for button interactions */
        @media (prefers-reduced-motion: no-preference) {
            .btn-primary, .btn-outline-secondary {
                position: relative;
                overflow: hidden;
            }
            
            .btn-primary::after, .btn-outline-secondary::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 5px;
                height: 5px;
                background: rgba(255, 255, 255, 0.5);
                opacity: 0;
                border-radius: 100%;
                transform: scale(1, 1) translate(-50%);
                transform-origin: 50% 50%;
            }
            
            .btn-primary:focus::after, .btn-outline-secondary:focus::after {
                animation: ripple 1s ease-out;
            }
            
            @keyframes ripple {
                0% {
                    transform: scale(0, 0);
                    opacity: 0.5;
                }
                100% {
                    transform: scale(20, 20);
                    opacity: 0;
                }
            }
        }
    </style>
</head>
<?php

$content = function () {
    ?>
    <div class="container-fluid px-0">
        <!-- Page Header with gradient background -->
        <div class="ant-page-header mb-4 rounded" 
            style="background: linear-gradient(120deg, var(--accent-purple), var(--accent-pink)); padding: 24px; color: white;">
            <div class="d-flex align-items-center">
                <a href="index.php?controller=DonationUnit&action=index" class="text-decoration-none text-white me-2">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="mb-0 text-white">Thêm Đơn Vị Hiến Máu Mới</h4>
                    <p class="mb-0 mt-1 text-white opacity-75">Tạo mới đơn vị hiến máu trong hệ thống</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Form Card with top border accent -->
                <div class="ant-card" style="border-top: 3px solid var(--accent-purple); box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    <div class="ant-card-body">
                        <form action="index.php?controller=DonationUnit&action=store" method="POST" class="needs-validation" novalidate>
                            <!-- Unit Name -->
                            <div class="ant-form-item mb-4">
                                <label for="name" class="ant-form-label" style="color: var(--accent-purple); font-weight: 600;">
                                    <i class="fas fa-hospital me-2"></i>Tên Đơn Vị <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="name" name="name" class="form-control custom-input" placeholder="Nhập tên đơn vị hiến máu" required>
                                <div class="invalid-feedback">Vui lòng nhập tên đơn vị hiến máu.</div>
                            </div>

                            <!-- Location -->
                            <div class="ant-form-item mb-4">
                                <label for="location" class="ant-form-label" style="color: var(--accent-purple); font-weight: 600;">
                                    <i class="fas fa-map-marker-alt me-2"></i>Địa Điểm <span class="text-danger">*</span>
                                </label>
                                <textarea id="location" name="location" class="form-control custom-input" placeholder="Nhập địa chỉ chi tiết của đơn vị hiến máu" rows="3" required></textarea>
                                <div class="invalid-feedback">Vui lòng nhập địa điểm đơn vị hiến máu.</div>
                            </div>

                            <div class="row">
                                <!-- Phone -->
                                <div class="col-md-6">
                                    <div class="ant-form-item mb-4">
                                        <label for="phone" class="ant-form-label" style="color: var(--accent-purple); font-weight: 600;">
                                            <i class="fas fa-phone-alt me-2"></i>Số Điện Thoại <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="tel" id="phone" name="phone" class="form-control custom-input" placeholder="Nhập số điện thoại liên hệ" required>
                                        </div>
                                        <div class="invalid-feedback">Vui lòng nhập số điện thoại hợp lệ.</div>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="ant-form-item mb-4">
                                        <label for="email" class="ant-form-label" style="color: var(--accent-purple); font-weight: 600;">
                                            <i class="fas fa-envelope me-2"></i>Email <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-at"></i></span>
                                            <input type="email" id="email" name="email" class="form-control custom-input" placeholder="Nhập địa chỉ email" required>
                                        </div>
                                        <div class="invalid-feedback">Vui lòng nhập email hợp lệ.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions with gradient buttons -->
                            <div class="d-flex justify-content-between border-top pt-4 mt-4">
                                <a href="index.php?controller=DonationUnit&action=index" class="btn-custom btn-custom-default">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                                </a>
                                <div>
                                    <button type="reset" class="btn-custom btn-custom-default me-2">
                                        <i class="fas fa-redo-alt me-2"></i>Làm mới
                                    </button>
                                    <button type="submit" class="btn-custom btn-custom-primary">
                                        <i class="fas fa-save me-2"></i>Lưu đơn vị
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Information Card -->
            <div class="col-lg-4">
                <div class="ant-card" style="border: none; border-radius: 15px; background: linear-gradient(145deg, #f7f5ff, #f0e6ff); box-shadow: 0 10px 20px rgba(142, 68, 173, 0.1);">
                    <div class="ant-card-head" style="background: transparent; border-bottom: none;">
                        <div class="ant-card-head-title" style="color: var(--accent-purple);">
                            <i class="fas fa-info-circle me-2"></i>Thông tin
                        </div>
                    </div>
                    <div class="ant-card-body">
                        <div class="help-item mb-4 pb-3 border-bottom" style="border-color: rgba(142, 68, 173, 0.2) !important;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="help-icon">
                                    <i class="fas fa-hospital-alt"></i>
                                </div>
                                <h6 class="fw-bold mb-0" style="color: var(--accent-purple);">Đơn vị hiến máu là gì?</h6>
                            </div>
                            <p class="text-muted mb-0 small">
                                Đơn vị hiến máu là các tổ chức, bệnh viện hoặc trung tâm y tế tham gia vào việc thu nhận, lưu trữ và cung cấp máu cho nhu cầu y tế. Các đơn vị này đóng vai trò quan trọng trong hệ thống hiến máu.
                            </p>
                        </div>
                        <div class="help-item mb-4 pb-3 border-bottom" style="border-color: rgba(142, 68, 173, 0.2) !important;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="help-icon">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <h6 class="fw-bold mb-0" style="color: var(--accent-purple);">Thông tin cần thiết</h6>
                            </div>
                            <p class="text-muted mb-0 small">
                                Đảm bảo cung cấp đầy đủ thông tin liên lạc chính xác của đơn vị hiến máu để người dùng có thể dễ dàng liên hệ khi cần thiết.
                            </p>
                        </div>
                        <div class="help-item">
                            <div class="d-flex align-items-center mb-2">
                                <div class="help-icon">
                                    <i class="fas fa-link"></i>
                                </div>
                                <h6 class="fw-bold mb-0" style="color: var(--accent-purple);">Tích hợp</h6>
                            </div>
                            <p class="text-muted mb-0 small">
                                Sau khi tạo đơn vị hiến máu, bạn có thể liên kết nó với các sự kiện hiến máu hoặc các hoạt động khác trong hệ thống.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
:root {
    --accent-purple: #8e44ad;
    --accent-pink: #e84393;
}

/* Form elements styling */
.ant-form-label {
    margin-bottom: 8px;
    font-weight: 500;
}

.custom-input {
    border-radius: 10px;
    border-color: #e2e8f0;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.custom-input:hover {
    border-color: var(--accent-purple);
    box-shadow: 0 2px 4px rgba(142, 68, 173, 0.1);
}

.custom-input:focus {
    border-color: var(--accent-purple);
    box-shadow: 0 0 0 3px rgba(142, 68, 173, 0.15);
}

.input-group-text {
    background-color: #f7f5ff;
    border-color: #e2e8f0;
    color: var(--accent-purple);
}

/* Custom button styles */
.btn-custom {
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}

.btn-custom-primary {
    background: linear-gradient(120deg, var(--accent-purple), var(--accent-pink));
    border: none;
    color: white;
    box-shadow: 0 4px 10px rgba(142, 68, 173, 0.3);
}

.btn-custom-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(142, 68, 173, 0.4);
}

.btn-custom-default {
    background: white;
    border: 1px solid #e2e8f0;
    color: var(--text-color);
}

.btn-custom-default:hover {
    border-color: var(--accent-purple);
    color: var(--accent-purple);
    background-color: #f8faff;
    transform: translateY(-2px);
}

/* Help icon styles */
.help-icon {
    width: 32px;
    height: 32px;
    background: linear-gradient(120deg, var(--accent-purple), var(--accent-pink));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}

/* Hover effect for help items */
.help-item {
    transition: all 0.3s ease;
}

.help-item:hover {
    transform: translateX(5px);
}

/* Animation for validation */
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.shake-animation {
    animation: shake 0.5s ease-in-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';
    
    const form = document.querySelector('.needs-validation');
    
    // Form validation with enhanced UI feedback
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            
            // Add shake animation to invalid fields
            const invalidFields = form.querySelectorAll(':invalid');
            invalidFields.forEach(field => {
                field.classList.add('shake-animation');
                setTimeout(() => field.classList.remove('shake-animation'), 1000);
            });
        }
        
        form.classList.add('was-validated');
    }, false);
});
</script>

<?php
}; // End of content function

// Include the admin layout
include_once __DIR__ . '/../layouts/AdminLayout/AdminLayout.php';
?>