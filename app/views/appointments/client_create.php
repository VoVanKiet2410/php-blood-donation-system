<?php
// Define any constants needed if not defined
if (!defined('BASE_URL')) {
    define('BASE_URL', '/php-blood-donation-system');
}

// Extract data passed from controller
$event = $data['event'] ?? null;
$user = $data['user'] ?? null;
$errors = $data['errors'] ?? [];
$formData = $data['formData'] ?? [];

// Set title for the page
$title = "Đặt lịch hẹn hiến máu";
if (!$event) {
    echo '<div class="alert alert-danger">Không tìm thấy thông tin sự kiện</div>';
    return;
}

if (!$user) {
    echo '<div class="alert alert-danger">Không tìm thấy thông tin người dùng</div>';
    return;
}
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header section -->
            <div class="card mb-4 shadow-sm" style="border-top: 4px solid #dc3545;">
                <div class="card-body p-4">
                    <h2 class="fs-4 mb-3 text-danger fw-bold">Đặt lịch hẹn hiến máu</h2>
                    <p class="mb-1">Sự kiện: <strong><?= htmlspecialchars($event['name'] ?? 'N/A') ?></strong></p>
                    <p class="mb-1">Ngày diễn ra:
                        <strong><?= date('d/m/Y', strtotime($event['event_date'] ?? 'now')) ?></strong>
                    </p>
                    <p class="mb-1">Thời gian:
                        <strong>
                            <?= date('H:i', strtotime($event['event_start_time'] ?? 'now')) ?> -
                            <?= date('H:i', strtotime($event['event_end_time'] ?? 'now')) ?>
                        </strong>
                    </p>
                    <p class="mb-1">Địa điểm:
                        <strong><?= htmlspecialchars($event['donation_unit']['address'] ?? 'N/A') ?></strong>
                    </p>

                    <div class="alert alert-info mt-3 mb-0">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle fa-lg me-2"></i>
                            </div>
                            <div>
                                <p class="mb-0">Vui lòng chọn thời gian hẹn phù hợp và điền đầy đủ thông tin để hoàn tất
                                    đăng ký hiến máu.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error messages -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger mb-4">
                    <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Lỗi</h5>
                    <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Appointment Form -->
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="<?= BASE_URL ?>/index.php?controller=Appointment&action=clientStore" method="POST"
                        id="appointmentForm" class="needs-validation" novalidate>
                        <!-- Hidden event ID field -->
                        <input type="hidden" name="event_id" value="<?= $event['id'] ?? '' ?>">

                        <!-- User information (display only) -->
                        <div class="mb-4">
                            <h5 class="card-title text-primary">Thông tin người hiến</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Họ và tên:</strong>
                                        <?= htmlspecialchars($user->userInfo->full_name ?? 'N/A') ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>CCCD/CMND:</strong>
                                        <?= htmlspecialchars($user->cccd ?? 'N/A') ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Số điện thoại:</strong>
                                        <?= htmlspecialchars($user->userInfo->phone_number ?? 'N/A') ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Email:</strong>
                                        <?= htmlspecialchars($user->email ?? 'N/A') ?></p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Date and time selection -->
                        <div class="mb-4">
                            <h5 class="card-title text-primary">Lịch hẹn</h5>

                            <div class="row g-3">
                                <!-- Appointment date and time -->
                                <div class="col-md-6">
                                    <label for="appointment_date_time" class="form-label">Chọn ngày và giờ hẹn <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="appointment_date_time"
                                        name="appointment_date_time"
                                        value="<?= $formData['appointment_date_time'] ?? '' ?>"
                                        min="<?= date('Y-m-d', strtotime($event['event_date'] ?? 'now')) . 'T' . date('H:i', strtotime($event['event_start_time'] ?? 'now')) ?>"
                                        max="<?= date('Y-m-d', strtotime($event['event_date'] ?? 'now')) . 'T' . date('H:i', strtotime($event['event_end_time'] ?? 'now')) ?>"
                                        required>
                                    <div class="invalid-feedback">Vui lòng chọn ngày và giờ hẹn</div>
                                    <div class="form-text">Thời gian hẹn phải nằm trong khoảng thời gian diễn ra sự kiện
                                    </div>
                                </div>

                                <!-- Blood amount -->
                                <div class="col-md-6">
                                    <label for="blood_amount" class="form-label">Lượng máu dự kiến (ml) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="blood_amount" name="blood_amount"
                                        value="<?= $formData['blood_amount'] ?? '350' ?>" min="250" max="450" required>
                                    <div class="invalid-feedback">Lượng máu phải từ 250ml đến 450ml</div>
                                    <div class="form-text">Thông thường mỗi người sẽ hiến từ 250ml đến 450ml máu</div>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and conditions -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="acceptTerms" required>
                                <label class="form-check-label" for="acceptTerms">
                                    Tôi đồng ý với <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">điều
                                        khoản và điều kiện</a> hiến máu
                                </label>
                                <div class="invalid-feedback">
                                    Bạn phải đồng ý với điều khoản và điều kiện
                                </div>
                            </div>
                        </div>

                        <!-- Form actions -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= BASE_URL ?>/index.php?controller=Event&action=clientIndex"
                                class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calendar-check me-2"></i>Đặt lịch hẹn
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Side information -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4" style="border-top: 4px solid #20c997;">
                <div class="card-body p-4">
                    <h5 class="card-title text-success"><i class="fas fa-info-circle me-2"></i>Lưu ý khi hiến máu</h5>
                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item border-0 ps-0">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Nghỉ ngơi đầy đủ</strong> - Đảm bảo ngủ ít nhất 6 tiếng trước khi hiến máu
                        </li>
                        <li class="list-group-item border-0 ps-0">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Ăn nhẹ trước khi đến</strong> - Không nên đến hiến máu khi đói
                        </li>
                        <li class="list-group-item border-0 ps-0">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Uống nhiều nước</strong> - Uống ít nhất 2 ly nước trước khi hiến máu
                        </li>
                        <li class="list-group-item border-0 ps-0">
                            <i class="fas fa-times-circle text-danger me-2"></i>
                            <strong>Tránh rượu bia</strong> - Không uống rượu, bia trong vòng 24 giờ trước khi hiến máu
                        </li>
                        <li class="list-group-item border-0 ps-0">
                            <i class="fas fa-times-circle text-danger me-2"></i>
                            <strong>Tránh thuốc lá</strong> - Không hút thuốc ít nhất 1 giờ trước và sau khi hiến máu
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm" style="border-top: 4px solid #6f42c1;">
                <div class="card-body p-4">
                    <h5 class="card-title text-purple"><i class="fas fa-calendar-alt me-2"></i>Thông tin sự kiện</h5>
                    <div class="mt-3">
                        <p><strong>Đơn vị tiếp nhận:</strong></p>
                        <p><?= htmlspecialchars($event['donation_unit']['name'] ?? 'N/A') ?></p>
                        <p><strong>Địa chỉ:</strong></p>
                        <p><?= htmlspecialchars($event['donation_unit']['address'] ?? 'N/A') ?></p>
                        <p><strong>Số lượng đăng ký:</strong></p>
                        <div class="progress mb-2">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: <?= ($event['current_registrations'] / $event['max_registrations']) * 100 ?>%"
                                aria-valuenow="<?= $event['current_registrations'] ?>" aria-valuemin="0"
                                aria-valuemax="<?= $event['max_registrations'] ?>">
                            </div>
                        </div>
                        <small><?= $event['current_registrations'] ?> / <?= $event['max_registrations'] ?> người</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Điều khoản và điều kiện hiến máu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Điều kiện hiến máu</h6>
                <ul>
                    <li>Người hiến máu phải từ 18-60 tuổi.</li>
                    <li>Cân nặng ít nhất 50kg đối với nam và 45kg đối với nữ.</li>
                    <li>Không mắc các bệnh truyền nhiễm như viêm gan B, C, HIV, giang mai.</li>
                    <li>Không trong thời gian điều trị bệnh mạn tính.</li>
                    <li>Không tiêm vắc xin phòng bệnh trong vòng 14 ngày.</li>
                    <li>Không sử dụng rượu, bia trong vòng 24 giờ trước khi hiến máu.</li>
                    <li>Không mắc các bệnh về máu, tim mạch, huyết áp, hô hấp.</li>
                </ul>

                <h6 class="mt-3">Quy trình hiến máu</h6>
                <ol>
                    <li>Khám sàng lọc, kiểm tra huyết áp, xét nghiệm máu.</li>
                    <li>Nếu đủ điều kiện, tiến hành hiến máu (khoảng 15-20 phút).</li>
                    <li>Nghỉ ngơi và ăn nhẹ sau khi hiến máu.</li>
                </ol>

                <h6 class="mt-3">Cam kết của người hiến máu</h6>
                <p>Khi đăng ký hiến máu, tôi cam kết:</p>
                <ul>
                    <li>Thông tin cung cấp là chính xác và đầy đủ.</li>
                    <li>Đồng ý để thông tin cá nhân và kết quả xét nghiệm được lưu trữ.</li>
                    <li>Đồng ý để máu hiến được sử dụng cho mục đích điều trị.</li>
                    <li>Đồng ý để được thông báo kết quả xét nghiệm nếu có bất thường.</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

<style>
    .text-purple {
        color: #6f42c1;
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .btn-primary {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background-color: #c82333;
        border-color: #bd2130;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation
        const form = document.getElementById('appointmentForm');

        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        });

        // Modal handling for terms agreement
        const termsModal = document.getElementById('termsModal');
        const modalAgreeBtn = termsModal.querySelector('.btn-primary');
        const acceptTermsCheckbox = document.getElementById('acceptTerms');

        modalAgreeBtn.addEventListener('click', function() {
            acceptTermsCheckbox.checked = true;
            form.classList.add('was-validated');
        });
    });
</script>