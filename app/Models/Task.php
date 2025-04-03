<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'requirements',
        'required_knowledge',
        'resources',
        'difficulty',
        'status',
        'deadline',
        'solution',
        'progress',
        'tags',
        'user_id',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'tags' => 'array',
        'progress' => 'float',
    ];
}