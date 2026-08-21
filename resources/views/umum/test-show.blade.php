@extends('layouts.app')
@section('title','Tracking Pengujian')
@section('page_heading','Tracking Pengujian')
@section('content')
@php
    $steps = [
        'pending_sample' => 'Permohonan / Menunggu Sampel',
        'sample_received' => 'Sampel Diterima',
        'testing' => 'Dalam Pengujian',
        'completed' => 'Selesai',
    ];
    $order = array_keys($steps);
    $idx = array_search($testingRequest->status, $order);
@endphp
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between gap-3 align-items-start mb-4">
        <div>
            <div class="text-secondary small">Nomor Permohonan</div>
            <h2 class="fw-bold mb-1">{{ $testingRequest->request_number }}</h2>
            <p class="mb-0">{{ $testingRequest->service->name }} • {{ $testingRequest->service->laboratory->name }}</p>
        </div>
        @if($testingRequest->result && $testingRequest->result->result_file)
            <a class="btn btn-success" target="_blank" href="{{ asset('storage/'.$testingRequest->result->result_file) }}">Lihat PDF Hasil</a>
        @endif
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-3">
                @foreach($steps as $key => $label)
                    @php
                        $currentIndex = array_search($key, $order);
                        $done = $currentIndex <= ($idx ?? -1);
                    @endphp
                    <div class="col-6 col-lg-3">
                        <div class="p-3 rounded h-100 {{ $done ? 'bg-success-subtle border border-success-subtle' : 'bg-light border' }}">
                            <div class="fw-bold">{{ $done ? '✓' : '○' }} {{ $label }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5>Riwayat Proses</h5>
                    @foreach($testingRequest->histories as $h)
                        <div class="border-start border-3 ps-3 mb-3">
                            <strong>{{ str_replace('_',' ',$h->status) }}</strong><br>
                            <span>{{ $h->description }}</span><br>
                            <small class="text-secondary">{{ $h->created_at->format('d M Y H:i') }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            @if($testingRequest->status === 'pending_sample')
                <div class="alert alert-warning">
                    <strong>Langkah berikutnya:</strong><br>
                    Bawa sampel ke {{ $testingRequest->service->laboratory->name }}. Laboran akan menginput sampel saat diterima.
                </div>
            @endif

            @if($testingRequest->result)
                <div class="card border-success shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="text-success">Surat Hasil Tersedia</h5>
                        <div class="mb-2">Nomor: <strong>{{ $testingRequest->result->letter_number }}</strong></div>
                        <p class="mt-2 mb-0">{{ $testingRequest->result->result_summary }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection