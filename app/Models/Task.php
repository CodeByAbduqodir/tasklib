<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
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
        'tags',
        'user_id',
    ];

    protected $casts = [
        'tags' => 'array',
        'deadline' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userProgress()
    {
        return $this->hasMany(TaskUser::class);
    }

    public function currentUserProgress()
    {
        return $this->hasOne(TaskUser::class)->where('user_id', auth()->id());
    }
}