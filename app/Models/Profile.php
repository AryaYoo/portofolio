<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name', 'short_name', 'title', 'bio', 'quote',
        'photo', 'email', 'phone', 'location', 'social_links',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];
}
