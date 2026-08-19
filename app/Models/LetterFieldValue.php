<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterFieldValue extends Model
{
    protected $fillable = [
        'letter_request_id', 'letter_form_field_id', 'field_key', 'label', 'value',
    ];

    public function letterRequest()
    {
        return $this->belongsTo(LetterRequest::class);
    }

    public function field()
    {
        return $this->belongsTo(LetterFormField::class, 'letter_form_field_id');
    }
}
