<?php
use App\Controllers\UserController;
use App\Controllers\AuthController;
use App\Config\Database;

// Check if user is logged in
AuthController::authorize();

// Get user data from session
$user_id = $_SESSION['user_id'];

// Tạo instance của UserController với kết nối mysqli
$userController = new UserController(Database::getConnection());

// Lấy thông tin user
$user = $userController->dashboard();

$content = function () use ($users) {
?>
<div class="container-fluid">
    <div class="ant-page-header mb-4 rounded">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Quản lý người dùng</h4>
                <p class="mb-0 mt-1 text-muted">Danh sách người dùng</p>
            </div>
            <div>
                <a href="/users/create" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Thêm người dùng mới
                </a>
            </div>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Họ và tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Vai trò</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['full_name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td>
                        <a href="/users/edit/<?= $user['id'] ?>" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                        <a href="/users/delete/<?= $user['id'] ?>" class="btn btn-danger btn-sm">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
};
include_once '../../layouts/AdminLayout/AdminLayout.php';