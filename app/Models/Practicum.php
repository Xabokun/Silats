<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Practicum extends Model
{
    protected $fillable = ['code', 'name', 'sks', 'semester', 'description'];

    public function schedules()
    {
        return $this->hasMany(PracticumSchedule::class);
    }
}
