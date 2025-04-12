<?php
$content = function () {
?>
<div class="container-fluid">
    <div class="ant-page-header mb-4 rounded">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Thêm người dùng mới</h4>
                <p class="mb-0 mt-1 text-muted">Tạo tài khoản người dùng mới</p>
            </div>
        </div>
    </div>
    <form action="<?= BASE_URL ?>/index.php?controller=User&action=store" method="POST">
        <div class="form-group">
            <label for="fullName">Họ và tên:</label>
            <input type="text" id="fullName" name="fullName" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="dob">Ngày sinh:</label>
            <input type="date" id="dob" name="dob" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="sex">Giới tính:</label>
            <select id="sex" name="sex" class="form-control" required>
                <option value="Male">Nam</option>
                <option value="Female">Nữ</option>
                <option value="Other">Khác</option>
            </select>
        </div>
        <div class="form-group">
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Tạo người dùng</button>
    </form>
    <a href="<?= BASE_URL ?>/index.php?controller=User&action=index" class="btn btn-secondary mt-3">Quay lại danh sách người dùng</a>
</div>
<?php
};
include_once '../../layouts/AdminLayout/AdminLayout.php';
?>