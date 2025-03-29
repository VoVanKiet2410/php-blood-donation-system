<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationUnit extends Model
{
    protected $table = 'donation_units';

    protected $fillable = [
        'name',
        'location',
        'phone',
        'email',
        'unitPhotoUrl',
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'donationUnit_id');
    }
}