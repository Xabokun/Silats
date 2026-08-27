@extends('layouts.app')
@section('title','Login')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-1">Login SILATS</h3>
                    <p class="text-secondary">Gunakan email. Mahasiswa juga dapat menggunakan NPM.</p>
                    <form method="POST" action="{{ route('login.attempt') }}">
                        @csrf
                        <div class="mb-3"><label class="form-label">Email / NPM</label><input class="form-control" name="login" value="{{ old('login') }}" required autofocus></div>
                        <div class="mb-3"><label class="form-label">Password</label><input type="password" class="form-control" name="password" required></div>
                        <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" id="remember"><label class="form-check-label" for="remember">Ingat saya</label></div>
                        <button class="btn btn-primary w-100">Masuk</button>
                    </form>
                    <hr>
                    <p class="small text-secondary mb-0">Belum memiliki akun mahasiswa? <a href="{{ route('register') }}">Daftar dengan email student UIR</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
