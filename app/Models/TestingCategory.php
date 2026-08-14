<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model; class TestingCategory extends Model { protected $fillable=['name','slug','description']; public function services(){return $this->hasMany(TestingService::class);} }
