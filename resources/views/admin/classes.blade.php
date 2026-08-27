@extends('layouts.app')

@section('title','Jadwal & Kelas')
@section('page_heading','Jadwal & Kelas')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Jadwal & Kelas Praktikum</h2>
            <p class="text-secondary mb-0">Admin mengelola jadwal, ruang, kapasitas, dan penugasan dosen sesuai standar operasional praktikum.</p>
        </div>
        <a class="btn btn-primary align-self-start" href="{{ route('admin.classes.create') }}">+ Tambah Jadwal</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Mata Kuliah</th>
                        <th>Kelompok</th>
                        <th>Dosen</th>
                        <th>Lab / Ruangan</th>
                        <th>Jadwal Praktikum</th>
                        <th>Kapasitas</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $c)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $c->course->name }}</td>
                            <td>{{ $c->class_name }}</td>
                            <td>{{ $c->lecturer?->name ?? '-' }}</td>
                            <td>
                                {{ $c->laboratory->name }}
                                <div class="small text-secondary">{{ $c->room }}</div>
                            </td>
                            <td>{{ $c->practicum_date?->format('d-m-Y') ?: '-' }}<div class="small text-secondary">{{ $c->day }}, {{ substr($c->start_time,0,5) }}–{{ substr($c->end_time,0,5) }}</div></td>
                            <td>
                                <span class="fw-semibold">{{ $c->final_registrations_count }}/{{ $c->capacity }}</span>
                                <div class="small text-secondary">{{ $c->registrations_count }} pemilih</div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.classes.edit',$c) }}">Edit</a>
                                    <form action="{{ route('admin.classes.destroy', $c) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection