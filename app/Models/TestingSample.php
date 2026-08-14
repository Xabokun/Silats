<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model; class TestingSample extends Model { protected $fillable=['testing_request_id','code','name','quantity','unit','condition','received_by','received_at','notes']; protected $casts=['received_at'=>'datetime']; public function request(){return $this->belongsTo(TestingRequest::class,'testing_request_id');} }
