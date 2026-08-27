@extends('layouts.app')

@section('title', $class->exists ? 'Edit Kelas' : 'Tambah Kelas')
@section('content')
@php
    $classTypes = App\Models\PracticumClassType::orderBy('name')->get();
@endphp

<div class="container py-4">
    <div class="row justify-content-center g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4">{{ $class->exists ? 'Edit' : 'Tambah' }} Jadwal/Kelas</h3>

                    <form method="POST" enctype="multipart/form-data" action="{{ $class->exists ? route('admin.classes.update', $class) : route('admin.classes.store') }}">
                        @csrf
                        @if($class->exists)
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Mata Kuliah</label>
                                <select class="form-select" name="course_id" required>
                                    @foreach($courses as $x)
                                        <option value="{{ $x->id }}" @selected(old('course_id', $class->course_id) == $x->id)>{{ $x->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Dosen</label>
                                <select class="form-select" name="lecturer_id">
                                    <option value="">- Belum ditentukan -</option>
                                    @foreach($lecturers as $x)
                                        <option value="{{ $x->id }}" @selected(old('lecturer_id', $class->lecturer_id) == $x->id)>{{ $x->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Laboratorium</label>
                                <select class="form-select" name="laboratory_id" required>
                                    @foreach($laboratories as $x)
                                        <option value="{{ $x->id }}" @selected(old('laboratory_id', $class->laboratory_id) == $x->id)>{{ $x->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Tipe Kelas</label>
                                <select class="form-select" name="class_type_id">
                                    <option value="">- Pilih tipe kelas -</option>
                                    @foreach($classTypes as $type)
                                        <option value="{{ $type->id }}" @selected(old('class_type_id', $class->class_type_id) == $type->id)>{{ $type->name }} ({{ $type->code }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Kelompok</label>
                                <input class="form-control" name="class_name" value="{{ old('class_name', $class->class_name) }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Kapasitas</label>
                                <input type="number" class="form-control" name="capacity" value="{{ old('capacity', $class->capacity ?: 40) }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Hari</label>
                                <select class="form-select" name="day" required>
                                    @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                                        <option value="{{ $hari }}" @selected(old('day', $class->day) == $hari)>{{ $hari }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Modul / Ruangan</label>
                                <input class="form-control" name="room" value="{{ old('room', $class->room) }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Semester</label>
                                <input class="form-control" name="semester" value="{{ old('semester', $class->semester ?: 'Ganjil') }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Tahun Akademik</label>
                                <input class="form-control" name="academic_year" value="{{ old('academic_year', $class->academic_year ?: date('Y').'/'.(date('Y') + 1)) }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Waktu Mulai</label>
                                <input type="time" class="form-control" name="start_time" value="{{ old('start_time', $class->start_time) }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Waktu Selesai</label>
                                <input type="time" class="form-control" name="end_time" value="{{ old('end_time', $class->end_time) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Tanggal Praktikum</label>
                                <input type="date" class="form-control" name="practicum_date" value="{{ old('practicum_date', optional($class->practicum_date)->format('Y-m-d')) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Batas Pengisian</label>
                                <input type="datetime-local" class="form-control" name="enrollment_deadline" value="{{ old('enrollment_deadline', optional($class->enrollment_deadline)->format('Y-m-d\\TH:i')) }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Modul PDF</label>
                                <input type="file" class="form-control" name="module_file" accept="application/pdf">
                                @if($class->module_path)<a class="small" target="_blank" href="{{ asset('storage/'.$class->module_path) }}">Lihat modul saat ini</a>@endif
                            </div>

                            <div class="col-12 d-flex justify-content-between align-items-center mt-3">
                                <a class="btn btn-outline-secondary" href="{{ route('admin.classes') }}">Kembali</a>
                                <button class="btn btn-primary">{{ $class->exists ? 'Simpan Perubahan' : 'Simpan Kelas' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Kelola Mata Kuliah</h5>
                    <form method="POST" action="{{ route('admin.courses.store') }}" class="mb-3">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label small">Kode</label>
                            <input class="form-control" name="code" placeholder="contoh: TSP-101" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Nama Mata Kuliah</label>
                            <input class="form-control" name="name" placeholder="contoh: Struktur Beton" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">SKS</label>
                            <input type="number" class="form-control" name="credits" placeholder="3">
                        </div>
                        <button class="btn btn-sm btn-primary w-100">+ Tambah Mata Kuliah</button>
                    </form>

                    <div class="list-group list-group-flush">
                        @foreach($courses as $course)
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center gap-2">
                                <span>{{ $course->code }} - {{ $course->name }}</span>
                                <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('Hapus mata kuliah ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Kelola Laboratorium</h5>
                    <form method="POST" action="{{ route('admin.laboratories.store') }}" class="mb-3">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label small">Nama Laboratorium</label>
                            <input class="form-control" name="name" placeholder="contoh: Laboratorium Beton" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Kode</label>
                            <input class="form-control" name="code" placeholder="contoh: LAB-BT">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="2" placeholder="Opsional"></textarea>
                        </div>
                        <button class="btn btn-sm btn-primary w-100">+ Tambah Laboratorium</button>
                    </form>

                    <div class="list-group list-group-flush">
                        @foreach($laboratories as $lab)
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center gap-2">
                                <span>{{ $lab->name }}</span>
                                <form method="POST" action="{{ route('admin.laboratories.destroy', $lab) }}" onsubmit="return confirm('Hapus laboratorium ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Kelola Tipe Kelas</h5>
                    <form method="POST" action="{{ route('admin.class-types.store') }}" class="mb-3">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label small">Kode</label>
                            <input class="form-control" name="code" placeholder="contoh: A" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Nama Tipe Kelas</label>
                            <input class="form-control" name="name" placeholder="contoh: Kelas Reguler" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="2" placeholder="Opsional"></textarea>
                        </div>
                        <button class="btn btn-sm btn-primary w-100">+ Tambah Tipe Kelas</button>
                    </form>

                    <div class="list-group list-group-flush">
                        @foreach($classTypes as $type)
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center gap-2">
                                <span>{{ $type->name }} ({{ $type->code }})</span>
                                <form method="POST" action="{{ route('admin.class-types.destroy', $type) }}" onsubmit="return confirm('Hapus tipe kelas ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
