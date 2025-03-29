<?php
// filepath: /blood-donation-system/blood-donation-system/app/views/events/edit.php

// Assuming we have an event object passed to this view for editing
// and a form submission method defined in the controller

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Event</h1>
        <form action="/events/update/<?php echo $event->id; ?>" method="POST">
            <div class="form-group">
                <label for="name">Event Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($event->name); ?>" required>
            </div>
            <div class="form-group">
                <label for="eventDate">Event Date:</label>
                <input type="date" id="eventDate" name="eventDate" value="<?php echo $event->eventDate; ?>" required>
            </div>
            <div class="form-group">
                <label for="eventStartTime">Start Time:</label>
                <input type="time" id="eventStartTime" name="eventStartTime" value="<?php echo $event->eventStartTime; ?>" required>
            </div>
            <div class="form-group">
                <label for="eventEndTime">End Time:</label>
                <input type="time" id="eventEndTime" name="eventEndTime" value="<?php echo $event->eventEndTime; ?>" required>
            </div>
            <div class="form-group">
                <label for="maxRegistrations">Max Registrations:</label>
                <input type="number" id="maxRegistrations" name="maxRegistrations" value="<?php echo $event->maxRegistrations; ?>" required>
            </div>
            <div class="form-group">
                <label for="currentRegistrations">Current Registrations:</label>
                <input type="number" id="currentRegistrations" name="currentRegistrations" value="<?php echo $event->currentRegistrations; ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="ACTIVE" <?php echo $event->status == 'ACTIVE' ? 'selected' : ''; ?>>Active</option>
                    <option value="FULL" <?php echo $event->status == 'FULL' ? 'selected' : ''; ?>>Full</option>
                    <option value="DONE" <?php echo $event->status == 'DONE' ? 'selected' : ''; ?>>Done</option>
                </select>
            </div>
            <button type="submit">Update Event</button>
        </form>
        <a href="/events/index">Back to Events</a>
    </div>
</body>
</html>