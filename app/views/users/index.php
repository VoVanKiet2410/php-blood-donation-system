<?php
// File: /blood-donation-system/blood-donation-system/app/views/users/index.php

require_once '../../config/database.php';
require_once '../../app/controllers/UserController.php';

$userController = new UserController();
$users = $userController->index();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Your Dashboard</h1>
        
        <div class="user-info">
            <h2>Your Information</h2>
            <p><strong>CCCD:</strong> <?= htmlspecialchars($_SESSION['user_id']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? 'Not provided') ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone'] ?? 'Not provided') ?></p>
            
            <?php if (isset($user['full_name'])): ?>
                <p><strong>Full Name:</strong> <?= htmlspecialchars($user['full_name']) ?></p>
            <?php endif; ?>
            
            <?php if (isset($user['address'])): ?>
                <p><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>
            <?php endif; ?>
            
            <?php if (isset($user['dob'])): ?>
                <p><strong>Date of Birth:</strong> <?= htmlspecialchars($user['dob']) ?></p>
            <?php endif; ?>
            
            <?php if (isset($user['sex'])): ?>
                <p><strong>Gender:</strong> <?= htmlspecialchars($user['sex']) ?></p>
            <?php endif; ?>
        </div>
        
        <div class="actions">
            <h2>Available Actions</h2>
            <ul>
                <li><a href="<?= BASE_URL ?>/index.php?controller=Event&action=index">View Blood Donation Events</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?controller=Appointment&action=index">My Appointments</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?controller=Faq&action=index">FAQs</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?controller=News&action=index">News</a></li>
            </ul>
        </div>
        
        <div class="logout">
            <a href="<?= BASE_URL ?>/index.php?controller=Auth&action=logout" class="button">Logout</a>
        </div>
    </div>
</body>
</html>