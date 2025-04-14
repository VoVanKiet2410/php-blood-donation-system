<?php

namespace App\Controllers;

use App\Models\Appointment;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Capsule\Manager as DB;
use Exception;

class AppointmentController
{
    /**
     * Show appointment creation form
     */
    public function clientCreate()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error_message'] = "Bạn phải đăng nhập để đặt lịch hiến máu.";
            header('Location: ' . LOGIN_ROUTE);
            exit;
        }

        // Verify that the user has passed the pre-screening questionnaire
        if (!isset($_SESSION['passed_pre_screening']) || $_SESSION['passed_pre_screening'] !== true) {
            $_SESSION['error_message'] = "Bạn phải hoàn thành câu hỏi sàng lọc trước khi đặt lịch hiến máu.";
            header('Location: ' . BASE_URL . '/index.php?controller=Event&action=clientIndex');
            exit;
        }

        // Get event ID from session
        $eventId = $_SESSION['booking_event_id'] ?? null;

        if (!$eventId) {
            $_SESSION['error_message'] = "Không tìm thấy thông tin sự kiện.";
            header('Location: ' . BASE_URL . '/index.php?controller=Event&action=clientIndex');
            exit;
        }

        try {
            // Get event details
            $event = Event::with('donationUnit')->find($eventId);

            if (!$event) {
                throw new Exception("Không tìm thấy sự kiện.");
            }

            // Check if event is full
            if ($event->current_registrations >= $event->max_registrations) {
                $_SESSION['error_message'] = "Sự kiện đã đủ số lượng đăng ký.";
                header('Location: ' . BASE_URL . '/index.php?controller=Event&action=clientIndex');
                exit;
            }

            // Get user information
            $userId = $_SESSION['user_id'];
            $user = User::with('userInfo')->find($userId);

            if (!$user) {
                throw new Exception("Không tìm thấy thông tin người dùng.");
            }

            // Kiểm tra ràng buộc: Nếu user còn lịch hẹn đang chờ/xác nhận hoặc chưa đủ thời gian giữa 2 lần hiến máu thì không cho phép đặt mới
            $activeAppointment = Appointment::where('user_cccd', $user->cccd)
                ->whereIn('status', [0, 1])
                ->orderBy('appointment_date_time', 'desc')
                ->first();
            if ($activeAppointment) {
                $_SESSION['error_message'] = "Bạn chỉ có thể đặt một lịch hẹn hiến máu tại một thời điểm. Vui lòng hủy hoặc hoàn thành lịch hẹn hiện tại trước khi đặt lịch mới.";
                header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
                exit;
            }
            // Kiểm tra thời gian chờ giữa 2 lần hiến máu
            $lastCompleted = Appointment::where('user_cccd', $user->cccd)
                ->where('status', 2)
                ->orderBy('appointment_date_time', 'desc')
                ->first();
            if ($lastCompleted && $lastCompleted->next_donation_eligible_date) {
                $now = date('Y-m-d');
                if ($now < $lastCompleted->next_donation_eligible_date) {
                    $_SESSION['error_message'] = "Bạn cần chờ đến ngày " . date('d/m/Y', strtotime($lastCompleted->next_donation_eligible_date)) . " mới có thể đặt lịch hiến máu tiếp theo.";
                    header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
                    exit;
                }
            }

            $errors = $_SESSION['appointment_errors'] ?? [];
            unset($_SESSION['appointment_errors']);

            $formData = $_SESSION['appointment_form_data'] ?? [];
            unset($_SESSION['appointment_form_data']);

            // Prepare data for the view
            $data = [
                'event' => $event,
                'user' => $user,
                'errors' => $errors,
                'formData' => $formData
            ];

            // Render the view
            $content = '../app/views/appointments/client_create.php';
            require_once '../app/views/layouts/ClientLayout/ClientLayout.php';
        } catch (Exception $e) {
            echo '<h3>Error in AppointmentController@create</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
            error_log("Exception in AppointmentController@create: " . $e->getMessage());
        }
    }

    /**
     * Store a new appointment
     */
    public function clientStore()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error_message'] = "Bạn phải đăng nhập để đặt lịch hiến máu.";
            header('Location: ' . LOGIN_ROUTE);
            exit;
        }        // Verify that the user has passed the pre-screening questionnaire
        if (!isset($_SESSION['passed_pre_screening']) || $_SESSION['passed_pre_screening'] !== true) {
            $_SESSION['error_message'] = "Bạn phải hoàn thành câu hỏi sàng lọc trước khi đặt lịch hiến máu.";
            header('Location: ' . BASE_URL . '/index.php?controller=Event&action=clientIndex');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/index.php?controller=Event&action=clientIndex');
            exit;
        }

        // Store form data for redisplay if needed
        $_SESSION['appointment_form_data'] = $_POST;

        // Validate form data
        $errors = [];
        $eventId = $_POST['event_id'] ?? $_SESSION['booking_event_id'] ?? null;
        $appointmentDateTime = $_POST['appointment_date_time'] ?? null;
        $bloodAmount = $_POST['blood_amount'] ?? null;

        // Debug information
        error_log("POST data: " . json_encode($_POST));
        error_log("Session event ID: " . ($_SESSION['booking_event_id'] ?? 'not set'));
        error_log("Event ID used: " . ($eventId ?? 'null'));

        if (empty($eventId)) {
            $errors[] = "Vui lòng chọn sự kiện hiến máu.";
        }

        if (empty($appointmentDateTime)) {
            $errors[] = "Vui lòng chọn ngày và giờ hẹn.";
        } else {
            // Validate appointment time is within event time range
            try {
                $event = Event::find($eventId);
                if ($event) {
                    $eventDate = date('Y-m-d', strtotime($event->event_date));
                    $appointmentDate = date('Y-m-d', strtotime($appointmentDateTime));

                    // Check if appointment date matches event date
                    if ($eventDate !== $appointmentDate) {
                        $errors[] = "Ngày hẹn phải trùng với ngày diễn ra sự kiện ($appointmentDate khác $eventDate).";
                    }

                    // Check if appointment time is within event time range
                    $eventStartTime = strtotime($event->event_date . ' ' . $event->event_start_time);
                    $eventEndTime = strtotime($event->event_date . ' ' . $event->event_end_time);
                    $appointmentTime = strtotime($appointmentDateTime);

                    if ($appointmentTime < $eventStartTime || $appointmentTime > $eventEndTime) {
                        $errors[] = "Thời gian hẹn phải nằm trong khoảng thời gian diễn ra sự kiện.";
                    }
                } else {
                    $errors[] = "Không tìm thấy sự kiện với ID: $eventId";
                    error_log("Event not found with ID: $eventId");
                }
            } catch (Exception $e) {
                $errors[] = "Lỗi khi kiểm tra thời gian hẹn: " . $e->getMessage();
                error_log("Exception in AppointmentController@store: " . $e->getMessage());
            }
        }

        if (empty($bloodAmount)) {
            $errors[] = "Vui lòng nhập lượng máu dự kiến hiến.";
        } else if (!is_numeric($bloodAmount) || $bloodAmount < 250 || $bloodAmount > 450) {
            $errors[] = "Lượng máu phải từ 250ml đến 450ml.";
        }

        // Kiểm tra ràng buộc trước khi lưu: Nếu user còn lịch hẹn đang chờ/xác nhận hoặc chưa đủ thời gian giữa 2 lần hiến máu thì không cho phép đặt mới
        $user = User::find($_SESSION['user_id']);
        if ($user) {
            $activeAppointment = Appointment::where('user_cccd', $user->cccd)
                ->whereIn('status', [0, 1])
                ->orderBy('appointment_date_time', 'desc')
                ->first();
            if ($activeAppointment) {
                $errors[] = "Bạn chỉ có thể đặt một lịch hẹn hiến máu tại một thời điểm. Vui lòng hủy hoặc hoàn thành lịch hẹn hiện tại trước khi đặt lịch mới.";
            }
            $lastCompleted = Appointment::where('user_cccd', $user->cccd)
                ->where('status', 2)
                ->orderBy('appointment_date_time', 'desc')
                ->first();
            if ($lastCompleted && $lastCompleted->next_donation_eligible_date) {
                $now = date('Y-m-d');
                if ($now < $lastCompleted->next_donation_eligible_date) {
                    $errors[] = "Bạn cần chờ đến ngày " . date('d/m/Y', strtotime($lastCompleted->next_donation_eligible_date)) . " mới có thể đặt lịch hiến máu tiếp theo.";
                }
            }
        }

        // If there are validation errors, redirect back to form
        if (!empty($errors)) {
            error_log("Validation errors: " . json_encode($errors));
            $_SESSION['appointment_errors'] = $errors;
            header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=clientCreate');
            exit;
        }

        try {
            // Begin transaction
            DB::beginTransaction();

            // Get user info
            $user = User::find($_SESSION['user_id']);
            if (!$user || empty($user->cccd)) {
                throw new Exception("Không tìm thấy thông tin người dùng hoặc CCCD trống");
            }
            $userCccd = $user->cccd;
            error_log("User CCCD: $userCccd");

            // Create new appointment
            $appointment = new Appointment();
            $appointment->user_cccd = $userCccd;
            $appointment->event_id = $eventId;
            $appointment->appointment_date_time = $appointmentDateTime;
            $appointment->blood_amount = $bloodAmount;
            $appointment->status = 0; // PENDING

            error_log("About to save appointment: " . json_encode($appointment->toArray()));
            $saved = $appointment->save();

            if (!$saved) {
                throw new Exception("Lỗi khi lưu thông tin lịch hẹn.");
            }
            error_log("Appointment saved successfully with ID: " . $appointment->id);

            // Update event current_registrations
            $event = Event::find($eventId);
            if (!$event) {
                throw new Exception("Không tìm thấy sự kiện với ID: $eventId");
            }

            $event->current_registrations = $event->current_registrations + 1;
            $eventSaved = $event->save();

            if (!$eventSaved) {
                throw new Exception("Lỗi khi cập nhật số lượng đăng ký cho sự kiện.");
            }
            error_log("Event registrations updated: " . $event->current_registrations);

            // Commit transaction
            DB::commit();
            error_log("Transaction committed successfully");

            // Clear session data
            unset($_SESSION['passed_pre_screening']);
            unset($_SESSION['booking_event_id']);
            unset($_SESSION['appointment_form_data']);

            // Set success message
            $_SESSION['success_message'] = "Đặt lịch hiến máu thành công! Chúng tôi sẽ liên hệ với bạn để xác nhận lịch hẹn.";

            // Redirect to user dashboard or appointment list
            header('Location: ' . BASE_URL . '/index.php?controller=Home&action=index');
            exit;
        } catch (Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            error_log("Exception in AppointmentController@store: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());

            $errors[] = "Lỗi khi đặt lịch hiến máu: " . $e->getMessage();
            $_SESSION['appointment_errors'] = $errors;

            header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=clientCreate');
            exit;
        }
    }
    /**
     * Show list of appointments for logged in user
     * If the user has no appointments, prompt them to create one
     * If they have appointments, show only active ones since users can only donate blood once in a specific timeframe
     */
    public function userAppointments()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error_message'] = "Bạn phải đăng nhập để xem lịch hẹn hiến máu.";
            header('Location: ' . LOGIN_ROUTE);
            exit;
        }

        try {
            $userId = $_SESSION['user_id'];
            $user = User::find($userId);

            if (!$user) {
                throw new Exception("Không tìm thấy thông tin người dùng.");
            }

            $userCccd = $user->cccd;

            // Get user's active appointments (pending or confirmed)
            // Focus on appointments with status 0 (pending) or 1 (confirmed)
            $activeAppointments = Appointment::with(['event', 'event.donationUnit'])
                ->where('user_cccd', $userCccd)
                ->whereIn('status', [0, 1]) // Only pending or confirmed appointments
                ->orderBy('appointment_date_time', 'asc') // Sort by appointment time (ascending)
                ->get();

            // Get completed appointments (for history)
            $completedAppointments = Appointment::with(['event', 'event.donationUnit'])
                ->where('user_cccd', $userCccd)
                ->where('status', 2) // Completed appointments
                ->orderBy('appointment_date_time', 'desc')
                ->get();

            // Get canceled appointments
            $canceledAppointments = Appointment::with(['event', 'event.donationUnit'])
                ->where('user_cccd', $userCccd)
                ->where('status', 3) // Canceled appointments
                ->orderBy('appointment_date_time', 'desc')
                ->get();

            // Merge all appointments for display but prioritize active ones
            $appointments = $activeAppointments->concat($completedAppointments)->concat($canceledAppointments);

            // Check if the user can schedule a new appointment
            $canScheduleNew = $activeAppointments->isEmpty();

            // Prepare data for the view
            $data = [
                'appointments' => $appointments,
                'activeAppointments' => $activeAppointments,
                'canScheduleNew' => $canScheduleNew,
                'user' => $user
            ];

            // Render the view
            $content = '../app/views/appointments/user_appointments.php';
            require_once '../app/views/layouts/ClientLayout/ClientLayout.php';
        } catch (Exception $e) {
            echo '<h3>Error in AppointmentController@userAppointments</h3>';
            echo '<p><strong>Message:</strong> ' . $e->getMessage() . '</p>';
            error_log("Exception in AppointmentController@userAppointments: " . $e->getMessage());
        }
    }
    /**
     * Show a single appointment in detail as an invitation card
     */
    public function viewAppointment()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error_message'] = "Bạn phải đăng nhập để xem lịch hẹn hiến máu.";
            header('Location: ' . LOGIN_ROUTE);
            exit;
        }

        // Get appointment ID from URL with multiple fallback methods
        $appointmentId = null;

        // Method 1: Try direct GET parameter
        if (isset($_GET['id'])) {
            $appointmentId = $_GET['id'];
        }
        // Method 2: Check if it's in the URI path 
        else if (isset($_SERVER['REQUEST_URI'])) {
            $uri = $_SERVER['REQUEST_URI'];
            if (preg_match('/[&?]id=(\d+)/', $uri, $matches)) {
                $appointmentId = $matches[1];
            }
        }

        // Log appointment ID for debugging
        error_log("Appointment ID from URL: " . ($appointmentId ?? 'not found'));

        if (!$appointmentId) {
            // If no appointment ID, check if user has only one appointment and use that
            try {
                $userId = $_SESSION['user_id'];
                $user = User::find($userId);

                if ($user) {
                    $userCccd = $user->cccd;

                    // Try to get the most recent appointment for this user
                    $latestAppointment = Appointment::where('user_cccd', $userCccd)
                        ->orderBy('created_at', 'desc')
                        ->first();

                    if ($latestAppointment) {
                        $appointmentId = $latestAppointment->id;
                        error_log("Using latest appointment ID as fallback: " . $appointmentId);
                    }
                }
            } catch (Exception $e) {
                error_log("Error in fallback appointment lookup: " . $e->getMessage());
            }

            // If still no appointment ID, redirect to the list
            if (!$appointmentId) {
                $_SESSION['error_message'] = "Không tìm thấy thông tin lịch hẹn.";
                header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
                exit;
            }
        }

        try {
            // Get user info
            $userId = $_SESSION['user_id'];
            $user = User::find($userId);

            //Log user ID for debugging
            error_log("User ID from session: " . $userId);

            if (!$user) {
                throw new Exception("Không tìm thấy thông tin người dùng.");
            }

            $userCccd = $user->cccd;

            // Get appointment details with related data
            $appointment = Appointment::with(['event', 'event.donationUnit'])
                ->where('id', $appointmentId)
                ->where('user_cccd', $userCccd) // Security: ensure appointment belongs to logged-in user
                ->first();

            if (!$appointment) {
                //Log error if appointment not found
                error_log("Appointment not found for ID: " . $appointmentId . " and user CCCD: " . $userCccd);
                throw new Exception("Không tìm thấy lịch hẹn hoặc bạn không có quyền xem lịch hẹn này.");
            }

            // Prepare data for the view
            $data = [
                'appointment' => $appointment,
                'user' => $user
            ];

            // Render the view
            $content = '../app/views/appointments/appointment_details.php';
            require_once '../app/views/layouts/ClientLayout/ClientLayout.php';
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
            exit;
        }
    }

    /**
     * Cancel an appointment
     * This method handles appointment cancellation from both user_appointments.php and appointment_details.php
     */
    public function cancelAppointment()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error_message'] = "Bạn phải đăng nhập để hủy lịch hẹn hiến máu.";
            header('Location: ' . LOGIN_ROUTE);
            exit;
        }

        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = "Phương thức không được hỗ trợ.";
            header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
            exit;
        }

        // Get appointment ID from form submission
        $appointmentId = $_POST['appointment_id'] ?? null;
        if (!$appointmentId) {
            $_SESSION['error_message'] = "Không tìm thấy ID lịch hẹn.";
            header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
            exit;
        }

        // Get cancellation reason
        $cancelReason = $_POST['cancel_reason'] ?? 'other';
        $otherReason = $_POST['other_reason'] ?? '';
        $finalReason = ($cancelReason === 'other' && !empty($otherReason)) ? $otherReason : $cancelReason;

        try {
            // Begin transaction
            DB::beginTransaction();

            // Get user info
            $userId = $_SESSION['user_id'];
            $user = User::find($userId);

            if (!$user) {
                throw new Exception("Không tìm thấy thông tin người dùng.");
            }

            $userCccd = $user->cccd;

            // Find the appointment
            $appointment = Appointment::where('id', $appointmentId)
                ->where('user_cccd', $userCccd) // Security check to ensure this appointment belongs to the user
                ->whereIn('status', [0, 1]) // Can only cancel pending (0) or confirmed (1) appointments
                ->first();

            if (!$appointment) {
                throw new Exception("Không tìm thấy lịch hẹn hoặc lịch hẹn không thể hủy.");
            }

            // Get event info before updating appointment
            $event = Event::find($appointment->event_id);
            if (!$event) {
                throw new Exception("Không tìm thấy thông tin sự kiện.");
            }

            // Update appointment status to canceled (3)
            $appointment->status = 3; // Canceled status
            $appointment->cancel_reason = $finalReason;
            $appointment->save();

            // Decrease event registrations count
            $event->current_registrations = max(0, $event->current_registrations - 1);
            $event->save();

            // Commit transaction
            DB::commit();

            // Set success message
            $_SESSION['success_message'] = "Lịch hẹn đã được hủy thành công.";

            // Redirect to appointments list
            header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
            exit;
        } catch (Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            error_log("Exception in AppointmentController@cancelAppointment: " . $e->getMessage());

            $_SESSION['error_message'] = "Lỗi khi hủy lịch hẹn: " . $e->getMessage();
            header('Location: ' . BASE_URL . '/index.php?controller=Appointment&action=userAppointments');
            exit;
        }
    }
}