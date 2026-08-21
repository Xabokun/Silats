@extends('layouts.app')
@section('title','Daftar Kelas Praktikum')
@section('page_heading','Daftar Kelas Praktikum')
@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Daftar Kelas Praktikum</h2>
            <p class="text-secondary mb-0">Monitoring seluruh kelas praktik dari unit laboratorium sesuai kebutuhan program studi.</p>
        </div>
        <a href="{{ route('prodi.dashboard') }}" class="btn btn-outline-secondary">Kembali ke Monitoring</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Mata Kuliah</th>
                            <th>Kelas</th>
                            <th>Laboratorium</th>
                            <th>Dosen</th>
                            <th>Ruangan</th>
                            <th>Jadwal</th>
                            <th>Mahasiswa Final</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($classes as $class)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-semibold">{{ $class->course->name ?? '-' }}</div>
                                <small class="text-secondary">{{ $class->course->code ?? '-' }} • {{ $class->semester }} {{ $class->academic_year }}</small>
                            </td>
                            <td><span class="badge text-bg-light border">{{ $class->class_name }}</span></td>
                            <td>{{ $class->laboratory->name ?? '-' }}</td>
                            <td>{{ $class->lecturer->name ?? 'Belum ditentukan' }}</td>
                            <td>{{ $class->room }}</td>
                            <td>
                                <div>{{ $class->day }}</div>
                                <small class="text-secondary">{{ substr($class->start_time,0,5) }} - {{ substr($class->end_time,0,5) }}</small>
                            </td>
                            <td>
                                <strong>{{ $class->approved_students_count }}</strong>
                                <small class="d-block text-secondary">Pilihan awal: {{ $class->preference_count }}</small>
                            </td>
                            <td>{{ $class->capacity }}</td>
                            <td>
                                @if($class->is_active)
                                    <span class="badge text-bg-success">Aktif</span>
                                @else
                                    <span class="badge text-bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center py-5 text-secondary">Belum ada kelas praktikum.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
