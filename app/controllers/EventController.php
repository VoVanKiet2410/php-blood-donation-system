<?php

namespace App\Controllers;

require_once __DIR__ . '/../../config/routes.php';

use App\Models\Event;
use App\Models\DonationUnit;
use App\Models\Appointment;
use Exception;
use Illuminate\Database\Capsule\Manager as Capsule;

class EventController
{
    public function adminIndex()
    {
        try {
            // More detailed error debugging
            error_log("EventController@adminIndex: Attempting to fetch events");
            
            // Try a simple query first to verify connection
            try {
                global $capsule;
                $testConnection = $capsule->getConnection()->getPdo();
                error_log("Database connection test successful");
            } catch (\Exception $connEx) {
                error_log("Database connection test failed: " . $connEx->getMessage());
                throw new \Exception("Database connection failed: " . $connEx->getMessage(), 0, $connEx);
            }
            
            // Fetch events using Eloquent
            $events = Event::all(); 
            // foreach ($events as $event) {
            //     echo '<pre>';
            //     print_r($event->toArray());
            //     echo '</pre>';
            // }
            error_log("Fetched events successfully: " . json_encode($events));
            
            // Create a global variable for events that can be accessed in the view
            // Make sure $events is always an array even if the query returns null
            global $events;
            $events = $events ?? [];
            $data = ['events' => $events];
            require_once '../app/views/admin/EventBloodDonation/EventBloodDonationList.php';
        } catch (\Exception $e) {
            echo '<h3>Error in EventController@adminIndex</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
            echo '<p><strong>File:</strong> ' . $e->getFile() . '</p>';
            echo '<p><strong>Line:</strong> ' . $e->getLine() . '</p>';
            // Log the full exception for debugging
            error_log("Exception in EventController@adminIndex: " . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function adminCreate()
    {
        try {
            $donationUnits = DonationUnit::all();
            require_once '../app/views/admin/EventBloodDonation/EventBloodDonationCreate.php';
        } catch (Exception $e) {
            echo '<h3>Error in EventController@adminCreate</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
        }
    }

    public function adminStore()
    {
        try {
            // Get POST data
            $data = $_POST;
            
            // Validate required fields
            if (empty($data['name']) || empty($data['eventDate']) || 
                empty($data['eventStartTime']) || empty($data['eventEndTime']) || 
                empty($data['maxRegistrations']) || empty($data['donationUnit_id'])) {
                throw new Exception("All fields are required");
            }
            
            $event = new Event();
            $event->name = $data['name'];
            $event->event_date = $data['eventDate'];
            $event->event_start_time = $data['eventStartTime'];
            $event->event_end_time = $data['eventEndTime'];
            $event->max_registrations = $data['maxRegistrations'];
            $event->current_registrations = 0; // Initialize current registrations
            $event->donation_unit_id = $data['donationUnit_id'];
            // Use integer for status: 1 for active, 0 for inactive
            $event->status = isset($data['status']) ? (int)$data['status'] : 1;
            $event->save();

            // Access the constant as a global constant
            header('Location: ' . EVENT_BLOOD_DONATION_ROUTE);
            exit();
        } catch (Exception $e) {
            echo '<h3>Error in EventController@adminStore</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
            echo '<p><strong>SQL Query:</strong> ' . (isset($e->getPrevious()->getSql) ? $e->getPrevious()->getSql() : 'N/A') . '</p>';
        }
    }

    public function adminEdit($id)
    {
        try {
            $event = Event::find($id);
            $donationUnits = DonationUnit::all();
            require_once '../app/views/admin/EventBloodDonation/EventBloodDonationEdit.php';
        } catch (Exception $e) {
            echo '<h3>Error in EventController@adminEdit</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
        }
    }

    public function adminDelete($id)
    {
        try {
            $event = Event::find($id);
            $event->delete();
            header('Location: ' . EVENT_BLOOD_DONATION_ROUTE);
        } catch (Exception $e) {
            echo '<h3>Error in EventController@adminDelete</h3>';
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
                throw new Exception("No event ID provided for update");
            }

            $data = $_POST;
            
            // Validate required fields
            if (empty($data['name']) || empty($data['eventDate']) || 
                empty($data['eventStartTime']) || empty($data['eventEndTime']) || 
                empty($data['maxRegistrations']) || empty($data['donationUnit_id'])) {
                throw new Exception("All fields are required");
            }
            
            $event = Event::find($id);
            if (!$event) {
                throw new Exception("Event not found");
            }
            
            $event->name = $data['name'];
            $event->event_date = $data['eventDate'];
            $event->event_start_time = $data['eventStartTime'];
            $event->event_end_time = $data['eventEndTime'];
            $event->max_registrations = $data['maxRegistrations'];
            $event->donation_unit_id = $data['donationUnit_id'];
            // Use integer for status: 1 for active, 0 for inactive
            $event->status = isset($data['status']) ? (int)$data['status'] : $event->status;
            $event->save();

            header('Location: ' . EVENT_BLOOD_DONATION_ROUTE);
            exit();
        } catch (Exception $e) {
            echo '<h3>Error in EventController@adminUpdate</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
            error_log("Error updating event: " . $e->getMessage());
        }
    }

    /**
     * Client-side event listing
     */
    public function clientIndex()
    {
        try {
            // Get filter parameters from GET request
            $startDate = $_GET['startDate'] ?? null;
            $endDate = $_GET['endDate'] ?? null;
            $unitId = $_GET['unitId'] ?? null;
            
            // Get donation units for the filter dropdown
            $donationUnits = DonationUnit::all();
            
            // Start building the query
            $query = Event::query()->where('status', 1); // Only active events
            
            // Apply date range filter if provided
            if ($startDate && $endDate) {
                $query->where('event_date', '>=', $startDate)
                      ->where('event_date', '<=', $endDate);
            }
            
            // Apply unit filter if provided
            if ($unitId) {
                $query->where('donation_unit_id', $unitId);
            }
            
            // Eager load the donation unit relationship
            $events = $query->with('donationUnit')->get();
            
            // Get pagination parameters
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $itemsPerPage = 5;
            $totalEvents = count($events);
            $totalPages = ceil($totalEvents / $itemsPerPage);
            
            // Adjust page if out of bounds
            if ($page < 1) $page = 1;
            if ($page > $totalPages && $totalPages > 0) $page = $totalPages;
            
            // Calculate start and end index for current page
            $startIndex = ($page - 1) * $itemsPerPage;
            $currentEvents = array_slice($events->toArray(), $startIndex, $itemsPerPage);
            
            // Set the content to be included in the layout
            $content = '../app/views/events/index.php';
            
            // Include the client layout
            require_once '../app/views/layouts/ClientLayout/ClientLayout.php';
        } catch (Exception $e) {
            echo '<h3>Error in EventController@clientIndex</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
            error_log("Exception in EventController@clientIndex: " . $e->getMessage());
        }
    }
    
    /**
     * Book an appointment for an event
     */
    public function bookAppointment($eventId = null)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page with return URL
            $_SESSION['redirect_after_login'] = BASE_URL . '/public/index.php?controller=Event&action=bookAppointment&id=' . $eventId;
            header('Location: ' . LOGIN_ROUTE);
            exit;
        }
        
        try {
            if (!$eventId && isset($_GET['id'])) {
                $eventId = $_GET['id'];
            }
            
            if (!$eventId) {
                throw new Exception("No event ID provided");
            }
            
            $event = Event::with('donationUnit')->find($eventId);
            
            if (!$event) {
                throw new Exception("Event not found");
            }
            
            // Check if event is full
            if ($event->current_registrations >= $event->max_registrations) {
                $_SESSION['error_message'] = "This event is fully booked.";
                header('Location: ' . BASE_URL . '/public/index.php?controller=Event&action=clientIndex');
                exit;
            }
            
            // Store event in session for the booking form
            $_SESSION['booking_event_id'] = $eventId;
            
            // Redirect to appointment booking form
            header('Location: ' . BASE_URL . '/public/index.php?controller=Appointment&action=create');
            exit;
        } catch (Exception $e) {
            echo '<h3>Error in EventController@bookAppointment</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
            error_log("Exception in EventController@bookAppointment: " . $e->getMessage());
        }
    }
}