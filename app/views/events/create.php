<?php
// filepath: /blood-donation-system/blood-donation-system/app/views/events/create.php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Create New Event</h1>
        <form action="/events/store" method="POST">
            <div class="form-group">
                <label for="name">Event Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="eventDate">Event Date:</label>
                <input type="date" id="eventDate" name="eventDate" required>
            </div>
            <div class="form-group">
                <label for="eventStartTime">Start Time:</label>
                <input type="time" id="eventStartTime" name="eventStartTime" required>
            </div>
            <div class="form-group">
                <label for="eventEndTime">End Time:</label>
                <input type="time" id="eventEndTime" name="eventEndTime" required>
            </div>
            <div class="form-group">
                <label for="maxRegistrations">Max Registrations:</label>
                <input type="number" id="maxRegistrations" name="maxRegistrations" required>
            </div>
            <div class="form-group">
                <label for="donationUnit">Donation Unit:</label>
                <select id="donationUnit" name="donationUnit" required>
                    <!-- Options will be populated from the database -->
                </select>
            </div>
            <button type="submit">Create Event</button>
        </form>
        <a href="/events/index">Back to Events</a>
    </div>
</body>
</html>