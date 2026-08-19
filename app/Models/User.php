<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable { use HasFactory, Notifiable; protected $fillable=['npm','name','email','nidn','phone','address','expertise','position_title','position_start_date','position_end_date','password','role','laboratory_id']; protected $hidden=['password','remember_token']; protected function casts(): array { return ['email_verified_at'=>'datetime','password'=>'hashed','position_start_date'=>'date','position_end_date'=>'date']; } public function laboratory(){return $this->belongsTo(Laboratory::class);} public function registrations(){return $this->hasMany(PracticumRegistration::class,'student_id');} public function teachingClasses(){return $this->hasMany(PracticumClass::class,'lecturer_id');} public function testingRequests(){return $this->hasMany(TestingRequest::class,'applicant_id');} public function letterRequests(){return $this->hasMany(LetterRequest::class,'applicant_id');} public function isRole(string ...$roles): bool{return in_array($this->role,$roles,true);} }
