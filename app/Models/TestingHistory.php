<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model; class TestingHistory extends Model { protected $fillable=['testing_request_id','status','description','updated_by']; public function updater(){return $this->belongsTo(User::class,'updated_by');} }
