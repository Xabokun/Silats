@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page_heading', 'Dashboard Admin')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Dashboard Admin</h2>
            <p class="text-secondary mb-0">Ringkasan operasional SILATS.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @foreach([
            ['Mahasiswa', $studentCount],
            ['Kelas Aktif', $activeClasses],
            ['Menunggu Verifikasi', $pendingRegistrations],
            ['Pengujian Aktif', $activeTests]
        ] as $card)
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-secondary small">{{ $card[0] }}</div>
                        <div class="display-6 fw-bold">{{ $card[1] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5>Jumlah Pengujian per Kategori</h5>
                    <canvas id="testChart" height="180"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5>Pemilihan Kelas Praktikum</h5>
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
            data: testChartValues
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

new Chart(document.getElementById('classChart'), {
    type: 'bar',
    data: {
        labels: classChartLabels,
        datasets: [{
            label: 'Pendaftar',
            data: classChartValues
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endpush
