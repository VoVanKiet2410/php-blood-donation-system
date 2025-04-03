<?php
require_once __DIR__ . '/../../../config/database.php';

$title = '';
$content = '';
$author = '';
$imageUrl = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $author = $_POST['author'] ?? '';
    $imageUrl = $_POST['imageUrl'] ?? '';

    if (empty($title)) {
        $errors[] = 'Title is required.';
    }
    if (empty($content)) {
        $errors[] = 'Content is required.';
    }
    if (empty($author)) {
        $errors[] = 'Author is required.';
    }

    if (empty($errors)) {
        $stmt = $connection->prepare("INSERT INTO news (title, content, author, image_url, timestamp) VALUES (?, ?, ?, ?, NOW())");
        
        if ($stmt) {
            $stmt->bind_param("ssss", $title, $content, $author, $imageUrl);
            
            if ($stmt->execute()) {
                header('Location: /php-blood-donation-system/public/index.php?controller=News&action=manage');
                exit;
            } else {
                $errors[] = 'Failed to create news article. Please try again.';
            }
        } else {
            $errors[] = 'Error preparing the SQL statement.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create News Article</title>
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
            <h5>Thêm Tin tức Mới</h5>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề:</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung:</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($content); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Tác giả:</label>
                    <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($author); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="imageUrl" class="form-label">URL Hình ảnh:</label>
                    <input type="text" class="form-control" id="imageUrl" name="imageUrl" value="<?php echo htmlspecialchars($imageUrl); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Thêm Tin tức</button>
            </form>

            <a href="/php-blood-donation-system/public/news/index.php" class="btn btn-secondary mt-3">Quay lại Danh sách Tin tức</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>