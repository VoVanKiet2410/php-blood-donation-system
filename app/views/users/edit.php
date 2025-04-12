<?php
$content = function () use ($user) {
?>
<div class="container-fluid">
    <div class="ant-page-header mb-4 rounded">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Chỉnh sửa người dùng</h4>
                <p class="mb-0 mt-1 text-muted">Cập nhật thông tin người dùng</p>
            </div>
        </div>
    </div>
    <form action="/users/update/<?php echo $user->id; ?>" method="POST">
        <div class="form-group">
            <label for="fullName">Họ và tên:</label>
            <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($user->fullName); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user->email); ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user->phone); ?>" required>
        </div>
        <div class="form-group">
            <label for="role">Vai trò:</label>
            <select id="role" name="role" required>
                <option value="admin" <?php echo $user->role === 'admin' ? 'selected' : ''; ?>>Quản trị viên</option>
                <option value="user" <?php echo $user->role === 'user' ? 'selected' : ''; ?>>Người dùng</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
    <a href="/users/index" class="btn btn-secondary mt-3">Quay lại danh sách người dùng</a>
</div>
<?php
};
include_once '../../layouts/AdminLayout/AdminLayout.php';
?>