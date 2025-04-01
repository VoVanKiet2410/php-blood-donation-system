<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationUnit extends Model
{
    protected $table = 'donation_unit';
    
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'description',
        'photo_url'
    ];

    /**
     * Get the events for the donation unit
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'donation_unit_id');
    }
}