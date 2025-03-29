<?php
// blood-donation-system/app/views/news/edit.php

// Assuming you have a variable $news that contains the news article to be edited
// and a variable $errors for any validation errors

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News Article</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit News Article</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/news/update/<?php echo $news->id; ?>" method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($news->title); ?>" required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" required><?php echo htmlspecialchars($news->content); ?></textarea>
            </div>

            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" value="<?php echo htmlspecialchars($news->author); ?>" required>
            </div>

            <div class="form-group">
                <label for="imageUrl">Image URL</label>
                <input type="text" name="imageUrl" id="imageUrl" value="<?php echo htmlspecialchars($news->imageUrl); ?>">
            </div>

            <button type="submit">Update News Article</button>
        </form>

        <a href="/news/index">Back to News List</a>
    </div>
</body>
</html>