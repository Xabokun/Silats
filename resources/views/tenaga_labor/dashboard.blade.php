@extends('layouts.app')
@section('title','Dashboard Laboran')
@section('page_heading','Laboran')
@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Pengujian {{ auth()->user()->laboratory?->name }}</h2>
            <p class="text-secondary mb-0">Laboran menerima sampel, mengelola proses pengujian, dan menyelesaikan hasil sesuai SOP laboratorium.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No. Permohonan</th>
                            <th>Pemohon</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $r)
                            <tr>
                                <td class="ps-4">{{ $r->request_number }}</td>
                                <td>{{ $r->applicant->name }}</td>
                                <td>{{ $r->service->name }}</td>
                                <td>
                                    <span class="badge text-bg-{{ $r->status==='completed'?'success':'warning' }}">{{ str_replace('_',' ',$r->status) }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('tenaga-labor.tests.show',$r) }}">Proses</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-4">Belum ada pengujian yang masuk ke laboratorium ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection