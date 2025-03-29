<?php
// filepath: /blood-donation-system/blood-donation-system/app/views/appointments/edit.php

// Assuming we have appointment data passed to this view
// and a form to edit the appointment details.

$appointment = isset($appointment) ? $appointment : null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Appointment</h1>
        <form action="/appointments/update/<?php echo $appointment->Id; ?>" method="POST">
            <div class="form-group">
                <label for="appointmentDateTime">Appointment Date & Time:</label>
                <input type="datetime-local" id="appointmentDateTime" name="appointmentDateTime" value="<?php echo $appointment->appointmentDateTime; ?>" required>
            </div>
            <div class="form-group">
                <label for="bloodAmount">Blood Amount (mL):</label>
                <input type="number" id="bloodAmount" name="bloodAmount" value="<?php echo $appointment->bloodAmount; ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="PENDING" <?php echo $appointment->status == 'PENDING' ? 'selected' : ''; ?>>Pending</option>
                    <option value="CONFIRMED" <?php echo $appointment->status == 'CONFIRMED' ? 'selected' : ''; ?>>Confirmed</option>
                    <option value="CANCELED" <?php echo $appointment->status == 'CANCELED' ? 'selected' : ''; ?>>Canceled</option>
                    <option value="COMPLETED" <?php echo $appointment->status == 'COMPLETED' ? 'selected' : ''; ?>>Completed</option>
                </select>
            </div>
            <button type="submit">Update Appointment</button>
        </form>
        <a href="/appointments/index">Back to Appointments</a>
    </div>
</body>
</html>