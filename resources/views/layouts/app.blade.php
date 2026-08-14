<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','SILATS') | Sistem Informasi Laboratorium Teknik Sipil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/silats.css') }}">
    @stack('head')
</head>
<body>
@php
    $roleLabels = [
        'admin'=>'Admin',
        'mahasiswa'=>'Mahasiswa',
        'dosen'=>'Dosen',
        'tenaga_labor'=>'Tenaga Labor',
        'kepala_labor'=>'Kepala Labor',
        'prodi'=>'Program Studi',
        'umum'=>'Masyarakat'
    ];
@endphp
<nav class="navbar navbar-expand-lg navbar-dark navbar-silats sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ auth()->check()?route('dashboard'):route('home') }}">
            <span class="brand-mark">S</span><span>SILATS</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                @endguest
                @auth
                    @if(auth()->user()->isRole('admin'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.users') }}">Manajemen Akun</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.classes') }}">Jadwal & Kelas</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.registrations') }}">Verifikasi Praktikum</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.letter-types') }}">Manajemen Surat</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.services') }}">Jenis Pengujian</a></li>
                    @elseif(auth()->user()->isRole('mahasiswa'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.dashboard') }}">Praktikum Saya</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.practicums') }}">Daftar Praktikum</a></li>
                    @elseif(auth()->user()->isRole('dosen'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('dosen.dashboard') }}">Mata Kuliah Saya</a></li>
                    @elseif(auth()->user()->isRole('tenaga_labor'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('tenaga-labor.dashboard') }}">Pengujian Lab</a></li>
                    @elseif(auth()->user()->isRole('kepala_labor'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('kepala-labor.dashboard') }}">Aktivitas Lab</a></li>
                    @elseif(auth()->user()->isRole('prodi'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('prodi.dashboard') }}">Monitoring Semua Lab</a></li>
                    @elseif(auth()->user()->isRole('umum'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('umum.dashboard') }}">Pengujian Saya</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('umum.tests.create') }}">Ajukan Pengujian</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('surat.index') }}">Pengurusan Surat</a></li>
                @endauth
            </ul>

            @auth
                <div class="d-flex align-items-center gap-2">
                    <span class="badge badge-role d-none d-md-inline">{{ $roleLabels[auth()->user()->role]??auth()->user()->role }}</span>
                    <span class="text-white small d-none d-lg-inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-outline-light btn-sm">Keluar</button></form>
                </div>
            @endauth
        </div>
    </div>
</nav>

<main>
    @if(session('success')||session('error')||$errors->any())
        <div class="container pt-3">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
            @if($errors->any())
                <div class="alert alert-danger"><strong>Periksa data:</strong><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
        </div>
    @endif
    @yield('content')
</main>
<footer class="py-4 mt-5 border-top bg-white">
    <div class="container d-flex justify-content-between small text-secondary"><span>&copy; {{ date('Y') }} SILATS</span><span>Praktikum • Pengujian • Persuratan</span></div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
