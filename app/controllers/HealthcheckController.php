<?php

namespace App\Controllers;

use App\Models\Healthcheck;
use App\Models\Appointment;
use App\Models\User;
use Exception;

class HealthcheckController
{
    public function create()
    {
        // Logic to display the health check creation form
        include_once '../app/views/healthchecks/create.php';
    }

    public function store()
    {
        // Logic to handle the health check form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $healthcheck = new Healthcheck();
            $healthcheck->healthMetrics = json_encode($_POST['healthMetrics']);
            $healthcheck->notes = $_POST['notes'];
            $healthcheck->appointment = Appointment::find($_POST['appointment_id']);
            
            try {
                $healthcheck->isValidHealthCheck();
                $healthcheck->save();
                header('Location: /healthchecks/index');
            } catch (Exception $e) {
                // Handle error
                echo "Error: " . $e->getMessage();
            }
        }
    }

    public function index()
    {
        // Logic to list all health checks
        $healthchecks = Healthcheck::all();
        include_once '../app/views/healthchecks/index.php';
    }

    public function edit($id)
    {
        // Logic to display the health check edit form
        $healthcheck = Healthcheck::find($id);
        include_once '../app/views/healthchecks/edit.php';
    }

    public function update($id)
    {
        // Logic to handle the health check update
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $healthcheck = Healthcheck::find($id);
            $healthcheck->healthMetrics = json_encode($_POST['healthMetrics']);
            $healthcheck->notes = $_POST['notes'];

            try {
                $healthcheck->isValidHealthCheck();
                $healthcheck->save();
                header('Location: /healthchecks/index');
            } catch (Exception $e) {
                // Handle error
                echo "Error: " . $e->getMessage();
            }
        }
    }
}