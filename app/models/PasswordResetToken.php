<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';

    protected $fillable = [
        'token',
        'user_id',
        'expiry_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}