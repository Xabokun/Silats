@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page_heading', 'Dashboard Admin')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Dashboard Admin</h2>
            <p class="text-secondary mb-0">Ringkasan operasional SILATS berdasarkan SOP administrasi, pengujian, dan pendataan kelas.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.class-types') }}" class="btn btn-primary">+ Tambah Tipe Kelas</a>
            <a href="{{ route('admin.classes.create') }}" class="btn btn-outline-primary">+ Tambah Kelas</a>
            <a href="{{ route('admin.classes') }}" class="btn btn-outline-primary">Lihat Jadwal & Kelas</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @foreach([
            ['Mahasiswa', $studentCount, 'bg-primary-subtle text-primary'],
            ['Kelas Aktif', $activeClasses, 'bg-success-subtle text-success'],
            ['Verifikasi Tertunda', $pendingRegistrations, 'bg-warning-subtle text-warning'],
            ['Pengujian Aktif', $activeTests, 'bg-info-subtle text-info']
        ] as $card)
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="small text-secondary mb-2 text-uppercase fw-semibold">{{ $card[0] }}</div>
                        <div class="display-6 fw-bold {{ $card[2] }}">{{ $card[1] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Jumlah Pengujian per Kategori</h5>
                        <span class="badge text-bg-light border">Monitoring</span>
                    </div>
                    <canvas id="testChart" height="180"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Pemilihan Kelas Praktikum</h5>
                        <span class="badge text-bg-light border">Kelas</span>
                    </div>
                    <canvas id="classChart" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@php
    $testChartLabels = $testByCategory->pluck('name')->values();
    $testChartValues = $testByCategory->pluck('total')->values();
    $classChartLabels = $classChoices->map(function ($item) {
        return ($item->course?->name ?? 'Mata Kuliah') . ' ' . $item->class_name;
    })->values();
    $classChartValues = $classChoices->pluck('registrations_count')->values();
@endphp

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
<script>
const testChartLabels = @json($testChartLabels);
const testChartValues = @json($testChartValues);
const classChartLabels = @json($classChartLabels);
const classChartValues = @json($classChartValues);

new Chart(document.getElementById('testChart'), {
    type: 'bar',
    data: {
        labels: testChartLabels,
        datasets: [{
            label: 'Jumlah Pengujian',
            data: testChartValues,
            backgroundColor: '#1d4ed8'
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});

new Chart(document.getElementById('classChart'), {
    type: 'bar',
    data: {
        labels: classChartLabels,
        datasets: [{
            label: 'Pendaftar',
            data: classChartValues,
            backgroundColor: '#14b8a6'
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endpush
