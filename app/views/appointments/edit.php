<?php
// filepath: /blood-donation-system/blood-donation-system/app/views/appointments/edit.php

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Using AdminLayout
$content = function($data) {
    $appointment = $data['appointment'] ?? null;
    $events = $data['events'] ?? [];
    $users = $data['users'] ?? [];
    $errors = $data['errors'] ?? [];
    
    if (!$appointment) {
        echo "<div class='alert alert-danger'>Không tìm thấy lịch hẹn.</div>";
        return;
    }
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Cập Nhật Lịch Hẹn Hiến Máu</h4>
        </div>
        <div class="card-body">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <strong>Đã xảy ra lỗi:</strong>
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form action="index.php?controller=Appointment&action=update&id=<?php echo $appointment->id; ?>" method="POST">
                <div class="mb-3 row">
                    <label for="user_cccd" class="col-sm-3 col-form-label">Người Hiến Máu:</label>
                    <div class="col-sm-9">
                        <select id="user_cccd" name="user_cccd" class="form-select" required>
                            <option value="">Chọn người hiến máu</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo htmlspecialchars($user['cccd']); ?>" <?php echo ($appointment->user_cccd == $user['cccd']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($user['full_name']); ?> (<?php echo htmlspecialchars($user['cccd']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="event_id" class="col-sm-3 col-form-label">Sự Kiện:</label>
                    <div class="col-sm-9">
                        <select id="event_id" name="event_id" class="form-select" required>
                            <option value="">Chọn sự kiện</option>
                            <?php foreach ($events as $event): ?>
                                <option value="<?php echo htmlspecialchars($event['id']); ?>" <?php echo ($appointment->event_id == $event['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($event['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="appointment_date_time" class="col-sm-3 col-form-label">Ngày Giờ Hẹn:</label>
                    <div class="col-sm-9">
                        <input type="datetime-local" class="form-control" id="appointment_date_time" name="appointment_date_time" value="<?php echo date('Y-m-d\TH:i', strtotime($appointment->appointment_date_time)); ?>" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="blood_amount" class="col-sm-3 col-form-label">Lượng Máu (mL):</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="blood_amount" name="blood_amount" 
                            value="<?php echo isset($appointment->blood_amount) ? htmlspecialchars($appointment->blood_amount) : '350'; ?>" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="status" class="col-sm-3 col-form-label">Trạng Thái:</label>
                    <div class="col-sm-9">
                        <select id="status" name="status" class="form-select" required>
                            <option value="0" <?php echo ($appointment->status == '0' || $appointment->status == 0) ? 'selected' : ''; ?>>Đang chờ</option>
                            <option value="1" <?php echo ($appointment->status == '1' || $appointment->status == 1) ? 'selected' : ''; ?>>Đã xác nhận</option>
                            <option value="2" <?php echo ($appointment->status == '2' || $appointment->status == 2) ? 'selected' : ''; ?>>Đã hủy</option>
                            <option value="3" <?php echo ($appointment->status == '3' || $appointment->status == 3) ? 'selected' : ''; ?>>Đã hoàn thành</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <a href="index.php?controller=Appointment&action=index" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i> Quay Lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Lưu Thay Đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
}; // End of content function

// Include the admin layout
require_once __DIR__ . '/../layouts/AdminLayout/AdminLayout.php';
?>