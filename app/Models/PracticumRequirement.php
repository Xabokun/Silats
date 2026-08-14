<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model; class PracticumRequirement extends Model { protected $fillable=['course_id','title','description','is_required']; protected $casts=['is_required'=>'boolean']; public function course(){return $this->belongsTo(Course::class);} }
