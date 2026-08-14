<?php
namespace App\Http\Controllers; use App\Models\Laboratory; use App\Models\TestingCategory; class HomeController extends Controller { public function index(){ $laboratories=Laboratory::all(); $categories=TestingCategory::with(['services'=>fn($q)=>$q->where('is_active',true)->with('laboratory')])->get(); return view('public.home',compact('laboratories','categories')); } }
