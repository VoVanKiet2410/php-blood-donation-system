<?php

namespace App\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Event;
use App\Models\BloodInventory;
use App\Models\Healthcheck;
use App\Models\BloodDonationHistory;

class AppointmentController
{
    public function index()
    {
        $appointments = Appointment::all();
        require_once '../app/views/appointments/index.php';
    }

    public function create()
    {
        $users = User::all();
        $events = Event::all();
        require_once '../app/views/appointments/create.php';
    }

    public function store($data)
    {
        $appointment = new Appointment();
        $appointment->user_id = $data['user_id'];
        $appointment->event_id = $data['event_id'];
        $appointment->appointmentDateTime = $data['appointmentDateTime'];
        $appointment->bloodAmount = $data['bloodAmount'];
        $appointment->status = 'PENDING'; // Default status

        if ($appointment->save()) {
            header('Location: /appointments');
        } else {
            // Handle error
        }
    }

    public function edit($id)
    {
        $appointment = Appointment::find($id);
        $users = User::all();
        $events = Event::all();
        require_once '../app/views/appointments/edit.php';
    }

    public function update($id, $data)
    {
        $appointment = Appointment::find($id);
        $appointment->user_id = $data['user_id'];
        $appointment->event_id = $data['event_id'];
        $appointment->appointmentDateTime = $data['appointmentDateTime'];
        $appointment->bloodAmount = $data['bloodAmount'];
        $appointment->status = $data['status'];

        if ($appointment->save()) {
            header('Location: /appointments');
        } else {
            // Handle error
        }
    }

    public function delete($id)
    {
        $appointment = Appointment::find($id);
        if ($appointment) {
            $appointment->delete();
            header('Location: /appointments');
        } else {
            // Handle error
        }
    }
}