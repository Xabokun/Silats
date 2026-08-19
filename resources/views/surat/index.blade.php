@extends('layouts.app')

@section('title', 'Pengurusan Surat')
@section('page_heading', 'Pengurusan Surat')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Pengurusan Surat</h2>
            <p class="text-secondary mb-0">Pantau posisi workflow, preview draft, dan buka surat resmi setelah selesai.</p>
        </div>
        <a class="btn btn-primary" href="{{ route('surat.create') }}">+ Ajukan Surat</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Jenis</th>
                        <th>Pemohon</th>
                        <th>Laboratorium</th>
                        <th>Status</th>
                        <th>Posisi</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($requests as $letter)
                    @php
                        $step = $letter->letterType->workflowSteps->firstWhere('step_order', $letter->current_step_order);
                    @endphp
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $letter->official_number ?: $letter->request_number }}</div>
                            @if($letter->official_number)<div class="small text-secondary">Ref: {{ $letter->request_number }}</div>@endif
                        </td>
                        <td>{{ $letter->letterType->title }}</td>
                        <td>{{ $letter->applicant->name }}</td>
                        <td>{{ $letter->laboratory?->name ?? '-' }}</td>
                        <td>
                            <span class="badge text-bg-{{ $letter->status === 'completed' ? 'success' : ($letter->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ $letter->status === 'completed' ? 'Selesai' : ($letter->status === 'rejected' ? 'Ditolak' : 'Diproses') }}
                            </span>
                        </td>
                        <td>{{ $letter->status === 'completed' ? 'Surat resmi terbit' : ($letter->status === 'rejected' ? 'Pengajuan ditolak' : ($step?->label ?? '-')) }}</td>
                        <td class="text-end text-nowrap">
                            <a class="btn btn-sm btn-outline-secondary" target="_blank" href="{{ route('surat.document', $letter) }}">{{ $letter->status === 'completed' ? 'Surat' : 'Draft' }}</a>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('surat.show', $letter) }}">Tracking</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-5 text-secondary">Belum ada pengurusan surat.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
