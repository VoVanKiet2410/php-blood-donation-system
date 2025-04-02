<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Donation Unit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/styles.css">
    <style>
        :root {
            --primary-blue: #1a75ff;
            --deep-blue: #0056b3;
            --light-blue: #e6f0ff;
            --blood-red: #e63946;
            --soft-red: #ffebee;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e6f0ff 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .card-header {
            background-color: var(--primary-blue);
            color: white;
            font-weight: 600;
            padding: 1.5rem;
            border-bottom: none;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(26, 117, 255, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: var(--deep-blue);
            border-color: var(--deep-blue);
            transform: translateY(-2px);
        }
        
        .btn-outline-secondary {
            color: var(--primary-blue);
            border-color: var(--primary-blue);
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: 500;
        }
        
        .btn-outline-secondary:hover {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            color: white;
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
            background-color: var(--blood-red);
            border-radius: 2px;
        }
        
        .form-label {
            color: var(--deep-blue);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .blood-accent {
            color: var(--blood-red);
        }
        
        .input-group-text {
            background-color: var(--light-blue);
            border-color: #dee2e6;
            color: var(--deep-blue);
        }
        
        /* Edit specific styles */
        .edit-banner {
            background-color: #f8f9fa;
            border-left: 4px solid var(--primary-blue);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 0 10px 10px 0;
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.7;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>
<?php

$content = function ($data) {
    $donationUnit = $data['donationUnit'] ?? null;

    if (!$donationUnit) {
        echo '<div class="alert alert-danger text-center">Donation Unit not found.</div>';
        return;
    }
    ?>
    <div class="container mt-5 mb-5">
        <h1 class="text-center page-title">Edit Donation Unit</h1>
        
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="edit-banner mb-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-3 fs-4" style="color: var(--primary-blue);"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">You are editing</h6>
                            <p class="mb-0"><?php echo htmlspecialchars($donationUnit->name); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header text-center">
                        <i class="bi bi-pencil-square me-2 blood-accent"></i>
                        Update Donation Unit Information
                    </div>
                    <div class="card-body p-4">
                        <form action="index.php?controller=DonationUnit&action=update&id=<?php echo $donationUnit->id; ?>" method="POST">
                            <div class="mb-4">
                                <label for="name" class="form-label">
                                    <i class="bi bi-hospital me-2"></i>Unit Name
                                </label>
                                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($donationUnit->name); ?>" class="form-control" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="location" class="form-label">
                                    <i class="bi bi-geo-alt me-2"></i>Location
                                </label>
                                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($donationUnit->location); ?>" class="form-control" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="phone" class="form-label">
                                    <i class="bi bi-telephone me-2"></i>Phone Number
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($donationUnit->phone); ?>" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope me-2"></i>Email Address
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-at"></i></span>
                                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($donationUnit->email); ?>" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save2 me-2"></i>Update Donation Unit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="index.php?controller=DonationUnit&action=index" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Donation Units
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php
};

// Include layout
include_once __DIR__ . '/../layouts/AdminLayout/AdminLayout.php';