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

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="p-4 border-bottom"><h5 class="mb-1">Jadwal dan Kelompok Praktikum</h5><p class="text-secondary mb-0">Kelompok pada laboratorium ini, termasuk batas pengisian dan modul PDF.</p></div>
            <div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead class="table-light"><tr><th class="ps-4">Praktikum</th><th>Kelompok</th><th>Jadwal</th><th>Batas Pengisian</th><th>Modul</th><th class="text-end pe-4">Aksi</th></tr></thead><tbody>
                @forelse($classes as $class)<tr><td class="ps-4">{{ $class->course->name }}</td><td>{{ $class->class_name }}<div class="small text-secondary">{{ $class->final_registrations_count }} mahasiswa</div></td><td>{{ $class->practicum_date?->format('d-m-Y') ?: '-' }}<div class="small text-secondary">{{ $class->day }}, {{ substr($class->start_time,0,5) }}-{{ substr($class->end_time,0,5) }} • {{ $class->room }}</div></td><td>{{ $class->enrollment_deadline?->format('d-m-Y H:i') ?: 'Tidak dibatasi' }}</td><td>@if($class->module_path)<a target="_blank" href="{{ asset('storage/'.$class->module_path) }}">PDF</a>@else - @endif</td><td class="text-end pe-4"><a class="btn btn-sm btn-outline-success" href="{{ route('tenaga-labor.practicums.export',$class) }}">Excel</a><form class="mt-2" method="POST" enctype="multipart/form-data" action="{{ route('tenaga-labor.practicums.update',$class) }}">@csrf<input class="form-control form-control-sm mb-1" type="datetime-local" name="enrollment_deadline" value="{{ optional($class->enrollment_deadline)->format('Y-m-d\\TH:i') }}" aria-label="Batas pengisian"><input class="form-control form-control-sm mb-1" type="file" name="module_file" accept="application/pdf" aria-label="Modul PDF"><button class="btn btn-sm btn-primary">Simpan</button></form></td></tr>@empty<tr><td colspan="6" class="text-center text-secondary py-4">Belum ada kelompok praktikum.</td></tr>@endforelse
            </tbody></table></div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="p-4 border-bottom">
                <h5 class="mb-1">Nilai Akhir Praktikum</h5>
                <p class="text-secondary mb-0">Input nilai akhir mahasiswa pada kelas di {{ auth()->user()->laboratory?->name }}. Nilai minimal lulus adalah 61.</p>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th class="ps-4">Mahasiswa</th><th>NPM</th><th>Praktikum</th><th>Nilai</th><th class="text-end pe-4">Aksi</th></tr></thead>
                    <tbody>
                        @forelse($registrations as $registration)
                            <tr>
                                <td class="ps-4">{{ $registration->student->name }}</td>
                                <td>{{ $registration->student->npm ?: '-' }}</td>
                                <td>{{ $registration->finalClass->course->name }}</td>
                                <td>{{ $registration->final_score !== null ? number_format((float) $registration->final_score, 2, ',', '.') : 'Belum diinput' }}</td>
                                <td class="text-end pe-4">
                                    <form method="POST" action="{{ route('tenaga-labor.practicums.score', $registration) }}" class="d-inline-flex gap-2 align-items-center">
                                        @csrf
                                        <input class="form-control form-control-sm" style="width:100px" type="number" name="final_score" min="0" max="100" step="0.01" value="{{ $registration->final_score }}" placeholder="0-100" required aria-label="Nilai akhir">
                                        <button class="btn btn-sm btn-primary" type="submit">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada mahasiswa terverifikasi di laboratorium ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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