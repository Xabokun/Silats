<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model; class Course extends Model { protected $fillable=['code','name','credits','description']; public function classes(){return $this->hasMany(PracticumClass::class);} public function requirements(){return $this->hasMany(PracticumRequirement::class);} }
