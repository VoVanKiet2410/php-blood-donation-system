<?php
// Define the title for the page
$title = "Lịch hẹn hiến máu của tôi";

// Check if the necessary data is available
if (!isset($appointments)) {
    echo '<div class="alert alert-danger">Không thể tải danh sách lịch hẹn.</div>';
    return;
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Page header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 mb-0 text-danger fw-bold">
                        <i class="fas fa-calendar-check me-2"></i>Lịch hẹn hiến máu của tôi
                    </h1>
                    <p class="text-muted mb-0">Quản lý và theo dõi các lịch hẹn hiến máu của bạn</p>
                </div>
                <?php if ($canScheduleNew): ?>
                    <a href="<?= BASE_URL ?>/index.php?controller=Event&action=clientIndex" class="btn btn-outline-danger">
                        <i class="fas fa-plus-circle me-2"></i>Đặt lịch mới
                    </a>
                <?php endif; ?>
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

            <!-- Stats row -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-wrapper bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                                    <i class="fas fa-calendar-alt fa-fw fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0"><?= count($appointments) ?></h5>
                                    <p class="text-muted small mb-0">Tổng số lịch hẹn</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-wrapper bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                                    <i class="fas fa-check-circle fa-fw fa-lg"></i>
                                </div>
                                <div>
                                    <?php
                                    $completedCount = 0;
                                    foreach ($appointments as $appointment) {
                                        if ($appointment->status === 2) { // Assuming status 2 is completed
                                            $completedCount++;
                                        }
                                    }
                                    ?>
                                    <h5 class="mb-0"><?= $completedCount ?></h5>
                                    <p class="text-muted small mb-0">Đã hoàn thành</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-wrapper bg-warning bg-opacity-10 text-warning rounded-3 p-3 me-3">
                                    <i class="fas fa-clock fa-fw fa-lg"></i>
                                </div>
                                <div>
                                    <?php
                                    $upcomingCount = 0;
                                    foreach ($appointments as $appointment) {
                                        // Check if appointment is in future and status is pending or confirmed (0 or 1)
                                        if (strtotime($appointment->appointment_date_time) > time() && ($appointment->status === 0 || $appointment->status === 1)) {
                                            $upcomingCount++;
                                        }
                                    }
                                    ?>
                                    <h5 class="mb-0"><?= $upcomingCount ?></h5>
                                    <p class="text-muted small mb-0">Sắp tới</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (count($activeAppointments) > 0): ?>
                <!-- Active appointment card - Users can only have one active appointment at a time -->
                <?php $activeAppointment = $activeAppointments->first(); ?>
                <div class="card border-0 shadow-lg mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-calendar-check me-2"></i>Lịch hẹn hiến máu hiện tại của
                            bạn</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-lg-8 mb-3 mb-lg-0">
                                <div class="d-flex align-items-center mb-3">
                                    <?php if (isset($activeAppointment->event->donationUnit->photo_url) && !empty($activeAppointment->event->donationUnit->photo_url)): ?>
                                        <div class="me-3">
                                            <img src="<?= htmlspecialchars($activeAppointment->event->donationUnit->photo_url) ?>"
                                                alt="<?= htmlspecialchars($activeAppointment->event->donationUnit->name) ?>"
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
                                        <h5 class="mb-0 fw-bold">
                                            <?= htmlspecialchars($activeAppointment->event->name ?? 'Không có tên sự kiện') ?>
                                        </h5>
                                        <p class="text-muted mb-0">
                                            <?= htmlspecialchars($activeAppointment->event->donationUnit->name ?? 'Không có tên đơn vị') ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                                                <i class="fas fa-calendar-day text-danger"></i>
                                            </div>
                                            <div>
                                                <span class="d-block text-muted small">Ngày hẹn</span>
                                                <span
                                                    class="fw-bold"><?= date('d/m/Y', strtotime($activeAppointment->appointment_date_time)) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                                                <i class="fas fa-clock text-danger"></i>
                                            </div>
                                            <div>
                                                <span class="d-block text-muted small">Thời gian</span>
                                                <span
                                                    class="fw-bold"><?= date('H:i', strtotime($activeAppointment->appointment_date_time)) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                                                <i class="fas fa-tint text-danger"></i>
                                            </div>
                                            <div>
                                                <span class="d-block text-muted small">Lượng máu</span>
                                                <span class="fw-bold"><?= $activeAppointment->blood_amount ?> ml</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                                                <i class="fas fa-map-marker-alt text-danger"></i>
                                            </div>
                                            <div>
                                                <span class="d-block text-muted small">Địa điểm</span>
                                                <span
                                                    class="fw-bold"><?= htmlspecialchars($activeAppointment->event->donationUnit->address ?? $activeAppointment->event->donationUnit->location ?? 'Không có địa chỉ') ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card h-100 border bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title fw-bold mb-3">Trạng thái lịch hẹn</h6>
                                        <?php
                                        $statusClass = '';
                                        $statusLabel = '';
                                        $statusIcon = '';

                                        switch ($activeAppointment->status) {
                                            case 0: // Pending
                                                $statusClass = 'warning';
                                                $statusLabel = 'Đang chờ xác nhận';
                                                $statusIcon = 'clock';
                                                $statusMessage = 'Lịch hẹn của bạn đang chờ được xác nhận từ phía đơn vị hiến máu.';
                                                break;
                                            case 1: // Confirmed
                                                $statusClass = 'primary';
                                                $statusLabel = 'Đã xác nhận';
                                                $statusIcon = 'check-circle';
                                                $statusMessage = 'Lịch hẹn của bạn đã được xác nhận. Vui lòng đến đúng giờ.';
                                                break;
                                            default:
                                                $statusClass = 'secondary';
                                                $statusLabel = 'Không xác định';
                                                $statusIcon = 'question-circle';
                                                $statusMessage = 'Không xác định được trạng thái lịch hẹn.';
                                        }
                                        ?>
                                        <div class="text-center mb-3">
                                            <div
                                                class="d-inline-block rounded-circle bg-<?= $statusClass ?> bg-opacity-10 p-4 mb-3">
                                                <i class="fas fa-<?= $statusIcon ?> fa-2x text-<?= $statusClass ?>"></i>
                                            </div>
                                            <h5 class="fw-bold text-<?= $statusClass ?>"><?= $statusLabel ?></h5>
                                            <p class="mb-0 small"><?= $statusMessage ?></p>
                                        </div>

                                        <div class="d-grid gap-2 mt-4">
                                            <a href="<?= BASE_URL ?>/index.php?controller=Appointment&action=viewAppointment&id=<?= $activeAppointment->id ?>"
                                                class="btn btn-primary">
                                                <i class="fas fa-eye me-2"></i>Xem chi tiết
                                            </a>
                                            <?php if ($activeAppointment->status === 0 || $activeAppointment->status === 1): ?>
                                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                    data-bs-target="#cancelModal<?= $activeAppointment->id ?>">
                                                    <i class="fas fa-times me-2"></i>Hủy lịch hẹn
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4 mb-0">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-info-circle fa-lg mt-1"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Lưu ý quan trọng</h6>
                                    <p class="mb-0">Bạn chỉ có thể đặt một lịch hẹn hiến máu trong một khoảng thời gian nhất
                                        định.
                                        Việc hiến máu thường chỉ được thực hiện cách nhau ít nhất 12 tuần (với nam) hoặc 16
                                        tuần (với nữ) để đảm bảo sức khỏe.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appointment history section (if any) -->
                <?php if (count($appointments) > count($activeAppointments)): ?>
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold">Lịch sử hiến máu</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="ps-4">Sự kiện</th>
                                            <th scope="col">Ngày hiến</th>
                                            <th scope="col">Lượng máu</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col" class="text-end pe-4">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($appointments as $appointment): ?>
                                            <?php if ($appointment->id === $activeAppointment->id) continue; // Skip the active appointment 
                                            ?>
                                            <?php
                                            // Define status classes and labels
                                            $statusClass = '';
                                            $statusLabel = '';

                                            switch ($appointment->status) {
                                                case 0: // Pending
                                                    $statusClass = 'bg-warning bg-opacity-10 text-warning';
                                                    $statusLabel = 'Đang chờ xác nhận';
                                                    $rowClass = 'pending-appointment';
                                                    break;
                                                case 1: // Confirmed
                                                    $statusClass = 'bg-primary bg-opacity-10 text-primary';
                                                    $statusLabel = 'Đã xác nhận';
                                                    $rowClass = 'confirmed-appointment';
                                                    break;
                                                case 2: // Completed
                                                    $statusClass = 'bg-success bg-opacity-10 text-success';
                                                    $statusLabel = 'Đã hoàn thành';
                                                    $rowClass = 'completed-appointment';
                                                    break;
                                                case 3: // Canceled
                                                    $statusClass = 'bg-danger bg-opacity-10 text-danger';
                                                    $statusLabel = 'Đã hủy';
                                                    $rowClass = 'canceled-appointment';
                                                    break;
                                                default:
                                                    $statusClass = 'bg-secondary bg-opacity-10 text-secondary';
                                                    $statusLabel = 'Không xác định';
                                                    $rowClass = '';
                                            }
                                            ?>
                                            <tr class="appointment-row <?= $rowClass ?>">
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <?php if (isset($appointment->event->donationUnit->photo_url) && !empty($appointment->event->donationUnit->photo_url)): ?>
                                                            <div class="me-3">
                                                                <img src="<?= htmlspecialchars($appointment->event->donationUnit->photo_url) ?>"
                                                                    alt="<?= htmlspecialchars($appointment->event->donationUnit->name) ?>"
                                                                    class="rounded-circle" width="40" height="40">
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="me-3">
                                                                <div class="rounded-circle d-flex justify-content-center align-items-center bg-primary bg-opacity-10"
                                                                    style="width: 40px; height: 40px;">
                                                                    <i class="fas fa-hospital text-primary"></i>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div>
                                                            <h6 class="mb-0">
                                                                <?= htmlspecialchars($appointment->event->name ?? 'Không có tên sự kiện') ?>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?= date('d/m/Y H:i', strtotime($appointment->appointment_date_time)) ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark">
                                                        <?= $appointment->blood_amount ?> ml
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge rounded-pill <?= $statusClass ?> px-3 py-2">
                                                        <?= $statusLabel ?>
                                                    </span>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <a href="<?= BASE_URL ?>/index.php?controller=Appointment&action=viewAppointment&id=<?= $appointment->id ?>"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Appointment detail modals -->
                <?php foreach ($appointments as $appointment): ?>
                    <!-- Cancel Appointment Modal -->
                    <?php if ($appointment->status === 0 || $appointment->status === 1): ?>
                        <div class="modal fade" id="cancelModal<?= $appointment->id ?>" tabindex="-1"
                            aria-labelledby="cancelModalLabel<?= $appointment->id ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title" id="cancelModalLabel<?= $appointment->id ?>">Xác nhận hủy lịch hẹn
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center mb-4">
                                            <div class="icon-warning bg-danger bg-opacity-10 text-danger mx-auto mb-3">
                                                <i class="fas fa-exclamation-triangle fa-3x"></i>
                                            </div>
                                            <h5 class="fw-bold">Bạn có chắc chắn muốn hủy lịch hẹn này?</h5>
                                            <p class="text-muted">Lịch hẹn sẽ bị hủy và bạn sẽ cần đặt lịch lại nếu muốn hiến máu.
                                            </p>
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
                                                    <span><i class="fas fa-tint me-1"></i><?= $appointment->blood_amount ?>
                                                        ml</span>
                                                </div>
                                            </div>
                                        </div>

                                        <form action="<?= BASE_URL ?>/index.php?controller=Appointment&action=cancelAppointment"
                                            method="POST">
                                            <input type="hidden" name="appointment_id" value="<?= $appointment->id ?>">
                                            <div class="mb-3">
                                                <label for="cancelReason<?= $appointment->id ?>" class="form-label">Lý do hủy (không
                                                    bắt buộc)</label>
                                                <select class="form-select" id="cancelReason<?= $appointment->id ?>"
                                                    name="cancel_reason">
                                                    <option value="schedule_conflict">Trùng lịch, không thể tham gia</option>
                                                    <option value="health_issue">Vấn đề sức khỏe</option>
                                                    <option value="transportation">Khó khăn về phương tiện di chuyển</option>
                                                    <option value="other">Lý do khác</option>
                                                </select>
                                            </div>
                                            <div class="mb-3" id="otherReasonContainer<?= $appointment->id ?>"
                                                style="display: none;">
                                                <label for="otherReason<?= $appointment->id ?>" class="form-label">Lý do cụ
                                                    thể</label>
                                                <textarea class="form-control" id="otherReason<?= $appointment->id ?>"
                                                    name="other_reason" rows="2"></textarea>
                                            </div>
                                            <div class="d-flex justify-content-center gap-2">
                                                <button type="button" class="btn btn-outline-secondary px-4"
                                                    data-bs-dismiss="modal">Quay lại</button>
                                                <button type="submit" class="btn btn-danger px-4">Xác nhận hủy</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const cancelReasonSelect<?= $appointment->id ?> = document.getElementById(
                                    'cancelReason<?= $appointment->id ?>');
                                const otherReasonContainer<?= $appointment->id ?> = document.getElementById(
                                    'otherReasonContainer<?= $appointment->id ?>');

                                cancelReasonSelect<?= $appointment->id ?>.addEventListener('change', function() {
                                    if (this.value === 'other') {
                                        otherReasonContainer<?= $appointment->id ?>.style.display = 'block';
                                    } else {
                                        otherReasonContainer<?= $appointment->id ?>.style.display = 'none';
                                    }
                                });
                            });
                        </script>
                    <?php endif; ?>
                <?php endforeach; ?>

            <?php else: ?>
                <!-- No appointments state -->
                <div class="card border-0 shadow-lg mb-4">
                    <div class="card-body py-5 text-center">
                        <h4 class="text-muted mb-3">Chưa có lịch hẹn hiến máu</h4>
                        <p class="text-muted mb-4">Bạn chưa đăng ký lịch hẹn hiến máu nào. Việc hiến máu giúp cứu sống nhiều
                            người và mang lại lợi ích cho sức khỏe của bạn.</p>

                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="card bg-light border-0 mb-4">
                                    <div class="card-body p-4">
                                        <h5 class="fw-bold mb-3">Tại sao nên hiến máu?</h5>
                                        <div class="row text-start">
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex">
                                                    <div class="me-3 text-danger">
                                                        <i class="fas fa-heart fa-lg"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-1">Cứu sống nhiều người</h6>
                                                        <p class="small mb-0">Một lần hiến máu có thể giúp cứu sống đến 3
                                                            người.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex">
                                                    <div class="me-3 text-danger">
                                                        <i class="fas fa-notes-medical fa-lg"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-1">Kiểm tra sức khỏe miễn phí</h6>
                                                        <p class="small mb-0">Bạn sẽ được kiểm tra các chỉ số sức khỏe cơ
                                                            bản.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex">
                                                    <div class="me-3 text-danger">
                                                        <i class="fas fa-heartbeat fa-lg"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-1">Cải thiện sức khỏe tim mạch</h6>
                                                        <p class="small mb-0">Giảm nguy cơ mắc bệnh tim mạch và đột quỵ.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex">
                                                    <div class="me-3 text-danger">
                                                        <i class="fas fa-fire-alt fa-lg"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-1">Đốt cháy calo</h6>
                                                        <p class="small mb-0">Hiến máu có thể đốt cháy khoảng 650 calo.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 col-md-6 mx-auto">
                            <a href="<?= BASE_URL ?>/index.php?controller=Event&action=clientIndex"
                                class="btn btn-danger btn-lg">
                                <i class="fas fa-calendar-plus me-2"></i>Đặt lịch hiến máu ngay
                            </a>
                            <a href="<?= BASE_URL ?>/index.php?controller=Faq&action=index"
                                class="btn btn-outline-secondary">
                                <i class="fas fa-question-circle me-2"></i>Tìm hiểu thêm về hiến máu
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .icon-wrapper {
        width: 50px;
        height: 50px;
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
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter appointments
        const filterItems = document.querySelectorAll('.filter-item');
        const appointmentRows = document.querySelectorAll('.appointment-row');
        const emptyState = document.getElementById('emptyState');

        filterItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                // Update active filter
                filterItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');
                let visibleCount = 0;

                appointmentRows.forEach(row => {
                    if (filter === 'all') {
                        row.classList.remove('d-none');
                        visibleCount++;
                    } else if (row.classList.contains(`${filter}-appointment`)) {
                        row.classList.remove('d-none');
                        visibleCount++;
                    } else {
                        row.classList.add('d-none');
                    }
                });

                // Show/hide empty state
                if (visibleCount === 0 && appointmentRows.length > 0) {
                    document.querySelector('.table-responsive').classList.add('d-none');
                    emptyState.classList.remove('d-none');
                } else if (appointmentRows.length > 0) {
                    document.querySelector('.table-responsive').classList.remove('d-none');
                    emptyState.classList.add('d-none');
                }
            });
        });
    });
</script>