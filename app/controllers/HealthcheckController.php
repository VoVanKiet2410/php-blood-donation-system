<?php

namespace App\Controllers;

require_once __DIR__ . '/../../config/routes.php';

use App\Models\Healthcheck;
use App\Models\Appointment;
use App\Models\User;
use Exception;
use Illuminate\Database\Capsule\Manager as Capsule;

class HealthcheckController
{
    // Admin functionality for HealthCheck
    public function adminIndex()
    {
        try {
            // For more detailed error debugging
            error_log("HealthcheckController@adminIndex: Attempting to fetch healthchecks");
            
            // Try a simple query first to verify connection
            try {
                global $capsule;
                $testConnection = $capsule->getConnection()->getPdo();
                error_log("Database connection test successful");
            } catch (\Exception $connEx) {
                error_log("Database connection test failed: " . $connEx->getMessage());
                throw new \Exception("Database connection failed: " . $connEx->getMessage(), 0, $connEx);
            }
            
            // Fetch healthchecks using Eloquent
            $healthchecks = Healthcheck::all(); 
            error_log("Fetched healthchecks successfully: " . json_encode($healthchecks));
            
            // Create a global variable for healthchecks that can be accessed in the view
            global $healthchecks;
            
            // Include the view
            include_once '../app/views/admin/HealthCheck/HealthCheckList.php';
            
        } catch (\Exception $e) {
            error_log('Error in HealthcheckController@adminIndex: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            
            // Display detailed error message for debugging
            echo '<h3>Error in HealthcheckController@adminIndex</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
            echo '<p><strong>File:</strong> ' . $e->getFile() . '</p>';
            echo '<p><strong>Line:</strong> ' . $e->getLine() . '</p>';
            echo '<pre><strong>Stack Trace:</strong><br>' . $e->getTraceAsString() . '</pre>';
        }
    }
    
    public function adminCreate()
    {
        try {
            $appointments = Appointment::all();
            
            // Create global variables that can be accessed in the view
            global $appointments;
            
            // Include the view directly
            include_once '../app/views/admin/HealthCheck/HealthCheckCreate.php';
            
        } catch (\Exception $e) {
            error_log('Error in HealthcheckController@adminCreate: ' . $e->getMessage());
            echo '<h3>Error in HealthcheckController@adminCreate</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
        }
    }

    public function adminStore()
    {
        try {
            // Get POST data
            $data = $_POST;
            
            // Validate required fields
            if (empty($data['healthMetrics']) || empty($data['notes']) || empty($data['appointment_id'])) {
                throw new Exception("All fields are required");
            }
            
            $healthcheck = new Healthcheck();
            $healthcheck->health_metrics = json_encode($data['healthMetrics']);
            $healthcheck->notes = $data['notes'];
            $healthcheck->appointment_id = $data['appointment_id'];
            
            // Validate health check and set result
            $healthcheck->isValidHealthCheck();
            $healthcheck->save();

            // Redirect to health check list page
            header('Location: ' . HEALTH_CHECK_ROUTE);
            exit();
        } catch (Exception $e) {
            echo '<h3>Error in HealthcheckController@adminStore</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
        }
    }

    public function adminEdit($id)
    {
        try {
            $healthcheck = Healthcheck::find($id);
            $appointments = Appointment::all();
            
            // Create global variables that can be accessed in the view
            global $healthcheck;
            global $appointments;
            
            include_once '../app/views/admin/HealthCheck/HealthCheckEdit.php';
        } catch (Exception $e) {
            echo '<h3>Error in HealthcheckController@adminEdit</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
        }
    }

    public function adminUpdate($id = null)
    {
        try {
            // Get the ID from GET parameter if not provided as an argument
            if (!$id && isset($_GET['id'])) {
                $id = $_GET['id'];
            }

            if (!$id) {
                throw new Exception("No healthcheck ID provided for update");
            }

            $data = $_POST;
            
            // Validate required fields
            if (empty($data['healthMetrics']) || empty($data['notes'])) {
                throw new Exception("All fields are required");
            }
            
            $healthcheck = Healthcheck::find($id);
            if (!$healthcheck) {
                throw new Exception("Health check not found");
            }
            
            $healthcheck->health_metrics = json_encode($data['healthMetrics']);
            $healthcheck->notes = $data['notes'];
            if (!empty($data['appointment_id'])) {
                $healthcheck->appointment_id = $data['appointment_id'];
            }
            
            // Validate health check and set result
            $healthcheck->isValidHealthCheck();
            $healthcheck->save();

            header('Location: ' . HEALTH_CHECK_ROUTE);
            exit();
        } catch (Exception $e) {
            echo '<h3>Error in HealthcheckController@adminUpdate</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
            error_log("Error updating healthcheck: " . $e->getMessage());
        }
    }

    public function adminDelete($id)
    {
        try {
            $healthcheck = Healthcheck::find($id);
            $healthcheck->delete();
            header('Location: ' . HEALTH_CHECK_ROUTE);
        } catch (Exception $e) {
            echo '<h3>Error in HealthcheckController@adminDelete</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
        }
    }
}