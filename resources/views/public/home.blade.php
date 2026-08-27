@extends('layouts.app')
@section('title','Beranda')
@section('content')
<section class="hero-silats py-5">
    <div class="container py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge text-bg-light mb-3">Program Studi Teknik Sipil</span>
                <h1 class="display-5 fw-bold">SILATS</h1>
                <p class="lead">Sistem terpadu untuk pendaftaran praktikum, pengujian material masyarakat, dan pengurusan surat berjenjang.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-light px-4" href="{{ route('login') }}">Login SILATS</a>
                    <a class="btn btn-outline-light px-4" href="{{ route('register') }}">Register Mahasiswa</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow">
                    <div class="card-body p-4 text-dark">
                        <h5 class="fw-bold">Layanan utama</h5>
                        <div class="vstack gap-2">
                            <div>✓ Praktikum & verifikasi kelas</div>
                            <div>✓ Tracking pengujian sampel</div>
                            <div>✓ Workflow surat berjenjang</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container py-5">
    <h2 class="fw-bold mb-4">Layanan Pengujian</h2>
    <div class="row g-4">
        @forelse($categories as $cat)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h4>{{ $cat->name }}</h4>
                        <p class="text-secondary">{{ $cat->description }}</p>
                        <ul class="mb-0">
                            @foreach($cat->services as $service)
                                <li>{{ $service->name }} <span class="text-secondary">({{ $service->laboratory->name }})</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @empty
            <p>Belum ada layanan pengujian.</p>
        @endforelse
    </div>

    <h2 class="fw-bold mt-5 mb-4">Laboratorium</h2>
    <div class="row g-3">
        @foreach($laboratories as $lab)
            <div class="col-md-4"><div class="p-4 bg-light rounded-3 h-100"><h5>{{ $lab->name }}</h5><p class="mb-0 text-secondary">{{ $lab->description }}</p></div></div>
        @endforeach
    </div>
</div>
@endsection
