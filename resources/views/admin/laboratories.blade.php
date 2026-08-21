@extends('layouts.app')
@section('title','Pengaturan Laboratorium')
@section('page_heading','Pengaturan Laboratorium')
@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Pengaturan Laboratorium</h2>
            <p class="text-secondary mb-0">Kelola nama, kode, dan deskripsi laboratorium sesuai struktur unit kerja yang berlaku.</p>
        </div>
    </div>

    <div class="row g-3">
        @foreach($laboratories as $lab)
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div class="small text-secondary text-uppercase fw-semibold">Laboratorium</div>
                                <h5 class="mb-0 mt-1">{{ $lab->name }}</h5>
                            </div>
                            <span class="badge text-bg-light border">{{ $lab->code }}</span>
                        </div>

                        <form method="POST" action="{{ route('admin.laboratories.update',$lab) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Laboratorium</label>
                                <input class="form-control" name="name" value="{{ $lab->name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kode</label>
                                <input class="form-control" name="code" value="{{ $lab->code }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Deskripsi</label>
                                <textarea class="form-control" rows="4" name="description">{{ $lab->description }}</textarea>
                            </div>
                            <button class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection