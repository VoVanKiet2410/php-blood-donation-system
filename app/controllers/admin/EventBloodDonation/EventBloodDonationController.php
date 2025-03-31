<?php

namespace App\Controllers\Admin\EventBloodDonation;

use App\Models\Event;
use App\Models\DonationUnit;

class EventBloodDonationController
{
    public function index()
    {
        try {
            // Enable error reporting for debugging
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            
            // Log attempt to fetch events
            error_log('EventController@adminIndex: Attempting to fetch events');
            
            // Test database connection
            $testConnection = Event::testConnection();
            error_log('Database connection test successful');
            
            // Get all events
            $events = Event::all();
            
            // Log the fetched events
            error_log('Fetched events successfully: ' . json_encode($events));
            
            // Create a global variable for events that can be accessed in the view
            global $events;
            
            // Include the view
            include_once '../app/views/admin/EventBloodDonation/EventBloodDonationList.php';
            
        } catch (\Exception $e) {
            // Log detailed error
            error_log('Error in EventBloodDonationController@index: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            
            // Display detailed error message for debugging
            echo '<h3>Error in EventBloodDonationController@index</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
            echo '<p><strong>File:</strong> ' . $e->getFile() . '</p>';
            echo '<p><strong>Line:</strong> ' . $e->getLine() . '</p>';
            echo '<pre><strong>Stack Trace:</strong><br>' . $e->getTraceAsString() . '</pre>';
        }
    }
    
    public function create()
    {
        try {
            $donationUnits = DonationUnit::all();
            
            // Create global variables that can be accessed in the view
            global $donationUnits;
            
            // Include the view directly
            include_once '../app/views/admin/EventBloodDonation/EventBloodDonationCreate.php';
            
        } catch (\Exception $e) {
            error_log('Error in EventBloodDonationController@create: ' . $e->getMessage());
            echo '<h3>Error in EventBloodDonationController@create</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
        }
    }
}