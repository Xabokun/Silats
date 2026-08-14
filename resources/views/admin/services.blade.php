@extends('layouts.app')
@section('title','Jenis Pengujian')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Jenis Pengujian</h2>
            <p class="text-secondary mb-0">Admin dapat menambah kategori dan jenis pengujian tanpa mengubah source code.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5>Tambah Kategori Pengujian</h5>
                    <p class="small text-secondary">Contoh kategori: Beton, Tanah, Air, Aspal.</p>
                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <input class="form-control mb-2" name="name" placeholder="Contoh: Aspal" required>
                        <textarea class="form-control mb-2" name="description" placeholder="Deskripsi kategori"></textarea>
                        <button class="btn btn-outline-primary">Tambah Kategori</button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <h5>Tambah Jenis Pengujian</h5>
                    <p class="small text-secondary">Jenis pengujian akan langsung tersedia pada layanan yang dapat dipilih pemohon.</p>
                    <form method="POST" action="{{ route('admin.services.store') }}">
                        @csrf
                        <label class="form-label">Kategori</label>
                        <select class="form-select mb-2" name="testing_category_id" required>
                            @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                        </select>

                        <label class="form-label">Laboratorium</label>
                        <select class="form-select mb-2" name="laboratory_id" required>
                            @foreach($laboratories as $l)<option value="{{ $l->id }}">{{ $l->name }}</option>@endforeach
                        </select>

                        <label class="form-label">Kode Jenis Pengujian</label>
                        <input class="form-control mb-2" name="code" placeholder="Contoh: UJI-BTN-KT" required>

                        <label class="form-label">Nama Jenis Pengujian</label>
                        <input class="form-control mb-2" name="name" placeholder="Contoh: Uji Kuat Tekan Beton" required>

                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control mb-2" name="description" placeholder="Deskripsi pengujian"></textarea>

                        <label class="form-label">Persyaratan Sampel</label>
                        <textarea class="form-control mb-3" name="requirements" placeholder="Contoh: Bawa 3 benda uji silinder beton"></textarea>

                        <button class="btn btn-primary">Tambah Jenis Pengujian</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            @forelse($categories as $c)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><h5 class="mb-1">{{ $c->name }}</h5><p class="text-secondary mb-0">{{ $c->description }}</p></div>
                            <span class="badge text-bg-light">{{ $c->services->count() }} jenis</span>
                        </div>
                        <div class="list-group list-group-flush mt-2">
                            @forelse($c->services as $s)
                                <div class="list-group-item px-0">
                                    <strong>{{ $s->name }}</strong><br>
                                    <small class="text-secondary">{{ $s->laboratory->name }} • {{ $s->code }}</small>
                                    @if($s->requirements)<div class="small mt-1">Syarat: {{ $s->requirements }}</div>@endif
                                </div>
                            @empty
                                <div class="list-group-item px-0 text-secondary">Belum ada jenis pengujian pada kategori ini.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-light">Belum ada kategori pengujian.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
