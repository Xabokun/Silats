@extends('layouts.app')
@section('title','Pengujian Saya')
@section('page_heading','Pengujian Saya')
@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Pengujian Saya</h2>
            <p class="text-secondary mb-0">Pantau status sampel dari pengajuan hingga hasil pengujian tersedia.</p>
        </div>
        <a class="btn btn-primary align-self-start" href="{{ route('umum.tests.create') }}">+ Ajukan Pengujian</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-secondary text-uppercase fw-semibold">Total Permohonan</div>
                    <div class="display-6 fw-bold mt-2">{{ $requests->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-secondary text-uppercase fw-semibold">Dalam Proses</div>
                    <div class="display-6 fw-bold mt-2">{{ $requests->where('status', '!=', 'completed')->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-secondary text-uppercase fw-semibold">Selesai</div>
                    <div class="display-6 fw-bold mt-2">{{ $requests->where('status', 'completed')->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @forelse($requests as $r)
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between gap-3 align-items-start mb-3">
                            <div>
                                <div class="small text-secondary">{{ $r->request_number }}</div>
                                <h5 class="mb-1 mt-1">{{ $r->service->name }}</h5>
                            </div>
                            <span class="badge text-bg-{{ $r->status==='completed'?'success':'warning' }}">{{ str_replace('_',' ',$r->status) }}</span>
                        </div>
                        <div class="mb-3 text-secondary">{{ $r->service->laboratory->name }}</div>
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('umum.tests.show',$r) }}">Lacak</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border">Belum ada pengujian yang diajukan.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection