@extends('layouts.app')
@section('title','Monitoring Ka/Sekretaris Program Studi')
@section('page_heading','Ka/Sekretaris Program Studi')
@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Monitoring Seluruh Laboratorium</h2>
            <p class="text-secondary mb-0">Program Studi memantau seluruh unit laboratorium dan kegiatan praktikum sesuai SOP.</p>
        </div>
        <a href="{{ route('prodi.classes') }}" class="btn btn-primary">Lihat Semua Kelas Praktikum</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-secondary text-uppercase fw-semibold">Total Kelas Praktikum</div>
                    <div class="display-6 fw-bold mt-2">{{ $totalClasses }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-secondary text-uppercase fw-semibold">Kelas Aktif</div>
                    <div class="display-6 fw-bold mt-2">{{ $activeClasses }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-secondary text-uppercase fw-semibold">Laboratorium</div>
                    <div class="display-6 fw-bold mt-2">{{ $labs->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-secondary text-uppercase fw-semibold">Status Unit</div>
                    <div class="display-6 fw-bold mt-2">Terpantau</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @foreach($labs as $lab)
            @php
                $active = $lab->testingServices->sum('active_requests_count');
                $done = $lab->testingServices->sum('completed_requests_count');
            @endphp
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge text-bg-primary">{{ $lab->code }}</span>
                            <span class="badge text-bg-light border">Unit</span>
                        </div>
                        <h4 class="mt-1 mb-3">{{ $lab->name }}</h4>
                        <div class="row g-2">
                            <div class="col-6"><div class="p-3 bg-light rounded"><small class="text-secondary">Kelas</small><div class="h3 mb-0">{{ $lab->classes_count }}</div></div></div>
                            <div class="col-6"><div class="p-3 bg-light rounded"><small class="text-secondary">Pengujian Aktif</small><div class="h3 mb-0">{{ $active }}</div></div></div>
                            <div class="col-6"><div class="p-3 bg-light rounded"><small class="text-secondary">Selesai</small><div class="h3 mb-0">{{ $done }}</div></div></div>
                            <div class="col-6"><div class="p-3 bg-light rounded"><small class="text-secondary">Personel</small><div class="h3 mb-0">{{ $lab->users_count }}</div></div></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
