<?php
// Fetch all appointments from the database
$appointments = []; // This should be replaced with a call to the model to get appointments

// Example of how appointments might be fetched
// $appointments = Appointment::all(); // Assuming you have a method to fetch all appointments

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Appointments</h1>
        <a href="/appointments/create.php" class="btn btn-primary">Create New Appointment</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Event</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($appointments)): ?>
                    <tr>
                        <td colspan="6">No appointments found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment->Id); ?></td>
                            <td><?php echo htmlspecialchars($appointment->user->username); ?></td>
                            <td><?php echo htmlspecialchars($appointment->event->name); ?></td>
                            <td><?php echo htmlspecialchars($appointment->appointmentDateTime); ?></td>
                            <td><?php echo htmlspecialchars($appointment->status); ?></td>
                            <td>
                                <a href="/appointments/edit.php?id=<?php echo htmlspecialchars($appointment->Id); ?>" class="btn btn-edit">Edit</a>
                                <a href="/appointments/delete.php?id=<?php echo htmlspecialchars($appointment->Id); ?>" class="btn btn-delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>