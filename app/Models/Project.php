<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'theme_color', 'description', 'screenshot', 'icon', 'icon_color',
        'demo_url', 'repo_url', 'category', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeBest($query)
    {
        return $query->where('category', 'best')->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeOther($query)
    {
        return $query->where('category', 'other')->where('is_active', true)->orderBy('sort_order');
    }
    public function sections()
    {
        return $this->hasMany(ProjectSection::class)->orderBy('sort_order');
    }
}
