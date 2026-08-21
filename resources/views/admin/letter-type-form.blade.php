@extends('layouts.app')

@section('title', $type->exists ? 'Edit Jenis Surat' : 'Buat Jenis Surat')
@section('page_heading', $type->exists ? 'Edit Jenis Surat' : 'Buat Jenis Surat')

@php
    $requirements = old('requirements', $type->exists ? $type->requirements->pluck('title')->all() : ['']);

    if (old('field_labels') !== null) {
        $fields = collect(old('field_labels'))->map(function ($label, $index) {
            return [
                'label' => $label,
                'key' => old('field_keys')[$index] ?? '',
                'type' => old('field_types')[$index] ?? 'text',
                'placeholder' => old('field_placeholders')[$index] ?? '',
                'required' => array_key_exists($index, old('field_required', [])),
            ];
        })->all();
    } else {
        $fields = $type->exists
            ? $type->formFields->map(function ($field) {
                return [
                    'label' => $field->label,
                    'key' => $field->field_key,
                    'type' => $field->input_type,
                    'placeholder' => $field->placeholder,
                    'required' => $field->is_required,
                ];
            })->all()
            : [];
    }

    if (old('workflow_roles') !== null) {
        $steps = collect(old('workflow_roles'))->map(function ($role, $index) {
            return ['role' => $role, 'label' => old('workflow_labels')[$index] ?? ''];
        })->all();
    } else {
        $steps = $type->exists
            ? $type->workflowSteps->map(fn ($step) => ['role' => $step->role, 'label' => $step->label])->all()
            : [['role' => 'mahasiswa', 'label' => 'Pengajuan Mahasiswa']];
    }

    $openTag = '{' . '{';
    $closeTag = '}' . '}';
    $defaultBody = "Dengan hormat,\n\nDengan ini menerangkan bahwa:\n\nNama       : {$openTag}nama{$closeTag}\nNPM        : {$openTag}npm{$closeTag}\nPerihal    : {$openTag}perihal{$closeTag}\n\nberdasarkan data pengajuan, yang bersangkutan memerlukan surat terkait {$openTag}perihal{$closeTag}.\n\nDemikian surat ini dibuat untuk dapat dipergunakan sebagaimana mestinya.";
@endphp

@section('content')
<div class="container-fluid px-0">
    <form method="POST" action="{{ $type->exists ? route('admin.letter-types.update', $type) : route('admin.letter-types.store') }}">
        @csrf
        @if($type->exists) @method('PUT') @endif

        @if($hasRequests)
            <div class="alert alert-warning">
                Jenis surat ini sudah memiliki riwayat pengajuan. Untuk menjaga data historis, perubahan template dokumen tetap disimpan tetapi perubahan persyaratan, field kebutuhan, dan workflow tidak diterapkan.
            </div>
        @endif

        <div class="row g-4">
            <div class="col-xl-7">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-1">1. Identitas & Template Surat</h4>
                                <div class="text-secondary small">Form utama untuk menyiapkan dokumen surat resmi.</div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Kode Surat</label>
                                <input class="form-control" name="code" required value="{{ old('code', $type->code) }}" placeholder="SKPRAK">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Judul Jenis Surat</label>
                                <input class="form-control" name="title" required value="{{ old('title', $type->title) }}" placeholder="Surat Keterangan Praktikum">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Deskripsi</label>
                                <textarea class="form-control" name="description" rows="2">{{ old('description', $type->description) }}</textarea>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Perihal Default</label>
                                <input class="form-control" name="default_subject" value="{{ old('default_subject', $type->default_subject) }}" placeholder="Keterangan Praktikum">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Lampiran</label>
                                <input class="form-control" name="attachment_text" value="{{ old('attachment_text', $type->attachment_text ?: '-') }}" placeholder="- / 1 Berkas">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Format Nomor Surat</label>
                                <input class="form-control" name="number_format" required value="{{ old('number_format', $type->number_format ?: '{seq}/{code}/{month_roman}/{year}') }}">
                                <div class="form-text">Token: <code>{seq}</code>, <code>{code}</code>, <code>{month}</code>, <code>{month_roman}</code>, <code>{year}</code>, <code>{lab}</code>.</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Isi Surat</label>
                                <textarea class="form-control font-monospace" name="body_template" rows="13" required>{{ old('body_template', $type->body_template ?: $defaultBody) }}</textarea>
                                <div class="form-text">
                                    Placeholder otomatis: <code>@{{nama}}</code>, <code>@{{npm}}</code>, <code>@{{email}}</code>, <code>@{{perihal}}</code>, <code>@{{laboratorium}}</code>, <code>@{{tanggal_surat}}</code>, <code>@{{nomor_surat}}</code>. Field bawaan admin dipanggil dengan <code>@{{field:nama_key}}</code>.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-1">2. Data Kebutuhan Surat</h4>
                                <div class="text-secondary small">Field ini diisi pemohon saat pengajuan surat berlangsung.</div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addField()">+ Field</button>
                        </div>
                        <div id="fields">
                            @foreach($fields as $index => $field)
                                <div class="row g-2 mb-2 field-row" data-index="{{ $index }}">
                                    <div class="col-md-3"><input class="form-control" name="field_labels[{{ $index }}]" value="{{ $field['label'] }}" placeholder="Label: Keperluan"></div>
                                    <div class="col-md-2"><input class="form-control" name="field_keys[{{ $index }}]" value="{{ $field['key'] }}" placeholder="keperluan"></div>
                                    <div class="col-md-2">
                                        <select class="form-select" name="field_types[{{ $index }}]">
                                            @foreach(['text'=>'Teks','textarea'=>'Teks Panjang','date'=>'Tanggal','number'=>'Angka'] as $value => $label)
                                                <option value="{{ $value }}" @selected($field['type']===$value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3"><input class="form-control" name="field_placeholders[{{ $index }}]" value="{{ $field['placeholder'] }}" placeholder="Petunjuk pengisian"></div>
                                    <div class="col-md-1 d-flex align-items-center justify-content-center"><input class="form-check-input" type="checkbox" name="field_required[{{ $index }}]" value="1" @checked($field['required']) title="Wajib"></div>
                                    <div class="col-md-1"><button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.field-row').remove()">×</button></div>
                                </div>
                            @endforeach
                        </div>
                        <div class="small text-secondary">Key hanya huruf kecil, angka, dan underscore. Contoh key <code>keperluan</code> dipanggil dalam isi surat sebagai <code>@{{field:keperluan}}</code>.</div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-1">3. Persyaratan Berkas</h4>
                                <div class="text-secondary small">Dokumen pendukung yang wajib dilampirkan pemohon.</div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addReq()">+ Syarat</button>
                        </div>
                        <div id="reqs">
                            @foreach($requirements as $requirement)
                                <div class="input-group mb-2 req-row">
                                    <input class="form-control" name="requirements[]" value="{{ $requirement }}" placeholder="Contoh: KRS Semester Aktif">
                                    <button type="button" class="btn btn-outline-danger" onclick="this.closest('.req-row').remove()">Hapus</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h4 class="mb-3">4. Penandatangan</h4>
                        <div class="mb-3"><label class="form-label fw-semibold">Nama</label><input class="form-control" name="signatory_name" required value="{{ old('signatory_name', $type->signatory_name) }}" placeholder="Dr. Ahmad, S.T., M.T."></div>
                        <div class="mb-3"><label class="form-label fw-semibold">Jabatan</label><input class="form-control" name="signatory_position" required value="{{ old('signatory_position', $type->signatory_position) }}" placeholder="Kepala Laboratorium"></div>
                        <div><label class="form-label fw-semibold">NIDN</label><input class="form-control" name="signatory_identifier" value="{{ old('signatory_identifier', $type->signatory_identifier) }}" placeholder="NIDN. 0000000000"></div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h4 class="mb-1">5. Workflow Surat</h4>
                                <div class="text-secondary small">Urutan pemrosesan ditentukan secara terpusat oleh Admin.</div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addStep()">+ Tahap</button>
                        </div>
                        <div id="steps">
                            @foreach($steps as $index => $step)
                                <div class="row g-2 mb-2 step-row" data-index="{{ $index }}">
                                    <div class="col-5">
                                        <select class="form-select" name="workflow_roles[{{ $index }}]" required>
                                            @foreach(['mahasiswa'=>'Mahasiswa','admin'=>'Admin','dosen'=>'Dosen','tenaga_labor'=>'Tenaga Labor','kepala_labor'=>'Kepala Labor','prodi'=>'Ka/Sekretaris Program Studi','umum'=>'Umum'] as $value => $label)
                                                <option value="{{ $value }}" @selected($step['role']===$value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-5"><input class="form-control" name="workflow_labels[{{ $index }}]" required value="{{ $step['label'] }}" placeholder="Verifikasi Admin"></div>
                                    <div class="col-2"><button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.step-row').remove()">×</button></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-lg">{{ $type->exists ? 'Simpan Perubahan' : 'Buat Jenis Surat' }}</button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.letter-types') }}">Kembali</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let fieldIndex = {{ count($fields) }};
