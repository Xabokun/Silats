@extends('layouts.app')
@section('title', $user?->exists ? 'Edit Akun' : 'Buat Akun')
@section('page_heading', $user?->exists ? 'Edit Akun' : 'Buat Akun')
@section('content')
@php
    $isEdit = $user?->exists;
    $roleValue = old('role', $user->role ?? '');
    $labValue = old('laboratory_id', $user->laboratory_id ?? '');
@endphp
<div class="container-fluid px-0">
    <div class="row justify-content-center">
        <div class="col-xxl-9 col-xl-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h3 class="fw-bold mb-1">{{ $isEdit ? 'Edit Akun SILATS' : 'Buat Akun SILATS' }}</h3>
                            <p class="text-secondary mb-0">{{ $isEdit ? 'Admin dapat memperbarui identitas, role, jabatan, laboratorium, email, dan password akun.' : 'Form ini hanya dapat diakses Admin. Semua akun dibuat melalui Admin.' }}</p>
                        </div>
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
                    </div>

                    <form method="POST" action="{{ $isEdit ? route('admin.users.update', $user) : route('admin.users.store') }}">
                        @csrf
                        @if($isEdit) @method('PUT') @endif
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Nama lengkap</label><input class="form-control" name="name" value="{{ old('name', $user->name ?? '') }}" required></div>
                            <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="{{ old('email', $user->email ?? '') }}" required></div>
                            <div class="col-md-6">
                                <label class="form-label">Role Sistem</label>
                                <select class="form-select" name="role" id="role" required>
                                    <option value="">Pilih role</option>
                                    @foreach(['admin'=>'Admin','mahasiswa'=>'Mahasiswa','dosen'=>'Dosen','tenaga_labor'=>'Tenaga Labor','kepala_labor'=>'Kepala Labor','prodi'=>'Program Studi','umum'=>'Masyarakat'] as $value=>$label)
                                        <option value="{{ $value }}" @selected($roleValue===$value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6" id="npmGroup"><label class="form-label">NPM <span class="text-secondary">(khusus mahasiswa)</span></label><input class="form-control" name="npm" value="{{ old('npm', $user->npm ?? '') }}"></div>
                            <div class="col-md-6" id="nidnGroup"><label class="form-label">NIDN <span class="text-secondary">(khusus dosen)</span></label><input class="form-control" name="nidn" value="{{ old('nidn', $user->nidn ?? '') }}"></div>
                            <div class="col-md-6" id="expertiseGroup"><label class="form-label">Kepakaran <span class="text-secondary">(khusus dosen)</span></label><input class="form-control" name="expertise" value="{{ old('expertise', $user->expertise ?? '') }}" placeholder="Contoh: Struktur, Beton, Manajemen Konstruksi"></div>
                            <div class="col-md-6" id="labGroup"><label class="form-label">Laboratorium <span class="text-secondary">(Tenaga Labor/Kepala Lab)</span></label><select class="form-select" name="laboratory_id"><option value="">Pilih laboratorium</option>@foreach($laboratories as $lab)<option value="{{ $lab->id }}" @selected($labValue==$lab->id)>{{ $lab->name }}</option>@endforeach</select></div>

                            <div class="col-12" id="positionGroup">
                                <div class="border rounded-3 p-3 bg-light-subtle">
                                    <div class="fw-semibold mb-2">Jabatan Prodi / Jabatan Struktural</div>
                                    <div class="small text-secondary mb-3">Digunakan agar masa jabatan dapat dicatat dan diperbarui ketika periode berakhir.</div>
                                    <div class="row g-3">
                                        <div class="col-md-6"><label class="form-label">Jabatan</label><input class="form-control" name="position_title" value="{{ old('position_title', $user->position_title ?? '') }}" placeholder="Contoh: Ketua Program Studi Teknik Sipil"></div>
                                        <div class="col-md-3"><label class="form-label">Mulai Menjabat</label><input type="date" class="form-control" name="position_start_date" value="{{ old('position_start_date', optional($user?->position_start_date)->format('Y-m-d')) }}"></div>
                                        <div class="col-md-3"><label class="form-label">Selesai Menjabat</label><input type="date" class="form-control" name="position_end_date" value="{{ old('position_end_date', optional($user?->position_end_date)->format('Y-m-d')) }}"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" id="phoneGroup"><label class="form-label">No. HP</label><input class="form-control" name="phone" value="{{ old('phone', $user->phone ?? '') }}"></div>
                            <div class="col-12" id="addressGroup"><label class="form-label">Alamat</label><textarea class="form-control" name="address" rows="2">{{ old('address', $user->address ?? '') }}</textarea></div>
                            <div class="col-md-6"><label class="form-label">Password {{ $isEdit ? '(opsional — kosongkan jika tidak diubah)' : '' }}</label><input type="password" class="form-control" name="password" {{ $isEdit ? '' : 'required' }} minlength="6"></div>
                            <div class="col-md-6"><label class="form-label">Konfirmasi Password {{ $isEdit ? '(opsional)' : '' }}</label><input type="password" class="form-control" name="password_confirmation" {{ $isEdit ? '' : 'required' }} minlength="6"></div>
                        </div>
                        <button class="btn btn-primary mt-4">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Akun' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
(function(){
    const role = document.getElementById('role');
    const npm = document.getElementById('npmGroup');
    const nidn = document.getElementById('nidnGroup');
    const expertise = document.getElementById('expertiseGroup');
    const lab = document.getElementById('labGroup');
    const position = document.getElementById('positionGroup');
    const phone = document.getElementById('phoneGroup');
    const address = document.getElementById('addressGroup');
    function sync(){
        const r = role.value;
        npm.style.display = r === 'mahasiswa' ? '' : 'none';
        nidn.style.display = r === 'dosen' ? '' : 'none';
        expertise.style.display = r === 'dosen' ? '' : 'none';
        lab.style.display = ['tenaga_labor','kepala_labor'].includes(r) ? '' : 'none';
        position.style.display = ['dosen','prodi'].includes(r) ? '' : 'none';
        phone.style.display = r === 'dosen' ? 'none' : '';
        address.style.display = r === 'dosen' ? 'none' : '';
    }
    role.addEventListener('change', sync); sync();
})();
</script>
@endpush
