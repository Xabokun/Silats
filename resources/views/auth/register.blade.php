@extends('layouts.app')
@section('title','Daftar Akun Mahasiswa')
@section('content')
<div class="container py-5"><div class="row justify-content-center"><div class="col-lg-6"><div class="card shadow-sm border-0"><div class="card-body p-4">
	<h3 class="fw-bold">Daftar Akun Mahasiswa</h3>
	<p class="text-secondary">Buat akun untuk mendaftar praktikum. Gunakan email student UIR yang aktif.</p>
	<form method="POST" action="{{ route('register.store') }}">@csrf
		<div class="mb-3"><label class="form-label">Nama lengkap</label><input class="form-control" name="name" value="{{ old('name') }}" required autofocus></div>
		<div class="mb-3"><label class="form-label">NPM</label><input class="form-control" name="npm" value="{{ old('npm') }}" required></div>
		<div class="mb-3"><label class="form-label">Email student UIR</label><input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="nama@student.uir.ac.id" required><div class="form-text">Wajib menggunakan domain <strong>@student.uir.ac.id</strong>.</div></div>
		<div class="row"><div class="col-md-6 mb-3"><label class="form-label">Password</label><input type="password" class="form-control" name="password" minlength="6" required></div><div class="col-md-6 mb-3"><label class="form-label">Konfirmasi password</label><input type="password" class="form-control" name="password_confirmation" minlength="6" required></div></div>
		<button class="btn btn-primary">Daftar & Masuk</button>
		<a class="btn btn-link" href="{{ route('login') }}">Sudah punya akun?</a>
	</form>
</div></div></div></div></div>
@endsection