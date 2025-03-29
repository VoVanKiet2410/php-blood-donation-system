<?php
// filepath: /blood-donation-system/blood-donation-system/app/views/events/index.php

// Assuming you have a variable $events that contains the list of events
// and a function to generate the URL for actions

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events List</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Blood Donation Events</h1>
        <a href="/events/create" class="btn btn-primary">Create New Event</a>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event->name); ?></td>
                            <td><?php echo htmlspecialchars($event->eventDate); ?></td>
                            <td><?php echo htmlspecialchars($event->eventStartTime); ?></td>
                            <td><?php echo htmlspecialchars($event->eventEndTime); ?></td>
                            <td><?php echo htmlspecialchars($event->status); ?></td>
                            <td>
                                <a href="/events/edit/<?php echo $event->id; ?>" class="btn btn-edit">Edit</a>
                                <a href="/events/delete/<?php echo $event->id; ?>" class="btn btn-delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No events found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>