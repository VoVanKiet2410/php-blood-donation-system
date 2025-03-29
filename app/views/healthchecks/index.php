<?php
// filepath: /blood-donation-system/blood-donation-system/app/views/healthchecks/index.php

// Include necessary files
require_once '../../config/database.php';
require_once '../../app/controllers/HealthcheckController.php';

// Create an instance of the HealthcheckController
$healthcheckController = new HealthcheckController();
$healthchecks = $healthcheckController->index(); // Fetch all health checks

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Checks</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Health Checks</h1>
        <a href="create.php" class="btn">Add New Health Check</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Health Metrics</th>
                    <th>Notes</th>
                    <th>Appointment ID</th>
                    <th>Result</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($healthchecks as $healthcheck): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($healthcheck->id); ?></td>
                        <td><?php echo htmlspecialchars($healthcheck->healthMetrics); ?></td>
                        <td><?php echo htmlspecialchars($healthcheck->notes); ?></td>
                        <td><?php echo htmlspecialchars($healthcheck->appointment->id); ?></td>
                        <td><?php echo htmlspecialchars($healthcheck->result); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $healthcheck->id; ?>" class="btn">Edit</a>
                            <a href="delete.php?id=<?php echo $healthcheck->id; ?>" class="btn">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>