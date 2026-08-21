@extends('layouts.app')
@section('title','Monitoring Kepala Labor')
@section('page_heading','Kepala Labor')
@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">{{ auth()->user()->laboratory?->name }}</h2>
            <p class="text-secondary mb-0">Monitoring aktivitas laboratorium sesuai SOP pengelolaan unit.</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-secondary text-uppercase small fw-semibold">Kelas</div><div class="display-6 fw-bold mt-2">{{ $classes->count() }}</div></div></div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-secondary text-uppercase small fw-semibold">Pengujian Aktif</div><div class="display-6 fw-bold mt-2">{{ $tests->where('status','!=','completed')->count() }}</div></div></div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-secondary text-uppercase small fw-semibold">Surat</div><div class="display-6 fw-bold mt-2">{{ $letters->count() }}</div></div></div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-secondary text-uppercase small fw-semibold">Laboran</div><div class="display-6 fw-bold mt-2">{{ $staffCount }}</div></div></div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="mb-3">Kelas Praktikum</h5>
                    @forelse($classes as $c)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <div>
                                <div class="fw-semibold">{{ $c->course->name }} {{ $c->class_name }}</div>
                                <small class="text-secondary">{{ $c->day }} • {{ substr($c->start_time,0,5) }} - {{ substr($c->end_time,0,5) }}</small>
                            </div>
                            <span class="badge text-bg-light border">{{ $c->final_registrations_count }} mahasiswa</span>
                        </div>
                    @empty
                        <div class="text-secondary">Belum ada kelas praktik di laboratorium ini.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="mb-3">Pengujian Terbaru</h5>
                    @forelse($tests as $t)
                        <div class="d-flex justify-content-between align-items-start border-bottom py-2">
                            <div>
                                <div class="fw-semibold">{{ $t->service->name }}</div>
                                <small class="text-secondary">{{ $t->applicant->name }}</small>
                            </div>
                            <span class="badge text-bg-light border">{{ str_replace('_',' ',$t->status) }}</span>
                        </div>
                    @empty
                        <div class="text-secondary">Belum ada pengujian yang tercatat.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection