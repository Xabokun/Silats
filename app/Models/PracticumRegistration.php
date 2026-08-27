<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticumRegistration extends Model
{
	protected $fillable = [
		'student_id', 'practicum_class_id', 'final_class_id', 'status', 'final_score',
		'score_entered_by', 'score_entered_at', 'admin_note', 'verified_by', 'verified_at',
	];

	protected $casts = [
		'final_score' => 'decimal:2',
		'score_entered_at' => 'datetime',
		'verified_at' => 'datetime',
	];

	public function student() { return $this->belongsTo(User::class, 'student_id'); }
	public function preferredClass() { return $this->belongsTo(PracticumClass::class, 'practicum_class_id'); }
	public function finalClass() { return $this->belongsTo(PracticumClass::class, 'final_class_id'); }
	public function submissions() { return $this->hasMany(RequirementSubmission::class, 'registration_id'); }
	public function verifier() { return $this->belongsTo(User::class, 'verified_by'); }
	public function scoreEnteredBy() { return $this->belongsTo(User::class, 'score_entered_by'); }

	public function passed(): bool
	{
		return $this->final_score !== null && (float) $this->final_score >= 61;
	}
}
