<?php
// blood-donation-system/app/views/donation_units/create.php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Donation Unit</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Create Donation Unit</h1>
        <form action="/donation_units/store" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="unitPhotoUrl">Unit Photo URL:</label>
                <input type="text" id="unitPhotoUrl" name="unitPhotoUrl">
            </div>
            <button type="submit">Create Donation Unit</button>
        </form>
        <a href="/donation_units/index">Back to Donation Units</a>
    </div>
</body>
</html>