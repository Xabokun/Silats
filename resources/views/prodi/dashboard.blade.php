@extends('layouts.app')
@section('title','Monitoring Prodi')
@section('page_heading','Monitoring Program Studi')
@section('content')
<div>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Monitoring Seluruh Laboratorium</h2>
            <p class="text-secondary mb-0">Prodi dapat memantau aktivitas lintas laboratorium dan seluruh kelas praktikum.</p>
        </div>
        <a href="{{ route('prodi.classes') }}" class="btn btn-primary">Lihat Semua Kelas Praktikum</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body"><small class="text-secondary">Total Kelas Praktikum</small><div class="display-6 fw-bold mt-1">{{ $totalClasses }}</div></div></div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body"><small class="text-secondary">Kelas Aktif</small><div class="display-6 fw-bold mt-1">{{ $activeClasses }}</div></div></div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body"><small class="text-secondary">Laboratorium</small><div class="display-6 fw-bold mt-1">{{ $labs->count() }}</div></div></div>
        </div>
    </div>

    <div class="row g-4">
        @foreach($labs as $lab)
            @php
                $active=$lab->testingServices->sum('active_requests_count');
                $done=$lab->testingServices->sum('completed_requests_count');
            @endphp
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="badge text-bg-primary">{{ $lab->code }}</span>
                        <h4 class="mt-2">{{ $lab->name }}</h4>
                        <div class="row g-2 mt-2">
                            <div class="col-6"><div class="p-3 bg-light rounded"><small>Kelas</small><div class="h3 mb-0">{{ $lab->classes_count }}</div></div></div>
                            <div class="col-6"><div class="p-3 bg-light rounded"><small>Pengujian Aktif</small><div class="h3 mb-0">{{ $active }}</div></div></div>
                            <div class="col-6"><div class="p-3 bg-light rounded"><small>Pengujian Selesai</small><div class="h3 mb-0">{{ $done }}</div></div></div>
                            <div class="col-6"><div class="p-3 bg-light rounded"><small>Personel</small><div class="h3 mb-0">{{ $lab->users_count }}</div></div></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
