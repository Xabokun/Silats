<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model; class LetterRequestHistory extends Model { protected $fillable=['letter_request_id','step_order','action','actor_id','actor_role','notes']; public function actor(){return $this->belongsTo(User::class,'actor_id');} }
