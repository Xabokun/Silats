<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterheadSetting extends Model
{
    protected $fillable = [
        'institution_name', 'faculty_name', 'unit_name', 'address', 'phone',
        'email', 'website', 'city', 'logo_path', 'header_image_path',
    ];
}