let stepIndex = {{ count($steps) }};

function addReq() {
    document.getElementById('reqs').insertAdjacentHTML('beforeend', `
        <div class="input-group mb-2 req-row">
            <input class="form-control" name="requirements[]" placeholder="Nama persyaratan berkas">
            <button type="button" class="btn btn-outline-danger" onclick="this.closest('.req-row').remove()">Hapus</button>
        </div>`);
}

function addField() {
    const i = fieldIndex++;
    document.getElementById('fields').insertAdjacentHTML('beforeend', `
        <div class="row g-2 mb-2 field-row" data-index="${i}">
            <div class="col-md-3"><input class="form-control" name="field_labels[${i}]" placeholder="Label: Keperluan"></div>
            <div class="col-md-2"><input class="form-control" name="field_keys[${i}]" placeholder="keperluan"></div>
            <div class="col-md-2"><select class="form-select" name="field_types[${i}]"><option value="text">Teks</option><option value="textarea">Teks Panjang</option><option value="date">Tanggal</option><option value="number">Angka</option></select></div>
            <div class="col-md-3"><input class="form-control" name="field_placeholders[${i}]" placeholder="Petunjuk pengisian"></div>
            <div class="col-md-1 d-flex align-items-center justify-content-center"><input class="form-check-input" type="checkbox" name="field_required[${i}]" value="1" checked title="Wajib"></div>
            <div class="col-md-1"><button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.field-row').remove()">×</button></div>
        </div>`);
}

function addStep() {
    const i = stepIndex++;
    document.getElementById('steps').insertAdjacentHTML('beforeend', `
        <div class="row g-2 mb-2 step-row" data-index="${i}">
            <div class="col-5"><select class="form-select" name="workflow_roles[${i}]" required><option value="mahasiswa">Mahasiswa</option><option value="admin">Admin</option><option value="dosen">Dosen</option><option value="tenaga_labor">Tenaga Labor</option><option value="kepala_labor">Kepala Labor</option><option value="prodi">Ka/Sekretaris Program Studi</option><option value="umum">Umum</option></select></div>
            <div class="col-5"><input class="form-control" name="workflow_labels[${i}]" required placeholder="Label tahap"></div>
            <div class="col-2"><button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.step-row').remove()">×</button></div>
        </div>`);
}
</script>
@endpush
