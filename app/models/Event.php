<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'name',
        'eventDate',
        'eventStartTime',
        'eventEndTime',
        'maxRegistrations',
        'currentRegistrations',
        'status',
        'donationUnit_id'
    ];

    public function donationUnit()
    {
        return $this->belongsTo(DonationUnit::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getEventNameAttribute()
    {
        return $this->donationUnit ? 'Hiến máu ' . $this->donationUnit->name : ' ';
    }

    public function getEventByUnitNameAttribute()
    {
        return $this->donationUnit ? $this->donationUnit->name : 'Không tìm thấy ';
    }

    public function getLocationAttribute()
    {
        return $this->donationUnit ? $this->donationUnit->location : ' ';
    }
}