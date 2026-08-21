@extends('layouts.app')

@section('title', 'Tracking Surat')
@section('page_heading', 'Tracking Surat')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between gap-3 align-items-start mb-4">
        <div>
            <div class="text-secondary small">Nomor Permohonan</div>
            <h2 class="fw-bold mb-1">{{ $letterRequest->request_number }}</h2>
            <p class="mb-0">{{ $letterRequest->letterType->title }} — {{ $letterRequest->subject }}</p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-primary" target="_blank" href="{{ route('surat.document', $letterRequest) }}">
                {{ $letterRequest->status === 'completed' ? 'Lihat Surat Resmi' : 'Preview Draft' }}
            </a>
            @if($letterRequest->status === 'completed')
                <a class="btn btn-primary" target="_blank" href="{{ route('surat.document', $letterRequest) }}#print">Cetak / Simpan PDF</a>
            @endif
        </div>
    </div>

    @if($letterRequest->status === 'completed')
        <div class="alert alert-success d-flex flex-wrap justify-content-between gap-2">
            <span><strong>Surat resmi telah terbit.</strong></span>
            <span>Nomor: <strong>{{ $letterRequest->official_number }}</strong> • {{ optional($letterRequest->letter_date)->format('d-m-Y') }}</span>
        </div>
    @elseif($letterRequest->status === 'rejected')
        <div class="alert alert-danger"><strong>Pengajuan ditolak.</strong> Dokumen yang tersedia tetap berstatus draft dan tidak memiliki nomor surat resmi.</div>
    @else
        <div class="alert alert-warning"><strong>Draft tersedia.</strong> Nomor surat resmi baru diterbitkan setelah seluruh tahapan disetujui.</div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5>Alur Surat</h5>
            <div class="row g-2 mt-1">
                @foreach($letterRequest->letterType->workflowSteps as $step)
                    @php
                        $done = $letterRequest->histories->where('step_order', $step->step_order)->where('action', 'approve')->isNotEmpty();
                        $active = $letterRequest->status === 'in_process' && $letterRequest->current_step_order == $step->step_order;
                    @endphp
                    <div class="col-md">
                        <div class="p-3 rounded h-100 {{ $done ? 'bg-success-subtle border border-success-subtle' : ($active ? 'bg-warning-subtle border border-warning-subtle' : 'bg-light border') }}">
                            <div class="small">Tahap {{ $step->step_order }}</div>
                            <strong>{{ $done ? '✓ ' : ($active ? '● ' : '○ ') }}{{ $step->label }}</strong>
                            <div class="small text-secondary">{{ str_replace('_', ' ', $step->role) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5>Data Surat</h5>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <tr><th style="width:35%">Pemohon</th><td>{{ $letterRequest->applicant->name }}</td></tr>
                            @if($letterRequest->applicant->npm)<tr><th>NPM</th><td>{{ $letterRequest->applicant->npm }}</td></tr>@endif
                            <tr><th>Perihal</th><td>{{ $letterRequest->subject }}</td></tr>
                            <tr><th>Laboratorium</th><td>{{ $letterRequest->laboratory?->name ?? '-' }}</td></tr>
                            @foreach($letterRequest->fieldValues as $value)
                                <tr><th>{{ $value->label }}</th><td>{!! nl2br(e($value->value ?: '-')) !!}</td></tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5>Riwayat Surat</h5>
                    @foreach($letterRequest->histories as $history)
                        <div class="border-start border-3 ps-3 mb-3">
                            <strong>{{ ucfirst($history->action) }}</strong>
                            @if($history->step_order) • tahap {{ $history->step_order }} @endif
                            <br><span>{{ $history->notes }}</span><br>
                            <small class="text-secondary">{{ $history->actor?->name ?? 'Sistem' }} • {{ $history->created_at->format('d M Y H:i') }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <h5>Lampiran Persyaratan</h5>
                    @forelse($letterRequest->files as $file)
                        <a class="d-block mb-2" target="_blank" href="{{ asset('storage/'.$file->file_path) }}">{{ $file->requirement->title }}</a>
                    @empty
                        <span class="text-secondary">Tidak ada lampiran.</span>
                    @endforelse
                </div>
            </div>

            @if($letterRequest->status === 'in_process' && $current && ($current->role === auth()->user()->role || auth()->user()->isRole('admin')))
                <div class="card border-primary shadow-sm">
                    <div class="card-body p-4">
                        <h5>{{ auth()->user()->isRole('admin') ? 'Proses Tahap Surat oleh Admin' : 'Proses Tahap Anda' }}</h5>
                        <p class="small text-secondary">{{ $current->label }}</p>
                        <form method="POST" action="{{ route('surat.action', $letterRequest) }}">
                            @csrf
                            <textarea class="form-control mb-3" name="notes" rows="3" placeholder="Catatan verifikasi"></textarea>
                            <div class="d-flex flex-wrap gap-2">
                                <button name="action" value="approve" class="btn btn-success">Setujui & Lanjutkan</button>
                                <button name="action" value="reject" class="btn btn-outline-danger">Tolak</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
