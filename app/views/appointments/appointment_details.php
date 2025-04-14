<?php
// Define the title for the page
$title = "Chi tiết lịch hẹn hiến máu";

// Check if the necessary data is available
if (!isset($appointment)) {
    echo '<div class="alert alert-danger">Không thể tải thông tin lịch hẹn.</div>';
    return;
}

// Define status classes and labels
$statusClass = '';
$statusLabel = '';
$statusBadgeClass = '';

switch ($appointment->status) {
    case 0: // Pending
        $statusClass = 'warning';
        $statusBadgeClass = 'bg-warning bg-opacity-10 text-white';
        $statusLabel = 'Đang chờ xác nhận';
        break;
    case 1: // Confirmed
        $statusClass = 'primary';
        $statusBadgeClass = 'bg-white bg-opacity-10 text-white';
        $statusLabel = 'Đã xác nhận';
        break;
    case 2: // Completed
        $statusClass = 'success';
        $statusBadgeClass = 'bg-success bg-opacity-10 text-success';
        $statusLabel = 'Đã hoàn thành';
        break;
    case 3: // Canceled
        $statusClass = 'danger';
        $statusBadgeClass = 'bg-danger bg-opacity-10 text-danger';
        $statusLabel = 'Đã hủy';
        break;
    default:
        $statusClass = 'secondary';
        $statusBadgeClass = 'bg-secondary bg-opacity-10 text-secondary';
        $statusLabel = 'Không xác định';
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Back button and page header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="<?= BASE_URL ?>/index.php?controller=Appointment&action=userAppointments"
                    class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
                </a>
                <div class="text-end">
                    <?php if ($appointment->status === 0 || $appointment->status === 1): ?>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                            <i class="fas fa-times me-2"></i>Hủy lịch hẹn
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                        <div>
                            <?= $_SESSION['success_message'] ?>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-exclamation-circle fa-lg"></i>
                        </div>
                        <div>
                            <?= $_SESSION['error_message'] ?>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <!-- Appointment Invitation Card -->
            <div class="card appointment-card border-0 shadow-lg mb-4">
                <div class="appointment-card-header bg-<?= $statusClass ?> text-white">
                    <div class="container py-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="mb-0 fw-bold">
                                    <i class="fas fa-calendar-check me-2"></i>Thẻ lịch hẹn hiến máu
                                </h1>
                                <p class="mb-0 opacity-75">Mã lịch hẹn: <?= $appointment->id ?></p>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <span class="badge rounded-pill <?= $statusBadgeClass ?> py-2 px-4 fs-6">
                                    <?= $statusLabel ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <!-- Top appointment information -->
                    <div class="container py-4 border-bottom">
                        <div class="row">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <div class="d-flex align-items-center mb-3">
                                    <?php if (isset($appointment->event->donationUnit->photo_url) && !empty($appointment->event->donationUnit->photo_url)): ?>
                                        <div class="me-3">
                                            <img src="<?= htmlspecialchars($appointment->event->donationUnit->photo_url) ?>"
                                                alt="<?= htmlspecialchars($appointment->event->donationUnit->name) ?>"
                                                class="rounded-circle" width="60" height="60">
                                        </div>
                                    <?php else: ?>
                                        <div class="me-3">
                                            <div class="rounded-circle d-flex justify-content-center align-items-center bg-primary bg-opacity-10"
                                                style="width: 60px; height: 60px;">
                                                <i class="fas fa-hospital text-primary fa-2x"></i>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <h2 class="h4 mb-0 fw-bold">
                                            <?= htmlspecialchars($appointment->event->name ?? 'Không có tên sự kiện') ?>
                                        </h2>
                                        <p class="text-muted mb-0">
                                            <?= htmlspecialchars($appointment->event->donationUnit->name ?? 'Không có tên đơn vị') ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="info-container">
                                    <div class="info-item">
                                        <div class="info-icon bg-danger bg-opacity-10 text-danger">
                                            <i class="fas fa-calendar-day"></i>
                                        </div>
                                        <div class="info-content">
                                            <span class="info-label">Ngày hẹn</span>
                                            <span
                                                class="info-value"><?= date('d/m/Y', strtotime($appointment->appointment_date_time)) ?></span>
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-icon bg-danger bg-opacity-10 text-danger">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="info-content">
                                            <span class="info-label">Thời gian</span>
                                            <span
                                                class="info-value"><?= date('H:i', strtotime($appointment->appointment_date_time)) ?></span>
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-icon bg-danger bg-opacity-10 text-danger">
                                            <i class="fas fa-tint"></i>
                                        </div>
                                        <div class="info-content">
                                            <span class="info-label">Lượng máu</span>
                                            <span class="info-value"><?= $appointment->blood_amount ?> ml</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card border-0 bg-light h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div
                                                class="icon-wrapper bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-2">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                            <h5 class="mb-0">Địa điểm hiến máu</h5>
                                        </div>
                                        <p class="fw-bold mb-1">
                                            <?= htmlspecialchars($appointment->event->donationUnit->name ?? 'Không có tên đơn vị') ?>
                                        </p>
                                        <p class="mb-3">
                                            <?= htmlspecialchars($appointment->event->donationUnit->address ?? $appointment->event->donationUnit->location ?? 'Không có địa chỉ') ?>
                                        </p>

                                        <div class="map-container rounded">
                                            <!-- You can add actual map here if coordinates are available -->
                                            <div
                                                class="map-placeholder d-flex justify-content-center align-items-center border rounded p-3 bg-white text-center">
                                                <div>
                                                    <i class="fas fa-map-marked-alt text-danger fa-3x mb-2"></i>
                                                    <p class="mb-0 text-muted small">Xem bản đồ chi tiết tại trang sự
                                                        kiện</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User and appointment details -->
                    <div class="container py-4">
                        <div class="row">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <div class="card border-0 h-100">
                                    <div class="card-body">
                                        <h5 class="d-flex align-items-center mb-4">
                                            <div
                                                class="icon-wrapper bg-danger bg-opacity-10 text-danger rounded-3 p-2 me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            Thông tin người hiến
                                        </h5>

                                        <div class="row gx-3 mb-3">
                                            <div class="col-5 text-muted">Họ và tên:</div>
                                            <div class="col-7 fw-bold">
                                                <?= htmlspecialchars($user->name ?? 'Không có tên') ?></div>
                                        </div>

                                        <div class="row gx-3 mb-3">
                                            <div class="col-5 text-muted">CCCD/CMND:</div>
                                            <div class="col-7"><?= htmlspecialchars($user->cccd ?? 'Không có CCCD') ?>
                                            </div>
                                        </div>

                                        <div class="row gx-3 mb-3">
                                            <div class="col-5 text-muted">Email:</div>
                                            <div class="col-7"><?= htmlspecialchars($user->email ?? 'Không có email') ?>
                                            </div>
                                        </div>

                                        <div class="row gx-3 mb-3">
                                            <div class="col-5 text-muted">Số điện thoại:</div>
                                            <div class="col-7"><?= htmlspecialchars($user->phone ?? 'Không có SĐT') ?>
                                            </div>
                                        </div>

                                        <div class="row gx-3 mb-0">
                                            <div class="col-5 text-muted">Nhóm máu:</div>
                                            <div class="col-7">
                                                <?php if (isset($user->userInfo) && !empty($user->userInfo->blood_type)): ?>
                                                    <span
                                                        class="badge bg-danger"><?= htmlspecialchars($user->userInfo->blood_type) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">Chưa xác định</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card border-0 h-100">
                                    <div class="card-body">
                                        <h5 class="d-flex align-items-center mb-4">
                                            <div
                                                class="icon-wrapper bg-danger bg-opacity-10 text-danger rounded-3 p-2 me-2">
                                                <i class="fas fa-info-circle"></i>
                                            </div>
                                            Thông tin quan trọng
                                        </h5>

                                        <div class="alert alert-light border-start border-primary border-4">
                                            <h6 class="fw-bold mb-2">Chuẩn bị trước khi hiến máu:</h6>
                                            <ul class="mb-0 ps-3">
                                                <li>Ngủ đủ giấc, ít nhất 6 tiếng trước ngày hiến máu</li>
                                                <li>Ăn nhẹ và uống đủ nước trước khi hiến máu</li>
                                                <li>Không uống rượu, bia ít nhất 24 giờ trước khi hiến máu</li>
                                                <li>Tránh thức khuya và hoạt động thể chất nặng</li>
                                            </ul>
                                        </div>

                                        <div class="alert alert-light border-start border-danger border-4">
                                            <h6 class="fw-bold mb-2">Lưu ý khi đến hiến máu:</h6>
                                            <ul class="mb-0 ps-3">
                                                <li>Mang theo CCCD/CMND hoặc giấy tờ tùy thân có ảnh</li>
                                                <li>Đến đúng giờ hẹn để đảm bảo quá trình diễn ra suôn sẻ</li>
                                                <li>Thông báo với nhân viên y tế nếu bạn đang uống thuốc hoặc có vấn đề
                                                    sức khỏe</li>
                                                <li>Nghỉ ngơi sau khi hiến máu và uống nhiều nước</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QR Code Footer -->
                <div class="card-footer p-4 bg-light">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <p class="mb-1 fw-bold">
                                <?= htmlspecialchars($appointment->event->name ?? 'Không có tên sự kiện') ?></p>
                            <p class="mb-0 small text-muted">Vui lòng xuất trình mã này khi đến hiến máu. Lịch hẹn có
                                thể bị hủy nếu bạn đến muộn quá 15 phút.</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <!-- Fake QR Code using CSS with development indicator -->
                            <div class="position-relative">
                                <div class="qr-code mx-auto me-md-0">
                                    <div class="qr-code-id"><?= $appointment->id ?></div>
                                </div>
                                <div class="development-badge position-absolute top-0 end-0">
                                    <span class="badge bg-warning text-dark">Đang phát triển</span>
                                </div>
                                <!-- TODO: Implement real QR code generation for appointments -->
                            </div>
                            <p class="mt-2 text-center text-md-end small text-muted fst-italic">Tính năng đang được phát
                                triển</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointment Timeline -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Quá trình xử lý</h5>
                </div>
                <div class="card-body px-4">
                    <div class="timeline">
                        <!-- Booked Stage -->
                        <div class="timeline-item">
                            <div class="timeline-dot bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title fw-bold mb-1">Đặt lịch thành công</h6>
                                <p class="text-muted mb-0">
                                    <?= date('d/m/Y H:i', strtotime($appointment->created_at ?? 'now')) ?>
                                </p>
                                <p class="small mb-0">Lịch hẹn của bạn đã được tạo và đang chờ xác nhận</p>
                            </div>
                        </div>

                        <!-- Confirmed Stage -->
                        <div class="timeline-item <?= $appointment->status < 1 ? 'timeline-inactive' : '' ?>">
                            <div class="timeline-dot <?= $appointment->status >= 1 ? 'bg-success' : 'bg-secondary' ?>">
                            </div>
                            <div class="timeline-content">
                                <h6 class="timeline-title fw-bold mb-1">Xác nhận lịch hẹn</h6>
                                <?php if ($appointment->status >= 1): ?>
                                    <p class="text-muted mb-0">
                                        <?= date('d/m/Y H:i', strtotime($appointment->updated_at ?? 'now')) ?>
                                    </p>
                                    <p class="small mb-0">Lịch hẹn của bạn đã được xác nhận</p>
                                <?php else: ?>
                                    <p class="text-muted mb-0">Đang chờ xử lý</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Completed/Cancelled Stage -->
                        <div
                            class="timeline-item <?= $appointment->status < 2 && $appointment->status != 3 ? 'timeline-inactive' : '' ?>">
                            <div
                                class="timeline-dot <?= $appointment->status >= 2 || $appointment->status == 3 ? ($appointment->status == 3 ? 'bg-danger' : 'bg-success') : 'bg-secondary' ?>">
                            </div>
                            <div class="timeline-content">
                                <?php if ($appointment->status == 3): ?>
                                    <h6 class="timeline-title fw-bold mb-1">Lịch hẹn đã bị hủy</h6>
                                    <p class="text-muted mb-0">
                                        <?= date('d/m/Y H:i', strtotime($appointment->updated_at ?? 'now')) ?>
                                    </p>
                                    <p class="small mb-0">Lịch hẹn của bạn đã bị hủy</p>
                                <?php elseif ($appointment->status == 2): ?>
                                    <h6 class="timeline-title fw-bold mb-1">Hoàn thành hiến máu</h6>
                                    <p class="text-muted mb-0">
                                        <?= date('d/m/Y H:i', strtotime($appointment->updated_at ?? 'now')) ?>
                                    </p>
                                    <p class="small mb-0">Cảm ơn bạn đã tham gia hiến máu!</p>
                                <?php else: ?>
                                    <h6 class="timeline-title fw-bold mb-1">Hoàn thành hiến máu</h6>
                                    <p class="text-muted mb-0">Chưa hoàn thành</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="d-flex flex-wrap gap-2 justify-content-between mb-5">
                <div>
                    <a href="<?= BASE_URL ?>/index.php?controller=Appointment&action=userAppointments"
                        class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
                    </a>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print me-2"></i>In thẻ hẹn
                    </button>
                    <?php if ($appointment->status === 0 || $appointment->status === 1): ?>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                            <i class="fas fa-times me-2"></i>Hủy lịch hẹn
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Appointment Modal -->
<?php if ($appointment->status === 0 || $appointment->status === 1): ?>
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="cancelModalLabel">Xác nhận hủy lịch hẹn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="icon-warning bg-danger bg-opacity-10 text-danger mx-auto mb-3">
                            <i class="fas fa-exclamation-triangle fa-3x"></i>
                        </div>
                        <h5 class="fw-bold">Bạn có chắc chắn muốn hủy lịch hẹn này?</h5>
                        <p class="text-muted">Lịch hẹn sẽ bị hủy và bạn sẽ cần đặt lịch lại nếu muốn hiến máu.</p>
                    </div>

                    <div class="card border mb-3">
                        <div class="card-body py-3 px-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span
                                    class="fw-medium"><?= htmlspecialchars($appointment->event->name ?? 'Không có tên sự kiện') ?></span>
                                <span class="badge rounded-pill bg-light text-dark">
                                    <?= date('d/m/Y', strtotime($appointment->appointment_date_time)) ?>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center text-muted small">
                                <span><i
                                        class="far fa-clock me-1"></i><?= date('H:i', strtotime($appointment->appointment_date_time)) ?></span>
                                <span><i class="fas fa-tint me-1"></i><?= $appointment->blood_amount ?> ml</span>
                            </div>
                        </div>
                    </div>

                    <form action="<?= BASE_URL ?>/index.php?controller=Appointment&action=cancelAppointment" method="POST">
                        <input type="hidden" name="appointment_id" value="<?= $appointment->id ?>">
                        <div class="mb-3">
                            <label for="cancelReason" class="form-label">Lý do hủy (không bắt buộc)</label>
                            <select class="form-select" id="cancelReason" name="cancel_reason">
                                <option value="schedule_conflict">Trùng lịch, không thể tham gia</option>
                                <option value="health_issue">Vấn đề sức khỏe</option>
                                <option value="transportation">Khó khăn về phương tiện di chuyển</option>
                                <option value="other">Lý do khác</option>
                            </select>
                        </div>
                        <div class="mb-3" id="otherReasonContainer" style="display: none;">
                            <label for="otherReason" class="form-label">Lý do cụ thể</label>
                            <textarea class="form-control" id="otherReason" name="other_reason" rows="2"></textarea>
                        </div>
                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Quay
                                lại</button>
                            <button type="submit" class="btn btn-danger px-4">Xác nhận hủy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cancelReasonSelect = document.getElementById('cancelReason');
            const otherReasonContainer = document.getElementById('otherReasonContainer');

            cancelReasonSelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    otherReasonContainer.style.display = 'block';
                } else {
                    otherReasonContainer.style.display = 'none';
                }
            });
        });
    </script>
