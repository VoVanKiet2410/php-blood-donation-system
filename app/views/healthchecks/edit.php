<?php
// Filepath: /blood-donation-system/blood-donation-system/app/views/healthchecks/edit.php

// Assuming we have a variable $healthcheck that contains the health check data to be edited
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Health Check</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Health Check</h1>
        <form action="/healthchecks/update/<?php echo $healthcheck->id; ?>" method="POST">
            <div class="form-group">
                <label for="healthMetrics">Health Metrics (JSON)</label>
                <textarea id="healthMetrics" name="healthMetrics" required><?php echo htmlspecialchars($healthcheck->healthMetrics); ?></textarea>
            </div>
            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes"><?php echo htmlspecialchars($healthcheck->notes); ?></textarea>
            </div>
            <button type="submit">Update Health Check</button>
        </form>
        <a href="/healthchecks/index">Back to Health Checks</a>
    </div>
</body>
</html>