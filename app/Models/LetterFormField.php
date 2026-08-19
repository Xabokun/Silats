<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterFormField extends Model
{
    protected $fillable = [
        'letter_type_id', 'sort_order', 'field_key', 'label', 'input_type',
        'placeholder', 'is_required',
    ];

    protected $casts = ['is_required' => 'boolean'];

    public function letterType()
    {
        return $this->belongsTo(LetterType::class);
    }
}
