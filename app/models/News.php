<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'content',
        'author',
        'imageUrl',
        'timestamp',
    ];

    public $timestamps = false; // Disable automatic timestamps if not needed
}