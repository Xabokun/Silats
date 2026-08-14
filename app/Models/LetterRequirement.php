<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model; class LetterRequirement extends Model { protected $fillable=['letter_type_id','title','description','is_required']; protected $casts=['is_required'=>'boolean']; public function letterType(){return $this->belongsTo(LetterType::class);} }
