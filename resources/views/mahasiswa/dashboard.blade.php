@extends('layouts.app')
@section('title','Praktikum Saya')
@section('content')
<div class="container py-4">
	<div class="d-flex justify-content-between"><div><h2 class="fw-bold">Praktikum Saya</h2><p class="text-secondary">Kelas final ditetapkan Admin setelah verifikasi syarat.</p></div><a class="btn btn-primary align-self-start" href="{{ route('mahasiswa.practicums') }}">Daftar Praktikum</a></div>
	<div class="row g-3">
		@forelse($registrations as $r)
			<div class="col-lg-6"><div class="card border-0 shadow-sm h-100"><div class="card-body"><h5>{{ $r->preferredClass->course->name }}</h5><div class="small text-secondary">Pilihan awal: {{ $r->preferredClass->class_name }} • {{ $r->preferredClass->laboratory->name }}</div><div class="mt-3"><span class="badge text-bg-{{ $r->status==='approved'?'success':($r->status==='rejected'?'danger':'warning') }}">{{ $r->status }}</span></div>
				@if($r->status==='approved')
					<div class="alert alert-success mt-3 mb-0"><strong>Kelas final: {{ $r->finalClass->class_name }}</strong><br>{{ $r->finalClass->day }}, {{ substr($r->finalClass->start_time,0,5) }} • {{ $r->finalClass->room }}<hr><strong>Nilai akhir:</strong> {{ $r->final_score !== null ? number_format((float) $r->final_score, 2, ',', '.') : 'Belum diinput' }}
					@if($r->final_score !== null && $r->passed()) <div class="mt-2"><span class="badge text-bg-success">Lulus</span> <a class="btn btn-sm btn-primary ms-2" target="_blank" href="{{ route('mahasiswa.practicum-certificate', $r) }}">Download Surat Lolos</a></div>@elseif($r->final_score !== null)<div class="mt-2"><span class="badge text-bg-danger">Tidak Lulus</span></div>@endif
					</div>
				@elseif($r->admin_note)<div class="alert alert-light mt-3 mb-0">Catatan: {{ $r->admin_note }}</div>@endif
			</div></div></div>
		@empty<div class="col-12"><div class="alert alert-light">Belum ada pendaftaran praktikum.</div></div>@endforelse
	</div>
</div>
@endsection