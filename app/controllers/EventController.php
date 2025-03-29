<?php

namespace App\Controllers;

use App\Models\Event;
use App\Models\DonationUnit;
use App\Models\Appointment;
use Exception;

class EventController
{
    public function index()
    {
        $events = Event::all();
        require_once '../app/views/events/index.php';
    }

    public function create()
    {
        $donationUnits = DonationUnit::all();
        require_once '../app/views/events/create.php';
    }

    public function store($data)
    {
        try {
            $event = new Event();
            $event->name = $data['name'];
            $event->eventDate = $data['eventDate'];
            $event->eventStartTime = $data['eventStartTime'];
            $event->eventEndTime = $data['eventEndTime'];
            $event->maxRegistrations = $data['maxRegistrations'];
            $event->currentRegistrations = 0; // Initialize current registrations
            $event->donationUnit_id = $data['donationUnit_id'];
            $event->save();

            header('Location: /events');
        } catch (Exception $e) {
            // Handle exception (e.g., log error, show error message)
        }
    }

    public function edit($id)
    {
        $event = Event::find($id);
        $donationUnits = DonationUnit::all();
        require_once '../app/views/events/edit.php';
    }

    public function update($id, $data)
    {
        try {
            $event = Event::find($id);
            $event->name = $data['name'];
            $event->eventDate = $data['eventDate'];
            $event->eventStartTime = $data['eventStartTime'];
            $event->eventEndTime = $data['eventEndTime'];
            $event->maxRegistrations = $data['maxRegistrations'];
            $event->donationUnit_id = $data['donationUnit_id'];
            $event->save();

            header('Location: /events');
        } catch (Exception $e) {
            // Handle exception (e.g., log error, show error message)
        }
    }

    public function delete($id)
    {
        try {
            $event = Event::find($id);
            $event->delete();
            header('Location: /events');
        } catch (Exception $e) {
            // Handle exception (e.g., log error, show error message)
        }
    }
}