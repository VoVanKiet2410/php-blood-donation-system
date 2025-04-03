<?php
// Fetch news articles from the database (done in controller)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Articles</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>News Articles</h1>
        <a href="/php-blood-donation-system/public/index.php?controller=News&action=create" class="btn btn-primary">Create New Article</a>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Timestamp</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($news)): ?>
                    <?php foreach ($news as $article): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($article['title']); ?></td>
                            <td><?php echo htmlspecialchars($article['author']); ?></td>
                            <td><?php echo htmlspecialchars($article['timestamp']); ?></td>
                            <td>
                                <a href="/php-blood-donation-system/public/edit.php?controller=News&action=edit&id=<?php echo $article['id']; ?>" class="btn btn-edit">Edit</a>
                                <a href="/php-blood-donation-system/public/delete.php?controller=News&action=delete&id=<?php echo $article['id']; ?>" class="btn btn-delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No news articles found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
