@extends("layouts.app")
@section("content")
<div class="container py-4"><h3>Pengaturan Alur Pengujian: {{$testingService->name}}</h3><form method="POST">@csrf
@php($roles=["admin"=>"Admin","kepala_labor"=>"Kepala Labor","tenaga_labor"=>"Tenaga Labor","prodi"=>"Ka/Sekretaris Program Studi","dosen"=>"Dosen"])
@foreach($roles as $k=>$v)<div><label><input type="checkbox" name="roles[]" value="{{$k}}" @checked($steps->pluck("role")->contains($k))> {{$v}}</label></div>@endforeach
<button class="btn btn-primary mt-3">Simpan</button></form></div>
@endsection
