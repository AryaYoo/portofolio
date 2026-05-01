<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name', 'short_name', 'title', 'bio', 'quote',
        'photo', 'wallpaper_1', 'wallpaper_2', 'wallpaper_3', 'wallpaper_4',
        'favicon', 'email', 'phone', 'location', 'social_links',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];
}
