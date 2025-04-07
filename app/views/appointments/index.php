<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Using AdminLayout
$content = function($data) {
    $appointments = $data['appointments'] ?? [];
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Quản Lý Lịch Hẹn Hiến Máu</h4>
            <a href="index.php?controller=Appointment&action=create" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Thêm Lịch Hẹn Mới
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Người Hiến</th>
                            <th>Sự Kiện</th>
                            <th>Ngày Giờ</th>
                            <th>Trạng Thái</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($appointments)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Không có lịch hẹn nào.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($appointment->appointment_id); ?></td>
                                    <td><?php echo htmlspecialchars($appointment->user_name); ?></td>
                                    <td><?php echo htmlspecialchars($appointment->event_name); ?></td>
                                    <td><?php echo htmlspecialchars($appointment->appointment_date_time); ?></td>
                                    <td>
                                        <span class="badge <?php echo htmlspecialchars($appointment->status_class); ?>"><?php echo htmlspecialchars($appointment->status_text); ?></span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="index.php?controller=Appointment&action=edit&id=<?php echo $appointment->appointment_id; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="index.php?controller=Appointment&action=delete&id=<?php echo $appointment->appointment_id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa lịch hẹn này không?');">
                                                <i class="fas fa-trash-alt"></i> Xóa
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
}; // End of content function

// Include the admin layout
require_once __DIR__ . '/../layouts/AdminLayout/AdminLayout.php';
?>