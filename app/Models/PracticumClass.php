<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticumClass extends Model
{
	protected $fillable = [
		'course_id', 'laboratory_id', 'lecturer_id', 'class_type_id', 'class_name', 'room',
		'day', 'start_time', 'end_time', 'practicum_date', 'enrollment_starts_at', 'enrollment_deadline', 'module_path',
		'capacity', 'semester', 'academic_year', 'is_verified', 'is_active',
	];

	protected $casts = [
		'practicum_date' => 'date',
		'enrollment_starts_at' => 'datetime',
		'enrollment_deadline' => 'datetime',
		'is_active' => 'boolean',
	];

	public function course() { return $this->belongsTo(Course::class); }
	public function laboratory() { return $this->belongsTo(Laboratory::class); }
	public function lecturer() { return $this->belongsTo(User::class, 'lecturer_id'); }
	public function classType() { return $this->belongsTo(PracticumClassType::class, 'class_type_id'); }
	public function registrations() { return $this->hasMany(PracticumRegistration::class); }
	public function finalRegistrations() { return $this->hasMany(PracticumRegistration::class, 'final_class_id'); }
	public function getFilledSeatsAttribute(): int { return $this->finalRegistrations()->where('status', 'approved')->count(); }
	public function registrationIsOpen(): bool
	{
		return (! $this->enrollment_starts_at || now()->gte($this->enrollment_starts_at))
			&& (! $this->enrollment_deadline || now()->lte($this->enrollment_deadline));
	}
}
