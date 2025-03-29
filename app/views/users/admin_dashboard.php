<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        
        <div class="admin-panel">
            <h2>System Management</h2>
            <ul>
                <li><a href="<?= BASE_URL ?>/index.php?controller=User&action=list">Manage Users</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?controller=Event&action=manage">Manage Events</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?controller=DonationUnit&action=manage">Manage Donation Units</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?controller=BloodInventory&action=manage">Manage Blood Inventory</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?controller=Appointment&action=manage">Manage Appointments</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?controller=News&action=manage">Manage News</a></li>
                <li><a href="<?= BASE_URL ?>/index.php?controller=Faq&action=manage">Manage FAQs</a></li>
            </ul>
        </div>
        
        <div class="logout">
            <a href="<?= BASE_URL ?>/index.php?controller=Auth&action=logout" class="button">Logout</a>
        </div>
    </div>
</body>
</html>
