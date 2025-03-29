<?php
// blood-donation-system/app/views/news/create.php

// Include the necessary files for database connection and session management
require_once '../../config/database.php';
session_start();

// Check if the user is logged in and has permission to create news
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: /blood-donation-system/public/auth/login.php');
    exit;
}

// Initialize variables
$title = '';
$content = '';
$author = '';
$imageUrl = '';
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $author = $_POST['author'] ?? '';
    $imageUrl = $_POST['imageUrl'] ?? '';

    // Validate input
    if (empty($title)) {
        $errors[] = 'Title is required.';
    }
    if (empty($content)) {
        $errors[] = 'Content is required.';
    }
    if (empty($author)) {
        $errors[] = 'Author is required.';
    }

    // If no errors, proceed to insert into the database
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO news (title, content, author, imageUrl, timestamp) VALUES (?, ?, ?, ?, NOW())");
        if ($stmt->execute([$title, $content, $author, $imageUrl])) {
            header('Location: /blood-donation-system/public/news/index.php');
            exit;
        } else {
            $errors[] = 'Failed to create news article. Please try again.';
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
    <link rel="stylesheet" href="/blood-donation-system/public/css/styles.css">
</head>
<body>
    <h1>Create News Article</h1>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
        </div>
        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required><?php echo htmlspecialchars($content); ?></textarea>
        </div>
        <div>
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($author); ?>" required>
        </div>
        <div>
            <label for="imageUrl">Image URL:</label>
            <input type="text" id="imageUrl" name="imageUrl" value="<?php echo htmlspecialchars($imageUrl); ?>">
        </div>
        <div>
            <button type="submit">Create News Article</button>
        </div>
    </form>

    <a href="/blood-donation-system/public/news/index.php">Back to News List</a>
</body>
</html>