@extends('layouts.app')
@section('title','Buat Akun')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div><h3 class="fw-bold mb-1">Buat Akun SILATS</h3><p class="text-secondary mb-0">Form ini hanya dapat diakses Admin.</p></div>
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
                    </div>

                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Nama lengkap</label><input class="form-control" name="name" value="{{ old('name') }}" required></div>
                            <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="{{ old('email') }}" required></div>
                            <div class="col-md-6"><label class="form-label">Role</label><select class="form-select" name="role" id="role" required>
                                <option value="">Pilih role</option>
                                @foreach(['admin'=>'Admin','mahasiswa'=>'Mahasiswa','dosen'=>'Dosen','tenaga_labor'=>'Tenaga Labor','kepala_labor'=>'Kepala Labor','prodi'=>'Program Studi','umum'=>'Masyarakat'] as $value=>$label)
                                    <option value="{{ $value }}" @selected(old('role')===$value)>{{ $label }}</option>
                                @endforeach
                            </select></div>
                            <div class="col-md-6" id="npmGroup"><label class="form-label">NPM <span class="text-secondary">(khusus mahasiswa)</span></label><input class="form-control" name="npm" value="{{ old('npm') }}"></div>
                            <div class="col-md-6" id="labGroup"><label class="form-label">Laboratorium <span class="text-secondary">(Laboran/Kepala Lab)</span></label><select class="form-select" name="laboratory_id"><option value="">Pilih laboratorium</option>@foreach($laboratories as $lab)<option value="{{ $lab->id }}" @selected(old('laboratory_id')==$lab->id)>{{ $lab->name }}</option>@endforeach</select></div>
                            <div class="col-md-6"><label class="form-label">No. HP</label><input class="form-control" name="phone" value="{{ old('phone') }}"></div>
                            <div class="col-12"><label class="form-label">Alamat</label><textarea class="form-control" name="address">{{ old('address') }}</textarea></div>
                            <div class="col-md-6"><label class="form-label">Password</label><input type="password" class="form-control" name="password" required minlength="6"></div>
                            <div class="col-md-6"><label class="form-label">Konfirmasi Password</label><input type="password" class="form-control" name="password_confirmation" required minlength="6"></div>
                        </div>
                        <button class="btn btn-primary mt-4">Simpan Akun</button>
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
    const lab = document.getElementById('labGroup');
    function sync(){
        npm.style.display = role.value === 'mahasiswa' ? '' : 'none';
        lab.style.display = ['tenaga_labor','kepala_labor'].includes(role.value) ? '' : 'none';
    }
    role.addEventListener('change', sync); sync();
})();
</script>
@endpush
