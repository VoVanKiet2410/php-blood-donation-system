<?php
// filepath: /blood-donation-system/blood-donation-system/app/views/donation_units/index.php

// Assuming you have a DonationUnitController that fetches the donation units
// and passes them to this view.

require_once '../../config/database.php'; // Include database connection
require_once '../../app/controllers/DonationUnitController.php'; // Include the controller

$donationUnitController = new DonationUnitController();
$donationUnits = $donationUnitController->index(); // Fetch all donation units

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Units</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Donation Units</h1>
        <a href="create.php" class="btn">Add New Donation Unit</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($donationUnits)): ?>
                    <tr>
                        <td colspan="6">No donation units found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($donationUnits as $unit): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($unit->id); ?></td>
                            <td><?php echo htmlspecialchars($unit->name); ?></td>
                            <td><?php echo htmlspecialchars($unit->location); ?></td>
                            <td><?php echo htmlspecialchars($unit->phone); ?></td>
                            <td><?php echo htmlspecialchars($unit->email); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $unit->id; ?>" class="btn">Edit</a>
                                <a href="delete.php?id=<?php echo $unit->id; ?>" class="btn">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>