@extends('layouts.app')
@section('title','Manajemen Akun')
@section('page_heading','Manajemen Akun')
@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Akun</h2>
            <p class="text-secondary mb-0">Daftar akun pengguna SILATS yang dikelola secara terpusat oleh Admin.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Buat Akun</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama</th>
                            <th>NPM / NIDN</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Jabatan</th>
                            <th>Laboratorium</th>
                            <th>Periode Jabatan</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->npm ?: ($user->nidn ?: '-') }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge text-bg-light border">{{ ucwords(str_replace('_',' ',$user->role)) }}</span></td>
                            <td>{{ $user->position_title ?? '-' }}</td>
                            <td>{{ $user->laboratory?->name ?? '-' }}</td>
                            <td class="small">
                                @if($user->position_start_date || $user->position_end_date)
                                    {{ $user->position_start_date?->format('d/m/Y') ?? '-' }}
                                    <br>
                                    @if($user->position_end_date)
                                        <span class="{{ $user->position_end_date->isPast() ? 'text-danger' : '' }}">
                                            {{ $user->position_end_date->format('d/m/Y') }}{{ $user->position_end_date->isPast() ? ' (Berakhir)' : '' }}
                                        </span>
                                    @else
                                        <span class="text-success">Berjalan</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-secondary py-4">Belum ada akun yang terdaftar.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
