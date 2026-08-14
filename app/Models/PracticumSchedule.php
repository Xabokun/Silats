<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticumSchedule extends Model
{
    protected $fillable = [
        'practicum_id', 'laboratory_id', 'lecturer_id', 'day',
        'start_time', 'end_time', 'room', 'quota', 'academic_year',
        'term', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function practicum()
    {
        return $this->belongsTo(Practicum::class);
    }

    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function registrations()
    {
        return $this->hasMany(PracticumRegistration::class, 'schedule_id');
    }
}
