<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticumClassType extends Model
{
    protected $fillable = ['code', 'name', 'description'];

    public function classes()
    {
        return $this->hasMany(PracticumClass::class, 'class_type_id');
    }
}
