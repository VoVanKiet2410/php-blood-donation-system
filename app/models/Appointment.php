<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'event_id',
        'user_cccd',
        'appointment_date_time',
        'blood_amount',
        'next_donation_eligible_date',
        'status'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_cccd', 'CCCD');
    }

    public function healthcheck()
    {
        return $this->hasOne(Healthcheck::class);
    }

    public function bloodDonationHistory()
    {
        return $this->hasOne(BloodDonationHistory::class);
    }

    public function bloodInventory()
    {
        return $this->hasOne(BloodInventory::class);
    }
}