<?php
// File: /blood-donation-system/blood-donation-system/app/views/appointments/create.php

require_once '../../config/database.php';
require_once '../../app/controllers/AppointmentController.php';

$appointmentController = new AppointmentController();
$donationUnits = $appointmentController->getDonationUnits(); // Fetch donation units for the dropdown
$events = $appointmentController->getEvents(); // Fetch events for the dropdown

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Appointment</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Create Appointment</h1>
        <form action="../../app/controllers/AppointmentController.php?action=create" method="POST">
            <div class="form-group">
                <label for="user_cccd">User CCCD:</label>
                <input type="text" name="user_cccd" id="user_cccd" required>
            </div>
            <div class="form-group">
                <label for="event_id">Event:</label>
                <select name="event_id" id="event_id" required>
                    <option value="">Select Event</option>
                    <?php foreach ($events as $event): ?>
                        <option value="<?= $event['id'] ?>"><?= $event['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="donation_unit_id">Donation Unit:</label>
                <select name="donation_unit_id" id="donation_unit_id" required>
                    <option value="">Select Donation Unit</option>
                    <?php foreach ($donationUnits as $unit): ?>
                        <option value="<?= $unit['id'] ?>"><?= $unit['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="appointment_date_time">Appointment Date & Time:</label>
                <input type="datetime-local" name="appointment_date_time" id="appointment_date_time" required>
            </div>
            <div class="form-group">
                <label for="blood_amount">Blood Amount (mL):</label>
                <input type="number" name="blood_amount" id="blood_amount" required>
            </div>
            <button type="submit">Create Appointment</button>
        </form>
        <a href="index.php">Back to Appointments</a>
    </div>
</body>
</html>