<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name', 'icon', 'image', 'category', 'level', 'description', 'tags', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tags' => 'array',
    ];
}
