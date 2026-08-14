<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model; class LetterWorkflowStep extends Model { protected $fillable=['letter_type_id','step_order','role','label']; public function letterType(){return $this->belongsTo(LetterType::class);} }
