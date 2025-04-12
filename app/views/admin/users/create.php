<?php
$content = function () use ($roles) {
?>
<div class="container-fluid px-0">
    <div class="ant-page-header mb-4 rounded" style="background: linear-gradient(120deg, var(--accent-purple), var(--accent-violet)); padding: 24px; color: white;">
        <div class="d-flex align-items-center">
            <a href="index.php?controller=UserAdmin&action=index" class="text-decoration-none text-white me-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0 text-white">Thêm Người Dùng Mới</h4>
                <p class="mb-0 mt-1 text-white opacity-75">Tạo tài khoản người dùng mới</p>
            </div>
        </div>
    </div>

    <div class="ant-card" style="border-top: 3px solid var(--accent-purple); box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <div class="ant-card-body">
            <form action="index.php?controller=UserAdmin&action=store" method="POST" class="needs-validation" novalidate>
                <div class="ant-form-item">
                    <label for="cccd" class="ant-form-label" style="color: var(--accent-purple); font-weight: 600;">CCCD <span class="text-danger">*</span></label>
                    <input type="text" class="ant-input custom-input" id="cccd" name="cccd" required>
                    <div class="invalid-feedback">Vui lòng nhập CCCD.</div>
                </div>
                <div class="ant-form-item">
                    <label for="full_name" class="ant-form-label" style="color: var(--accent-purple); font-weight: 600;">Họ và Tên <span class="text-danger">*</span></label>
                    <input type="text" class="ant-input custom-input" id="full_name" name="full_name" required>
                    <div class="invalid-feedback">Vui lòng nhập họ và tên.</div>
                </div>
                <div class="ant-form-item">
                    <label for="email" class="ant-form-label" style="color: var(--accent-purple); font-weight: 600;">Email <span class="text-danger">*</span></label>
                    <input type="email" class="ant-input custom-input" id="email" name="email" required>
                    <div class="invalid-feedback">Vui lòng nhập email hợp lệ.</div>
                </div>
                <div class="ant-form-item">
                    <label for="phone" class="ant-form-label" style="color: var(--accent-purple); font-weight: 600;">Số điện thoại <span class="text-danger">*</span></label>
                    <input type="text" class="ant-input custom-input" id="phone" name="phone" required>
                    <div class="invalid-feedback">Vui lòng nhập số điện thoại.</div>
                </div>
                <div class="ant-form-item">
                    <label for="role_id" class="ant-form-label" style="color: var(--accent-purple); font-weight: 600;">Vai trò <span class="text-danger">*</span></label>
                    <select class="ant-select custom-select" id="role_id" name="role_id" required>
                        <option value="">-- Chọn vai trò --</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role['id'] ?>"><?= htmlspecialchars($role['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Vui lòng chọn vai trò.</div>
                </div>
                <div class="d-flex justify-content-between border-top pt-4">
                    <a href="index.php?controller=UserAdmin&action=index" class="ant-btn custom-btn-default">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                    <button type="submit" class="ant-btn custom-btn-primary">
                        <i class="fas fa-save me-2"></i>Thêm người dùng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';
    const form = document.querySelector('.needs-validation');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
});
</script>
<?php
};
include_once __DIR__ . '/../../layouts/AdminLayout/AdminLayout.php';