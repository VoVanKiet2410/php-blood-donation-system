<?php
// Fetch all FAQs from the database
require_once '../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

$query = "SELECT * FROM faqs";
$stmt = $conn->prepare($query);
$stmt->execute();

$faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Frequently Asked Questions</h1>
        <a href="create.php" class="btn">Add New FAQ</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($faqs as $faq): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($faq['id']); ?></td>
                        <td><?php echo htmlspecialchars($faq['title']); ?></td>
                        <td><?php echo htmlspecialchars($faq['description']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo htmlspecialchars($faq['id']); ?>" class="btn">Edit</a>
                            <a href="delete.php?id=<?php echo htmlspecialchars($faq['id']); ?>" class="btn">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>