@extends('layouts.app')
@section('title', 'Uji Coba Laboratorium')
@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card card-soft">
                <div class="card-body p-4">
                    <h1 class="h4 section-title">Tambah Uji Coba</h1>
                    <p class="text-secondary small">Catat kegiatan pengujian/percontohan yang menjadi tanggung jawab Kepala Labor.</p>
                    <form method="POST" action="{{ route('kepala-labor.tests.store') }}">
                        @csrf
                        <div class="mb-3"><label class="form-label">Judul Uji Coba</label><input class="form-control" name="title" value="{{ old('title') }}" required></div>
                        <div class="mb-3"><label class="form-label">Tanggal</label><input type="date" class="form-control" name="test_date" value="{{ old('test_date', date('Y-m-d')) }}" required></div>
                        <div class="mb-3"><label class="form-label">Status</label><select class="form-select" name="status" required><option value="direncanakan">Direncanakan</option><option value="berjalan">Berjalan</option><option value="selesai">Selesai</option></select></div>
                        <div class="mb-3"><label class="form-label">Deskripsi</label><textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea></div>
                        <div class="mb-3"><label class="form-label">Hasil</label><textarea class="form-control" name="result" rows="3">{{ old('result') }}</textarea></div>
                        <button class="btn btn-primary w-100">Simpan Uji Coba</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card card-soft">
                <div class="card-body p-4">
                    <h2 class="h4 section-title">Riwayat Uji Coba</h2>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover"><thead class="table-light"><tr><th>Tanggal</th><th>Judul</th><th>Status</th><th>Hasil</th></tr></thead><tbody>
                        @forelse($tests as $test)
                            <tr><td>{{ $test->test_date->format('d/m/Y') }}</td><td class="fw-semibold">{{ $test->title }}</td><td><span class="badge text-bg-secondary">{{ ucfirst($test->status) }}</span></td><td>{{ $test->result ?: '-' }}</td></tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-secondary py-4">Belum ada data.</td></tr>
                        @endforelse
                        </tbody></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
