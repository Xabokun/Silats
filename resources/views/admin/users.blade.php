@extends('layouts.app')
@section('title','Manajemen Akun')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Akun</h2>
            <p class="text-secondary mb-0">Registrasi publik dinonaktifkan. Hanya Admin yang dapat membuat akun SILATS.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Buat Akun</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light"><tr><th>Nama</th><th>NPM</th><th>Email</th><th>Role</th><th>Laboratorium</th></tr></thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->npm ?? '-' }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge text-bg-light">{{ ucwords(str_replace('_',' ',$user->role)) }}</span></td>
                        <td>{{ $user->laboratory?->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada akun.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
