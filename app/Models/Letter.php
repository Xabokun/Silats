<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $fillable = [
        'sender_id', 'letter_number', 'type', 'subject', 'recipient',
        'letter_date', 'body', 'attachment_path', 'status',
    ];

    protected function casts(): array
    {
        return ['letter_date' => 'date'];
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
