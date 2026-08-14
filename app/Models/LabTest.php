<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    protected $fillable = [
        'laboratory_id', 'created_by', 'title', 'test_date',
        'description', 'result', 'status',
    ];

    protected function casts(): array
    {
        return ['test_date' => 'date'];
    }

    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
