<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodDonationHistory extends Model
{
    protected $table = 'blood_donation_histories';

    protected $fillable = [
        'donation_date_time',
        'blood_amount',
        'donation_location',
        'notes',
        'donation_type',
        'reaction_after_donation',
        'user_id',
        'appointment_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}