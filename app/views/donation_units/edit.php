<?php
// filepath: /blood-donation-system/blood-donation-system/app/views/donation_units/edit.php

// Assuming we have a DonationUnit object $donationUnit passed to this view
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Donation Unit</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Donation Unit</h1>
        <form action="/donation_units/update/<?php echo $donationUnit->id; ?>" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($donationUnit->name); ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($donationUnit->location); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($donationUnit->phone); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($donationUnit->email); ?>" required>
            </div>
            <div class="form-group">
                <label for="unitPhotoUrl">Unit Photo URL:</label>
                <input type="text" id="unitPhotoUrl" name="unitPhotoUrl" value="<?php echo htmlspecialchars($donationUnit->unitPhotoUrl); ?>">
            </div>
            <button type="submit">Update Donation Unit</button>
        </form>
        <a href="/donation_units/index">Back to Donation Units</a>
    </div>
</body>
</html>