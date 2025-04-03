<?php
// blood-donation-system/app/views/news/edit.php

// Ensure article data is passed from the controller
// $article is already passed from the controller
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News Article</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS for styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
        }
        .sidebar {
            background-color: #2c3e50;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
            width: 200px;
        }
        .sidebar a {
            color: #ecf0f1;
            padding: 15px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #34495e;
        }
        .sidebar a.active {
            background-color: #007bff;
        }
        .header {
            background-color: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-left: 200px;
        }
        .header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .header .user-info {
            display: flex;
            align-items: center;
        }
        .header .user-info span {
            margin-right: 10px;
        }
        .header .user-info .badge {
            background-color: #007bff;
        }
        .main-content {
            margin-left: 200px;
            padding: 20px;
        }
        .title-bar {
            background-color: #6f42c1;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#">Tổng quan</a>
        <a href="#">Kho máu</a>
        <a href="#">Người dùng</a>
        <a href="#">Sự kiện hiện máu</a>
        <a href="#" class="active">News</a> <!-- Added News item -->
        <a href="#">Kiểm tra sức khỏe</a>
    </div>

    <!-- Header -->
    <div class="header">
        <div class="logo">
            HUTECH
        </div>
        <div class="user-info">
            <span>890123456782</span>
            <span class="badge rounded-pill text-bg-primary">Administrator</span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="title-bar">
            <h4>Quản lý Tin tức</h4>
            <p>Danh sách và quản lý các tin tức</p>
        </div>

        <div class="form-container">
            <h5>Chỉnh sửa Tin tức</h5>

            <form action="/php-blood-donation-system/public/index.php?controller=News&action=update&id=<?php echo $article['id']; ?>" method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề:</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung:</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($article['content']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Tác giả:</label>
                    <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($article['author']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="imageUrl" class="form-label">URL Hình ảnh:</label>
                    <input type="text" class="form-control" id="imageUrl" name="imageUrl" value="<?php echo htmlspecialchars($article['image_url']); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật Tin tức</button>
            </form>

            <a href="/php-blood-donation-system/public/index.php?controller=News&action=manage" class="btn btn-secondary mt-3">Quay lại Danh sách Tin tức</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>