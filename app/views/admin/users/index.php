<?php
$content = function () use ($users) {
?>
<div class="container-fluid px-0">
    <div class="ant-page-header mb-4 rounded" style="background: linear-gradient(120deg, var(--accent-purple), var(--accent-violet)); padding: 24px; color: white;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 text-white">Quản lý Người Dùng</h4>
                <p class="mb-0 mt-1 text-white opacity-75">Danh sách và quản lý người dùng</p>
            </div>
            <a href="index.php?controller=UserAdmin&action=create" class="ant-btn" style="background: white; color: var(--accent-purple); border: none; font-weight: 500;">
                <i class="fas fa-plus me-2"></i>Thêm mới
            </a>
        </div>
    </div>

    <div class="ant-card" style="border-top: 3px solid var(--accent-purple); box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <div class="ant-card-body p-0">
            <div class="table-responsive">
                <table class="ant-table table table-hover">
                    <thead>
                        <tr>
                            <th>CCCD</th>
                            <th>Họ và Tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Vai trò</th>
                            <th class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($users) && count($users) > 0): ?>
                        <?php foreach ($users as $user): ?>
                        <tr class="hover-effect">
                            <td><span class="badge rounded-pill bg-primary"><?= $user['cccd'] ?></span></td>
                            <td><?= htmlspecialchars($user['full_name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                            <td><?= htmlspecialchars($user['role_name']) ?></td>
                            <td class="text-end">
                                <a href="index.php?controller=UserAdmin&action=edit&cccd=<?= $user['cccd'] ?>" class="action-btn edit-btn me-1" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="action-btn delete-btn" title="Xóa" onclick="confirmDelete('<?= $user['cccd'] ?>')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-users-slash empty-state-icon"></i>
                                    <p>Không có người dùng nào để hiển thị</p>
                                    <a href="index.php?controller=UserAdmin&action=create" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i> Thêm người dùng mới
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(cccd) {
    if (confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
        window.location.href = `index.php?controller=UserAdmin&action=delete&cccd=${cccd}`;
    }
}
</script>
<?php
};
include_once __DIR__ . '/../../layouts/AdminLayout/AdminLayout.php';