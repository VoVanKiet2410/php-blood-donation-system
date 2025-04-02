<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationUnit extends Model
{
    protected $table = 'donation_unit';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'description',
        'photo_url',
        'operating_hours',
        'status'
    ];

    // Enable timestamps for better record-keeping
    public $timestamps = true;

    /**
     * Get the events for the donation unit
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'donation_unit_id');
    }

    /**
     * Get the inventory records for this donation unit
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bloodInventory()
    {
        return $this->hasMany(BloodInventory::class, 'donation_unit_id');
    }

    /**
     * Get the appointments associated with this donation unit
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'donation_unit_id');
    }

    /**
     * Validate donation unit data
     * 
     * @param array $data
     * @return array|bool
     */
    public static function validate($data)
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        }

        if (empty($data['address'])) {
            $errors['address'] = 'Address is required';
        }

        if (empty($data['phone']) || !preg_match('/^\d{10,11}$/', $data['phone'])) {
            $errors['phone'] = 'Valid phone number is required (10-11 digits)';
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Valid email address is required';
        }

        return empty($errors) ? true : $errors;
    }

    /**
     * Get active donation units
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActive()
    {
        return self::where('status', 'active')->get();
    }
}