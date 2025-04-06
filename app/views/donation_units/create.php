<!-- filepath: c:\xampp\htdocs\php-blood-donation-system\app\views\donation_units\create.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Donation Unit</title>
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
            min-height: 100vh;
            padding: 1rem;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
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
        
        /* Responsive styles */
        @media (max-width: 576px) {
            .page-title {
                font-size: 1.8rem;
            }
            
            .card-header {
                padding: 1.25rem 1rem;
            }
            
            .card-body {
                padding: 1.25rem 1rem !important;
            }
            
            .input-group-text, .form-control {
                padding: 10px 12px;
            }
            
            .btn-primary, .btn-outline-secondary {
                padding: 10px 15px;
                font-size: 0.95rem;
            }
            
            .container {
                padding: 0 0.75rem;
            }
        }
        
        @media (min-width: 577px) and (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .container {
                padding: 0 1rem;
            }
        }
        
        @media (min-width: 992px) {
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            }
        }
        
        /* Animation for button interactions */
        @media (prefers-reduced-motion: no-preference) {
            .btn-primary, .btn-outline-secondary {
                position: relative;
                overflow: hidden;
            }
            
            .btn-primary::after, .btn-outline-secondary::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 5px;
                height: 5px;
                background: rgba(255, 255, 255, 0.5);
                opacity: 0;
                border-radius: 100%;
                transform: scale(1, 1) translate(-50%);
                transform-origin: 50% 50%;
            }
            
            .btn-primary:focus::after, .btn-outline-secondary:focus::after {
                animation: ripple 1s ease-out;
            }
            
            @keyframes ripple {
                0% {
                    transform: scale(0, 0);
                    opacity: 0.5;
                }
                100% {
                    transform: scale(20, 20);
                    opacity: 0;
                }
            }
        }
    </style>
</head>
<?php

$content = function () {
    ?>
    <div class="container mt-4 mt-lg-5 mb-4 mb-lg-5">
        <h1 class="text-center page-title">Create Donation Unit</h1>
        
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-7 col-xl-6">
                <div class="card">
                    <div class="card-header text-center">
                        <i class="bi bi-droplet-fill me-2 blood-accent"></i>
                        Enter Donation Unit Details
                    </div>
                    <div class="card-body p-3 p-sm-4">
                        <form action="index.php?controller=DonationUnit&action=store" method="POST">
                            <div class="mb-3 mb-md-4">
                                <label for="name" class="form-label">
                                    <i class="bi bi-hospital me-2"></i>Unit Name
                                </label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter donation unit name" required>
                            </div>
                            
                            <div class="mb-3 mb-md-4">
                                <label for="location" class="form-label">
                                    <i class="bi bi-geo-alt me-2"></i>Location
                                </label>
                                <input type="text" id="location" name="location" class="form-control" placeholder="Enter location address" required>
                            </div>
                            
                            <div class="mb-3 mb-md-4">
                                <label for="phone" class="form-label">
                                    <i class="bi bi-telephone me-2"></i>Phone Number
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter contact number" required>
                                </div>
                            </div>
                            
                            <div class="mb-3 mb-md-4">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope me-2"></i>Email Address
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-at"></i></span>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address" required>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Create Donation Unit
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