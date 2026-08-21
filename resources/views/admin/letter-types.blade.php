@extends('layouts.app')

@section('title', 'Manajemen Surat')
@section('page_heading', 'Manajemen Surat')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Surat</h2>
            <p class="text-secondary mb-0">Kelola semua jenis surat, template dokumen, persyaratan berkas, dan alur proses administrasi.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('admin.letter-settings') }}">Pengaturan Kop</a>
            <a class="btn btn-primary" href="{{ route('admin.letter-types.create') }}">+ Jenis Surat</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary small text-uppercase">Total jenis surat</div>
                    <div class="display-6 fw-bold mt-2">{{ $types->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary small text-uppercase">Template aktif</div>
                    <div class="display-6 fw-bold mt-2">{{ $types->filter(fn($type) => $type->body_template)->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary small text-uppercase">Riwayat pengajuan</div>
                    <div class="display-6 fw-bold mt-2">{{ $types->sum('requests_count') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @forelse($types as $type)
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <div>
                                <span class="badge text-bg-secondary">{{ $type->code }}</span>
                                <h5 class="mt-2 mb-1">{{ $type->title }}</h5>
                                <p class="text-secondary mb-0">{{ $type->description ?: 'Belum ada deskripsi jenis surat.' }}</p>
                            </div>
                            <a class="btn btn-sm btn-outline-primary align-self-start" href="{{ route('admin.letter-types.edit', $type) }}">Atur Template</a>
                        </div>

                        <div class="row g-3 small mb-3">
                            <div class="col-md-6">
                                <div class="text-secondary">Perihal default</div>
                                <div class="fw-semibold mt-1">{{ $type->default_subject ?: '-' }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-secondary">Penandatangan</div>
                                <div class="fw-semibold mt-1">{{ $type->signatory_name ?: '-' }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-secondary">Data kebutuhan</div>
                                <div class="fw-semibold mt-1">{{ $type->formFields->count() }} field</div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-secondary">Riwayat pengajuan</div>
                                <div class="fw-semibold mt-1">{{ $type->requests_count }} surat</div>
                            </div>
                        </div>

                        <div class="border-top pt-3">
                            <h6 class="fw-semibold mb-2">Persyaratan Berkas</h6>
                            <ul class="mb-3 ps-3">
                                @forelse($type->requirements as $requirement)
                                    <li>{{ $requirement->title }}</li>
                                @empty
                                    <li class="text-secondary">Tanpa lampiran khusus</li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="border-top pt-3">
                            <h6 class="fw-semibold mb-2">Alur Proses</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($type->workflowSteps as $step)
                                    <span class="badge rounded-pill text-bg-primary-subtle border">{{ $step->step_order }}. {{ $step->label }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border mb-0">Belum ada jenis surat yang dikelola.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
