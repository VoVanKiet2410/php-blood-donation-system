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
            // Enable error reporting for debugging
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

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

            // Initialize events as an empty array first
            global $events;
            $events = [];

            // Fetch events using Eloquent with the donation unit relationship
            $eventsCollection = Event::with('donationUnit')->get();

            // Log the raw collection data for debugging
            error_log("Raw events collection: " . count($eventsCollection) . " items found");

            if ($eventsCollection->count() > 0) {
                // Convert Eloquent collection to a plain PHP array that the view can process
                $events = $eventsCollection->toArray();
                error_log("Converted events to array: " . json_encode(array_slice($events, 0, 2)) . "...");
            } else {
                error_log("No events found in collection, using empty array");
            }

            // Log the data being passed to the view
            error_log("Passing " . count($events) . " events to view");

            // Using require_once to ensure the view is included
            require_once '../app/views/admin/EventBloodDonation/EventBloodDonationList.php';
        } catch (\Exception $e) {
            error_log("Exception in EventController@adminIndex: " . $e->getMessage() . "\n" . $e->getTraceAsString());

            echo '<h3>Error in EventController@adminIndex</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
            echo '<p><strong>File:</strong> ' . $e->getFile() . '</p>';
            echo '<p><strong>Line:</strong> ' . $e->getLine() . '</p>';
        }
    }

    public function adminCreate()
    {
        try {
            $donationUnits = DonationUnit::all();
            // Create a global variable for donationUnits that can be accessed in the view
            global $donationUnits;
            // Initialize with default values
            $donationUnits = [];

            try {
                $donationUnits = DonationUnit::all();
            } catch (Exception $e) {
                echo '<h3>Error in EventController@adminCreate</h3>';
                echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
                return;
            }

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
            if (
                empty($data['name']) || empty($data['eventDate']) ||
                empty($data['eventStartTime']) || empty($data['eventEndTime']) ||
                empty($data['maxRegistrations']) || empty($data['donationUnitId'])
            ) {
                throw new Exception("All fields are required");
            }

            $event = new Event();
            $event->name = $data['name'];
            $event->event_date = $data['eventDate'];
            $event->event_start_time = $data['eventStartTime'];
            $event->event_end_time = $data['eventEndTime'];
            $event->max_registrations = $data['maxRegistrations'];
            $event->current_registrations = 0; // Initialize current registrations
            $event->donation_unit_id = $data['donationUnitId'];
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

    public function adminEdit($id = null)
    {
        try {
            // Get ID from GET parameter if not provided as function argument
            if ($id === null && isset($_GET['id'])) {
                $id = $_GET['id'];
            }

            if (!$id) {
                throw new Exception("No event ID provided");
            }

            global $event;
            global $donationUnits;

            // Initialize with default values
            $event = null;
            $donationUnits = [];

            try {
                $event = Event::find($id);
                if (!$event) {
                    throw new Exception("Event not found with ID: $id");
                }
            } catch (Exception $e) {
                echo '<h3>Error in EventController@adminEdit</h3>';
                echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
                return;
            }

            try {
                $donationUnits = DonationUnit::all();
            } catch (Exception $e) {
                echo '<h3>Error in EventController@adminEdit</h3>';
                echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
                return;
            }

            require_once '../app/views/admin/EventBloodDonation/EventBloodDonationEdit.php';
        } catch (Exception $e) {
            echo '<h3>Error in EventController@adminEdit</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
        }
    }

    public function adminDelete($id = null)
    {
        try {
            // Get ID from GET parameter if not provided as function argument
            if ($id === null && isset($_GET['id'])) {
                $id = $_GET['id'];
            }

            if (!$id) {
                throw new Exception("No event ID provided for deletion");
            }

            $event = Event::find($id);
            if ($event) {
                $event->delete();
            }
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
            if (
                empty($data['name']) || empty($data['eventDate']) ||
                empty($data['eventStartTime']) || empty($data['eventEndTime']) ||
                empty($data['maxRegistrations']) || empty($data['donationUnitId'])
            ) {
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
            $event->donation_unit_id = $data['donationUnitId'];
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
            } else {
                // By default, only show current and future events
                $today = date('Y-m-d');
                $query->where('event_date', '>=', $today);
            }

            // Apply unit filter if provided
            if ($unitId) {
                $query->where('donation_unit_id', $unitId);
            }

            // Order by event date, so nearest events appear first
            $query->orderBy('event_date', 'asc')
                ->orderBy('event_start_time', 'asc');

            // Eager load the donation unit relationship
            $events = $query->with('donationUnit')->get();

            // Create a separate array for event states to avoid modifying the Event object directly
            // This avoids DB compatibility issues while still enabling display of event statuses
            $eventStates = [];
            $now = new \DateTime();
            $today = $now->format('Y-m-d');
            $currentTime = $now->format('H:i:s');

            foreach ($events as $event) {
                $eventId = $event->id;
                $eventStates[$eventId] = [
                    'is_full' => ($event->current_registrations >= $event->max_registrations),
                    'slots_left' => $event->max_registrations - $event->current_registrations,
                    'progress_percent' => ($event->max_registrations > 0)
                        ? min(round(($event->current_registrations / $event->max_registrations) * 100), 100)
                        : 0
                ];

                // Check if event date has passed
                if ($event->event_date < $today) {
                    $eventStates[$eventId]['is_past'] = true;
                    $eventStates[$eventId]['is_today'] = false;
                    $eventStates[$eventId]['is_ongoing'] = false;
                }
                // If it's today, check if the current time has passed the event end time
                elseif ($event->event_date == $today) {
                    $eventStates[$eventId]['is_past'] = ($currentTime > $event->event_end_time);
                    $eventStates[$eventId]['is_today'] = true;
                    $eventStates[$eventId]['is_ongoing'] = ($currentTime >= $event->event_start_time && $currentTime <= $event->event_end_time);
                } else {
                    $eventStates[$eventId]['is_past'] = false;
                    $eventStates[$eventId]['is_today'] = false;
                    $eventStates[$eventId]['is_ongoing'] = false;
                }

                // Determine if users can register for this event
                $eventStates[$eventId]['can_register'] = !$eventStates[$eventId]['is_full'] && !$eventStates[$eventId]['is_past'];
            }

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
     * Show pre-screening questionnaire before booking appointment
     */
    public function preScreening($eventId = null)
    {
        try {
            // Global variable for event
            global $event;
            // Get ID from GET parameter if not provided as function argument
            if ($eventId === null && isset($_GET['id'])) {
                $eventId = $_GET['id'];
            }

            if (!$eventId) {
                throw new Exception("No event ID provided");
            }

            // Check if user is logged in
            if (!isset($_SESSION['user_id'])) {
                // Redirect to login page with return URL
                $_SESSION['redirect_after_login'] = BASE_URL . '/index.php?controller=Event&action=preScreening&id=' . $eventId;
                header('Location: ' . LOGIN_ROUTE);
                exit;
            }

            // Kiểm tra ràng buộc đặt lịch hiến máu cho user
            $userId = $_SESSION['user_id'];
            $user = \App\Models\User::find($userId);
            if ($user) {
                $activeAppointment = \App\Models\Appointment::where('user_cccd', $user->cccd)
                    ->whereIn('status', [0, 1])
                    ->first();
                $lastCompleted = \App\Models\Appointment::where('user_cccd', $user->cccd)
                    ->where('status', 3)
                    ->orderBy('appointment_date_time', 'desc')
                    ->first();
                if ($activeAppointment) {
                    $_SESSION['error_message'] = "Bạn chỉ có thể đặt một lịch hẹn hiến máu tại một thời điểm. Vui lòng hủy hoặc hoàn thành lịch hẹn hiện tại trước khi đặt lịch mới.";
                    header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
                    exit;
                }
                // Nếu có lịch hoàn thành và chưa đủ thời gian chờ thì không cho phép đặt mới
                if ($lastCompleted && $lastCompleted->next_donation_eligible_date) {
                    $now = date('Y-m-d');
                    if ($now < $lastCompleted->next_donation_eligible_date) {
                        $_SESSION['error_message'] = "Bạn cần chờ đến ngày " . date('d/m/Y', strtotime($lastCompleted->next_donation_eligible_date)) . " mới có thể đặt lịch hiến máu tiếp theo.";
                        header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
                        exit;
                    }
                }
            }

            $event = Event::with('donationUnit')->find($eventId);

            if (!$event) {
                throw new Exception("Event not found");
            }

            // Check if event is full
            if ($event->current_registrations >= $event->max_registrations) {
                $_SESSION['error_message'] = "This event is fully booked.";
                header('Location: ' . BASE_URL . '/index.php?controller=Event&action=clientIndex');
                exit;
            }

            // Pass event data to view
            $data = [
                'event' => $event->toArray(),
                'validationErrors' => $_SESSION['validation_errors'] ?? [],
                'oldAnswers' => $_SESSION['old_answers'] ?? [],
            ];

            // Clear validation errors and old answers after showing them once
            unset($_SESSION['validation_errors']);
            unset($_SESSION['old_answers']);

            // Display pre-screening page
            $content = '../app/views/events/pre_screening.php';
            require_once '../app/views/layouts/ClientLayout/ClientLayout.php';
        } catch (Exception $e) {
            echo '<h3>Error in EventController@preScreening</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
            error_log("Exception in EventController@preScreening: " . $e->getMessage());
        }
    }

    /**
     * Validate pre-screening answers and proceed to appointment booking
     */
    public function validatePreScreening()
    {
        try {
            // Get event ID from the form submission
            $eventId = $_POST['event_id'] ?? null;

            if (!$eventId) {
                throw new Exception("No event ID provided");
            }

            // Check if user is logged in
            if (!isset($_SESSION['user_id'])) {
                // Redirect to login page with return URL
                $_SESSION['redirect_after_login'] = BASE_URL . '/index.php?controller=Event&action=validatePreScreening&id=' . $eventId;
                header('Location: ' . LOGIN_ROUTE);
                exit;
            }

            // Kiểm tra ràng buộc đặt lịch hiến máu cho user
            $userId = $_SESSION['user_id'];
            $user = \App\Models\User::find($userId);
            if ($user) {
                $activeAppointment = \App\Models\Appointment::where('user_cccd', $user->cccd)
                    ->whereIn('status', [0, 1])
                    ->first();
                $lastCompleted = \App\Models\Appointment::where('user_cccd', $user->cccd)
                    ->where('status', 3) // Đúng: chỉ lấy lịch hoàn thành (status = 3)
                    ->orderBy('appointment_date_time', 'desc')
                    ->first();
                if ($activeAppointment) {
                    $_SESSION['error_message'] = "Bạn chỉ có thể đặt một lịch hẹn hiến máu tại một thời điểm. Vui lòng hủy hoặc hoàn thành lịch hẹn hiện tại trước khi đặt lịch mới.";
                    header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
                    exit;
                }
                // Nếu có lịch hoàn thành và chưa đủ thời gian chờ thì không cho phép đặt mới
                if ($lastCompleted && $lastCompleted->next_donation_eligible_date) {
                    $now = date('Y-m-d');
                    if ($now < $lastCompleted->next_donation_eligible_date) {
                        $_SESSION['error_message'] = "Bạn cần chờ đến ngày " . date('d/m/Y', strtotime($lastCompleted->next_donation_eligible_date)) . " mới có thể đặt lịch hiến máu tiếp theo.";
                        header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
                        exit;
                    }

                    //log for debugging
                    error_log("User ID: " . $user->cccd);
                    error_log("Last completed appointment date: " . $lastCompleted->appointment_date_time);
                    error_log("Next donation eligible date: " . $lastCompleted->next_donation_eligible_date);
                    error_log("Current date: " . $now);
                    error_log("Eligible for next donation: " . ($now < $lastCompleted->next_donation_eligible_date ? "No" : "Yes"));
                }
            }

            // Validate form submission
            $validationErrors = [];

            // Store form data for redisplay if there are errors
            $_SESSION['old_answers'] = $_POST;

            // Required fields
            $requiredFields = [
                'age_requirement' => 'Vui lòng xác nhận độ tuổi của bạn',
                'weight_requirement' => 'Vui lòng xác nhận cân nặng của bạn',
                'feeling_well' => 'Vui lòng xác nhận tình trạng sức khỏe của bạn',
                'donated_before' => 'Vui lòng xác nhận lịch sử hiến máu của bạn',
                'medication' => 'Vui lòng xác nhận về việc sử dụng thuốc',
                'confirmation' => 'Bạn phải đồng ý với điều khoản và điều kiện'
            ];

            foreach ($requiredFields as $field => $errorMessage) {
                if (!isset($_POST[$field]) || empty($_POST[$field])) {
                    $validationErrors[] = $errorMessage;
                }
            }

            // Validate answers against requirements
            if (isset($_POST['age_requirement']) && $_POST['age_requirement'] === 'no') {
                $validationErrors[] = 'Bạn phải đủ 18 tuổi để hiến máu';
            }

            if (isset($_POST['weight_requirement']) && $_POST['weight_requirement'] === 'no') {
                $validationErrors[] = 'Bạn phải nặng ít nhất 50kg để hiến máu';
            }

            if (isset($_POST['feeling_well']) && $_POST['feeling_well'] === 'no') {
                $validationErrors[] = 'Bạn phải đủ sức khỏe để hiến máu';
            }

            if (isset($_POST['recent_fever']) && $_POST['recent_fever'] === 'yes') {
                $validationErrors[] = 'Người đang cảm, cúm hoặc sốt không đủ điều kiện hiến máu';
            }

            if (isset($_POST['surgery_or_tattoo']) && $_POST['surgery_or_tattoo'] === 'yes') {
                $validationErrors[] = 'Người đã phẫu thuật hoặc xăm hình trong 6 tháng qua không đủ điều kiện hiến máu';
            }

            if (isset($_POST['pregnant_or_nursing']) && $_POST['pregnant_or_nursing'] === 'yes') {
                $validationErrors[] = 'Phụ nữ mang thai hoặc đang cho con bú không đủ điều kiện hiến máu';
            }

            // Validate last donation date if provided
            if (
                isset($_POST['previous_donation']) && $_POST['previous_donation'] === 'yes' &&
                isset($_POST['last_donation_date']) && !empty($_POST['last_donation_date'])
            ) {

                $lastDonationDate = new \DateTime($_POST['last_donation_date']);
                $now = new \DateTime();
                $interval = $now->diff($lastDonationDate);
                $monthsDiff = $interval->m + ($interval->y * 12);

                if ($monthsDiff < 3) {
                    $validationErrors[] = 'Bạn cần chờ ít nhất 3 tháng giữa các lần hiến máu';
                }
            }

            // If there are errors, redirect back to the form
            if (!empty($validationErrors)) {
                $_SESSION['validation_errors'] = $validationErrors;
                header('Location: ' . BASE_URL . '/index.php?controller=Event&action=preScreening&id=' . $eventId);
                exit;
            }

            // If all validation passes, store event ID in session and redirect to appointment creation
            $_SESSION['booking_event_id'] = $eventId;
            $_SESSION['passed_pre_screening'] = true;

            // Redirect to appointment booking form
            header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=clientCreate');
            exit;
        } catch (Exception $e) {
            echo '<h3>Error in EventController@validatePreScreening</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
            error_log("Exception in EventController@validatePreScreening: " . $e->getMessage());
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
            $_SESSION['redirect_after_login'] = BASE_URL . '/index.php?controller=Event&action=bookAppointment&id=' . $eventId;
            header('Location: ' . LOGIN_ROUTE);
            exit();
        }

        try {
            if (!$eventId && isset($_GET['id'])) {
                $eventId = $_GET['id'];
            }

            if (!$eventId) {
                throw new Exception("No event ID provided");
            }

            // Kiểm tra ràng buộc đặt lịch hiến máu cho user
            $userId = $_SESSION['user_id'];
            $user = \App\Models\User::find($userId);
            if ($user) {
                $activeAppointment = \App\Models\Appointment::where('user_cccd', $user->cccd)
                    ->whereIn('status', [0, 1])
                    ->first();
                $lastCompleted = \App\Models\Appointment::where('user_cccd', $user->cccd)
                    ->where('status', 3) // Đúng: chỉ lấy lịch hoàn thành (status = 3)
                    ->orderBy('appointment_date_time', 'desc')
                    ->first();
                if ($activeAppointment) {
                    $_SESSION['error_message'] = "Bạn chỉ có thể đặt một lịch hẹn hiến máu tại một thời điểm. Vui lòng hủy hoặc hoàn thành lịch hẹn hiện tại trước khi đặt lịch mới.";
                    header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
                    exit;
                }
                // Nếu có lịch hoàn thành và chưa đủ thời gian chờ thì không cho phép đặt mới
                if ($lastCompleted && $lastCompleted->next_donation_eligible_date) {
                    $now = date('Y-m-d');
                    if ($now < $lastCompleted->next_donation_eligible_date) {
                        $_SESSION['error_message'] = "Bạn cần chờ đến ngày " . date('d/m/Y', strtotime($lastCompleted->next_donation_eligible_date)) . " mới có thể đặt lịch hiến máu tiếp theo.";
                        header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
                        exit;
                    }
                }
            }

            $event = Event::with('donationUnit')->find($eventId);

            if (!$event) {
                throw new Exception("Event not found");
            }

            // Check if event is full
            if ($event->current_registrations >= $event->max_registrations) {
                $_SESSION['error_message'] = "This event is fully booked.";
                header('Location: ' . BASE_URL . '/index.php?controller=Event&action=clientIndex');
                exit;
            }

            // Redirect to pre-screening questionnaire
            header('Location: ' . BASE_URL . '/index.php?controller=Event&action=preScreening&id=' . $eventId);
            exit;
        } catch (Exception $e) {
            echo '<h3>Error in EventController@bookAppointment</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
            error_log("Exception in EventController@bookAppointment: " . $e->getMessage());
        }
    }
}
