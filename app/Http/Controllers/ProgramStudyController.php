<?php

namespace App\Http\Controllers;

use App\Models\Laboratory;
use App\Models\PracticumClass;

class ProgramStudyController extends Controller
{
    public function dashboard()
    {
        $labs = Laboratory::withCount(['classes', 'users'])
            ->with([
                'testingServices' => fn ($q) => $q->withCount([
                    'requests as active_requests_count' => fn ($x) => $x->whereIn('status', ['pending_sample', 'sample_received', 'testing']),
                    'requests as completed_requests_count' => fn ($x) => $x->where('status', 'completed'),
                ]),
            ])->get();

        $totalClasses = PracticumClass::count();
        $activeClasses = PracticumClass::where('is_active', true)->count();

        return view('prodi.dashboard', compact('labs', 'totalClasses', 'activeClasses'));
    }

    public function classes()
    {
        $classes = PracticumClass::with(['course', 'laboratory', 'lecturer'])
            ->withCount([
                'registrations as preference_count',
                'finalRegistrations as approved_students_count' => fn ($q) => $q->where('status', 'approved'),
            ])
            ->orderBy('academic_year', 'desc')
            ->orderBy('semester')
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        return view('prodi.classes', compact('classes'));
    }
}
