<!-- filepath: c:\xampp\htdocs\php-blood-donation-system\app\views\donation_units\index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Units</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/styles.css">
    <style>
        :root {
            --primary-blue: #1a75ff;
            --light-green: #d4edda;
            --white: #ffffff;
            --soft-red: #f8d7da;
            --deep-blue: #0056b3;
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #d4edda 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding-bottom: 3rem;
        }

        .page-title {
            color: var(--primary-blue);
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
        }

        .page-title:after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: -10px;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: var(--soft-red);
            border-radius: 2px;
        }

        .btn-add {
            background-color: var(--primary-blue);
            color: var(--white);
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: 500;
            border: none;
            transition: all 0.3s;
        }

        .btn-add:hover {
            background-color: var(--deep-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 0;
        }

        .table thead {
            background-color: var(--primary-blue);
            color: var(--white);
        }

        .table thead th {
            border-bottom: none;
            padding: 15px;
            font-weight: 600;
        }

        .table tbody tr:nth-child(even) {
            background-color: var(--light-green);
        }

        .table tbody tr:hover {
            background-color: rgba(230, 57, 70, 0.05);
            transition: background-color 0.3s;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
            border-color: #edf2f7;
        }

        .btn-action {
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
            margin: 0 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .btn-edit {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
            margin-bottom: 5px;
        }

        .btn-edit:hover {
            background-color: #e0a800;
            border-color: #e0a800;
            transform: translateY(-2px);
        }

        .btn-delete {
            background-color: var(--soft-red);
            border-color: var(--soft-red);
            color: #721c24;
        }

        .btn-delete:hover {
            background-color: #d32f2f;
            border-color: #d32f2f;
            color: white;
            transform: translateY(-2px);
        }

        .empty-state {
            padding: 30px;
            text-align: center;
            color: var(--deep-blue);
        }

        .empty-state i {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 1rem;
            display: block;
        }

        .actions-column {
            width: 180px;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                justify-content: center;
            }

            .table-responsive {
                border-radius: 15px;
                overflow: hidden;
            }
        }
    </style>
</head>
<?php

$content = function ($data) {
    $donationUnits = $data['donationUnits'] ?? [];
    ?>
    <div class="container mt-5">
        <h1 class="text-center page-title">Donation Units</h1>
        <div class="header-container">
            <a href="index.php?controller=DonationUnit&action=create" class="btn btn-add">
                <i class="bi bi-plus-lg"></i> Add Blood Donation Unit
            </a>
        </div>
        <div class="card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th class="text-center actions-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($donationUnits)): ?>
                            <tr>
                                <td colspan="6" class="text-center">No donation units found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($donationUnits as $unit): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($unit->id); ?></td>
                                    <td><?php echo htmlspecialchars($unit->name); ?></td>
                                    <td><?php echo htmlspecialchars($unit->location); ?></td>
                                    <td><?php echo htmlspecialchars($unit->phone); ?></td>
                                    <td><?php echo htmlspecialchars($unit->email); ?></td>
                                    <td class="text-center">
                                        <a href="index.php?controller=DonationUnit&action=edit&id=<?php echo urlencode($unit->id); ?>" class="btn btn-edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <a href="index.php?controller=DonationUnit&action=delete&id=<?php echo urlencode($unit->id); ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this unit?');">
                                            <i class="bi bi-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
};

// Include layout
include_once __DIR__ . '/../layouts/AdminLayout/AdminLayout.php';