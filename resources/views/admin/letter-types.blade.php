@extends('layouts.app')

@section('title', 'Manajemen Surat')
@section('page_heading', 'Manajemen Surat')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Surat</h2>
            <p class="text-secondary mb-0">Admin menentukan jenis surat, data kebutuhan, template dokumen, penandatangan, persyaratan, dan workflow.</p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('admin.letter-settings') }}">Pengaturan Kop</a>
            <a class="btn btn-primary" href="{{ route('admin.letter-types.create') }}">+ Jenis Surat</a>
        </div>
    </div>

    <div class="row g-3">
        @forelse($types as $type)
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between gap-3">
                            <div>
                                <span class="badge text-bg-secondary">{{ $type->code }}</span>
                                <h5 class="mt-2 mb-1">{{ $type->title }}</h5>
                                <p class="text-secondary">{{ $type->description }}</p>
                            </div>
                            <a class="btn btn-sm btn-outline-primary align-self-start" href="{{ route('admin.letter-types.edit', $type) }}">Atur Template</a>
                        </div>

                        <div class="row g-3 small">
                            <div class="col-md-6"><strong>Perihal default</strong><div class="text-secondary">{{ $type->default_subject ?: '-' }}</div></div>
                            <div class="col-md-6"><strong>Penandatangan</strong><div class="text-secondary">{{ $type->signatory_name ?: '-' }}</div></div>
                            <div class="col-md-6"><strong>Data kebutuhan</strong><div class="text-secondary">{{ $type->formFields->count() }} field</div></div>
                            <div class="col-md-6"><strong>Riwayat pengajuan</strong><div class="text-secondary">{{ $type->requests_count }} surat</div></div>
                        </div>

                        <hr>
                        <h6>Persyaratan Berkas</h6>
                        <ul class="mb-3">
                            @forelse($type->requirements as $requirement)
                                <li>{{ $requirement->title }}</li>
                            @empty
                                <li class="text-secondary">Tanpa lampiran khusus</li>
                            @endforelse
                        </ul>

                        <h6>Alur</h6>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($type->workflowSteps as $step)
                                <span class="badge rounded-pill text-bg-primary">{{ $step->step_order }}. {{ $step->label }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-light border">Belum ada jenis surat.</div></div>
        @endforelse
    </div>
</div>
@endsection
