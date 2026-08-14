@extends('layouts.app')
@section('title', 'Pilih Jadwal Praktikum')
@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('mahasiswa.dashboard') }}" class="text-decoration-none small">&larr; Kembali ke KRS Praktikum</a>
        <h1 class="h3 section-title mt-2">Pilih Jadwal Praktikum</h1>
        <p class="text-secondary mb-0">Pilih satu jadwal untuk setiap mata praktikum. Laboratorium mengikuti jadwal yang dipilih.</p>
    </div>

    <div class="row g-4">
        @forelse($schedules as $schedule)
            @php
                $full = $schedule->registrations_count >= $schedule->quota;
                $registered = in_array($schedule->id, $registeredScheduleIds, true);
            @endphp
            <div class="col-md-6 col-xl-4">
                <div class="card card-soft h-100">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between gap-2 mb-2">
                            <span class="badge text-bg-secondary">{{ $schedule->practicum->code }}</span>
                            <span class="badge text-bg-{{ $full ? 'danger' : 'success' }}">{{ $schedule->registrations_count }}/{{ $schedule->quota }}</span>
                        </div>
                        <h5 class="fw-bold">{{ $schedule->practicum->name }}</h5>
                        <div class="small text-secondary mb-3">{{ $schedule->academic_year }} - {{ $schedule->term }}</div>
                        <dl class="row small mb-4">
                            <dt class="col-4">Labor</dt><dd class="col-8">{{ $schedule->laboratory->name }}</dd>
                            <dt class="col-4">Jadwal</dt><dd class="col-8">{{ $schedule->day }}, {{ substr($schedule->start_time,0,5) }}-{{ substr($schedule->end_time,0,5) }}</dd>
                            <dt class="col-4">Ruang</dt><dd class="col-8">{{ $schedule->room ?? '-' }}</dd>
                            <dt class="col-4">Dosen</dt><dd class="col-8">{{ $schedule->lecturer?->name ?? 'Belum ditentukan' }}</dd>
                        </dl>
                        <div class="mt-auto">
                            @if($registered)
                                <button class="btn btn-success w-100" disabled>Sudah Dipilih</button>
                            @elseif($full)
                                <button class="btn btn-secondary w-100" disabled>Kuota Penuh</button>
                            @else
                                <form method="POST" action="{{ route('mahasiswa.register', $schedule) }}">
                                    @csrf
                                    <button class="btn btn-primary w-100">Pilih Jadwal Ini</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">Belum ada jadwal praktikum aktif.</div></div>
        @endforelse
    </div>
</div>
@endsection
