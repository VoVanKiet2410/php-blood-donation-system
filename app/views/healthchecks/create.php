<?php
// filepath: /blood-donation-system/blood-donation-system/app/views/healthchecks/create.php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Health Check</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Create Health Check</h1>
        <form action="/healthchecks/store" method="POST">
            <div class="form-group">
                <label for="healthMetrics">Health Metrics (JSON format)</label>
                <textarea id="healthMetrics" name="healthMetrics" required></textarea>
            </div>
            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes"></textarea>
            </div>
            <div class="form-group">
                <label for="appointment_id">Appointment</label>
                <select id="appointment_id" name="appointment_id" required>
                    <!-- Options will be populated dynamically from the database -->
                    <?php foreach ($appointments as $appointment): ?>
                        <option value="<?= $appointment->id ?>"><?= $appointment->appointmentDateTime ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit">Create Health Check</button>
        </form>
        <a href="/healthchecks/index">Back to Health Checks</a>
    </div>
</body>
</html>