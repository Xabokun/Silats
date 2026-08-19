<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterRequest extends Model
{
    protected $fillable = [
        'request_number', 'official_number', 'letter_date', 'letter_type_id',
        'applicant_id', 'laboratory_id', 'subject', 'notes', 'generated_body',
        'status', 'current_step_order', 'completed_at', 'published_at',
    ];

    protected $casts = [
        'letter_date' => 'date',
        'completed_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function letterType()
    {
        return $this->belongsTo(LetterType::class);
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class);
    }

    public function histories()
    {
        return $this->hasMany(LetterRequestHistory::class)->orderBy('created_at');
    }

    public function files()
    {
        return $this->hasMany(LetterRequirementSubmission::class);
    }

    public function fieldValues()
    {
        return $this->hasMany(LetterFieldValue::class);
    }
}
