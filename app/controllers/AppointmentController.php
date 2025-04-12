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
            header('Location: ' . BASE_URL . '/public/index.php?controller=Event&action=clientIndex');
            exit;
        }

        // Get event ID from session
        $eventId = $_SESSION['booking_event_id'] ?? null;

        if (!$eventId) {
            $_SESSION['error_message'] = "Không tìm thấy thông tin sự kiện.";
            header('Location: ' . BASE_URL . '/public/index.php?controller=Event&action=clientIndex');
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
                header('Location: ' . BASE_URL . '/public/index.php?controller=Event&action=clientIndex');
                exit;
            }

            // Get user information
            $userId = $_SESSION['user_id'];
            $user = User::with('userInfo')->find($userId);

            if (!$user) {
                throw new Exception("Không tìm thấy thông tin người dùng.");
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
        }

        // Verify that the user has passed the pre-screening questionnaire
        if (!isset($_SESSION['passed_pre_screening']) || $_SESSION['passed_pre_screening'] !== true) {
            $_SESSION['error_message'] = "Bạn phải hoàn thành câu hỏi sàng lọc trước khi đặt lịch hiến máu.";
            header('Location: ' . BASE_URL . '/public/index.php?controller=Event&action=c\ClientIndex');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/public/index.php?controller=Event&action=clientIndex');
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

        // If there are validation errors, redirect back to form
        if (!empty($errors)) {
            error_log("Validation errors: " . json_encode($errors));
            $_SESSION['appointment_errors'] = $errors;
            header('Location: ' . BASE_URL . '/public/index.php?controller=Appointment&action=clientCreate');
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
            header('Location: ' . BASE_URL . '/public/index.php?controller=User&action=dashboard');
            exit;
        } catch (Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            error_log("Exception in AppointmentController@store: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());

            $errors[] = "Lỗi khi đặt lịch hiến máu: " . $e->getMessage();
            $_SESSION['appointment_errors'] = $errors;

            header('Location: ' . BASE_URL . '/public/index.php?controller=Appointment&action=clientCreate');
            exit;
        }
    }

    /**
     * Show list of appointments for logged in user
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

            // Get user's appointments
            $appointments = Appointment::with(['event', 'event.donationUnit'])
                ->where('user_cccd', $userCccd)
                ->orderBy('appointment_date_time', 'desc')
                ->get();

            // Prepare data for the view
            $data = [
                'appointments' => $appointments,
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
}