<?php endif; ?>

<style>
    /* Appointment card styles */
    .appointment-card {
        overflow: hidden;
        border-radius: 12px;
    }

    .appointment-card-header {
        position: relative;
    }

    .appointment-card-header::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 0;
        right: 0;
        height: 30px;
        background: white;
        border-radius: 50% 50% 0 0;
    }

    .info-container {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-top: 20px;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        min-width: 140px;
        flex-grow: 1;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1.2rem;
    }

    .info-content {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 3px;
    }

    .info-value {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .map-container {
        height: 150px;
        overflow: hidden;
    }

    .map-placeholder {
        height: 100%;
    }

    /* QR Code styling */
    .qr-code {
        width: 100px;
        height: 100px;
        background: linear-gradient(90deg, black 25%, transparent 25%) 0 0 / 25% 25%,
            linear-gradient(90deg, transparent 75%, black 75%) 0 0 / 25% 25%,
            linear-gradient(0deg, black 25%, transparent 25%) 0 0 / 25% 25%,
            linear-gradient(0deg, transparent 75%, black 75%) 0 0 / 25% 25%,
            linear-gradient(90deg, black 25%, transparent 25%) 50% 0 / 25% 25%,
            linear-gradient(90deg, transparent 75%, black 75%) 50% 0 / 25% 25%,
            linear-gradient(0deg, black 25%, transparent 25%) 50% 0 / 25% 25%,
            linear-gradient(0deg, transparent 75%, black 75%) 50% 0 / 25% 25%,
            linear-gradient(90deg, transparent 50%, black 50%, black 75%, transparent 75%) 50% 50% / 50% 50%,
            linear-gradient(0deg, black 25%, transparent 25%) 0 50% / 25% 25%,
            linear-gradient(0deg, transparent 75%, black 75%) 0 50% / 25% 25%;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 10px solid white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .qr-code-id {
        background-color: white;
        color: black;
        font-weight: bold;
        font-size: 12px;
        padding: 2px 6px;
        border-radius: 4px;
    }

    /* Timeline styles */
    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 15px;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        padding-left: 40px;
        margin-bottom: 25px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: 9px;
        top: 5px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        z-index: 1;
    }

    .timeline-inactive {
        opacity: 0.5;
    }

    .icon-wrapper {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-warning {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    /* Print styles */
    @media print {
        body {
            background-color: white;
        }

        .container {
            max-width: 100%;
            width: 100%;
        }

        .appointment-card {
            box-shadow: none !important;
            margin: 0 !important;
            page-break-inside: avoid;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        .timeline::before {
            background: #ddd;
        }

        .btn,
        .modal,
        .navbar,
        footer,
        header {
            display: none !important;
        }

        a[href]:after {
            content: none !important;
        }
    }
</style>