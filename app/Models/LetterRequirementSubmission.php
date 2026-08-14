<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model; class LetterRequirementSubmission extends Model { protected $fillable=['letter_request_id','letter_requirement_id','file_path']; public function requirement(){return $this->belongsTo(LetterRequirement::class,'letter_requirement_id');} }
