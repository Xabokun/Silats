<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TestingWorkflowStep extends Model {
 protected $fillable=["testing_service_id","step_order","role","status"];
 public function service(){return $this->belongsTo(TestingService::class,"testing_service_id");}
}
