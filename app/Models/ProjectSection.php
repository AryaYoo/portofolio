<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'type', 'title', 'content', 'image', 'sort_order', 'is_active'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
