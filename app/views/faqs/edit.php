<?php
// filepath: /blood-donation-system/blood-donation-system/app/views/faqs/edit.php

require_once '../../config/database.php';
require_once '../../app/models/Faq.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $faq = Faq::find($id);
} else {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $faq->title = $_POST['title'];
    $faq->description = $_POST['description'];

    if ($faq->save()) {
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit FAQ</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit FAQ</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($faq->title); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" required><?php echo htmlspecialchars($faq->description); ?></textarea>
            </div>
            <button type="submit">Update FAQ</button>
        </form>
        <a href="index.php">Back to FAQs</a>
    </div>
</body>
</html>