<?php
// filepath: /blood-donation-system/blood-donation-system/app/views/news/index.php

// Fetch news articles from the database
$newsArticles = []; // This should be populated with data from the NewsController

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
        <a href="/news/create.php" class="btn btn-primary">Create New Article</a>
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
                <?php foreach ($newsArticles as $article): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($article['title']); ?></td>
                        <td><?php echo htmlspecialchars($article['author']); ?></td>
                        <td><?php echo htmlspecialchars($article['timestamp']); ?></td>
                        <td>
                            <a href="/news/edit.php?id=<?php echo $article['id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="/news/delete.php?id=<?php echo $article['id']; ?>" class="btn btn-delete">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>