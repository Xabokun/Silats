<?php $__env->startSection('title', 'Ajukan Surat'); ?>
<?php $__env->startSection('page_heading', 'Ajukan Surat'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="mb-2">Ajukan Surat</h3>
                    <p class="text-secondary mb-4">Isi data kebutuhan surat. SILATS akan membentuk draft dokumen resmi secara otomatis.</p>

                    <form method="POST" enctype="multipart/form-data" action="<?php echo e(route('surat.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Jenis Surat</label>
                            <select class="form-select" name="letter_type_id" id="type" onchange="renderType()" required>
                                <option value="">Pilih jenis surat</option>
                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type->id); ?>" <?php if(old('letter_type_id') == $type->id): echo 'selected'; endif; ?>><?php echo e($type->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Laboratorium terkait <span class="text-secondary">(opsional)</span></label>
                            <select class="form-select" name="laboratory_id">
                                <option value="">Tidak spesifik</option>
                                <?php $__currentLoopData = $laboratories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laboratory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($laboratory->id); ?>" <?php if(old('laboratory_id') == $laboratory->id): echo 'selected'; endif; ?>><?php echo e($laboratory->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Perihal Surat</label>
                            <input class="form-control" id="subject" name="subject" value="<?php echo e(old('subject')); ?>" placeholder="Otomatis mengikuti jenis surat, tetapi dapat disesuaikan">
                        </div>

                        <div id="dynamicFields"></div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Tambahan</label>
                            <textarea class="form-control" name="notes" rows="3"><?php echo e(old('notes')); ?></textarea>
                        </div>

                        <div id="reqbox"></div>

                        <div class="alert alert-info mt-4 mb-3">
                            Setelah dikirim, sistem langsung membuat <strong>Draft Surat</strong>. Nomor surat resmi dan tanggal penerbitan dibuat otomatis setelah seluruh workflow disetujui.
                        </div>
                        <button class="btn btn-primary">Kirim & Generate Draft</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php
    $letterTypeData = $types->map(function ($type) {
        return [
            'id' => $type->id,
            'subject' => $type->default_subject ?: $type->title,
            'reqs' => $type->requirements->map(function ($requirement) {
                return ['id' => $requirement->id, 'title' => $requirement->title, 'required' => (bool) $requirement->is_required];
            })->values(),
            'fields' => $type->formFields->map(function ($field) {
                return [
                    'id' => $field->id,
                    'label' => $field->label,
                    'type' => $field->input_type,
                    'placeholder' => $field->placeholder,
                    'required' => (bool) $field->is_required,
                ];
            })->values(),
            'steps' => $type->workflowSteps->map(function ($step) { return $step->label; })->values(),
        ];
    })->values();
?>

<?php $__env->startPush('scripts'); ?>
<script>
const types = <?php echo json_encode($letterTypeData, 15, 512) ?>;

function escapeHtml(value) {
    return String(value ?? '').replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;').replaceAll('"', '&quot;').replaceAll("'", '&#039;');
}

function renderType() {
    const selected = types.find(item => String(item.id) === String(document.getElementById('type').value));
    const fieldsBox = document.getElementById('dynamicFields');
    const reqBox = document.getElementById('reqbox');
    fieldsBox.innerHTML = '';
    reqBox.innerHTML = '';
    if (!selected) return;

    const subject = document.getElementById('subject');
    if (!subject.value.trim()) subject.value = selected.subject || '';

    if (selected.fields.length) {
        let html = '<hr><h5 class="mb-3">Data Kebutuhan Surat</h5>';
        selected.fields.forEach(field => {
            const required = field.required ? 'required' : '';
            const mark = field.required ? ' <span class="text-danger">*</span>' : '';
            const placeholder = escapeHtml(field.placeholder || '');
            if (field.type === 'textarea') {
                html += `<div class="mb-3"><label class="form-label">${escapeHtml(field.label)}${mark}</label><textarea class="form-control" rows="3" name="letter_field_${field.id}" placeholder="${placeholder}" ${required}></textarea></div>`;
            } else {
                const inputType = field.type === 'date' ? 'date' : (field.type === 'number' ? 'number' : 'text');
                html += `<div class="mb-3"><label class="form-label">${escapeHtml(field.label)}${mark}</label><input type="${inputType}" class="form-control" name="letter_field_${field.id}" placeholder="${placeholder}" ${required}></div>`;
            }
        });
        fieldsBox.innerHTML = html;
    }

    let reqHtml = '<hr><h5 class="mb-3">Persyaratan Berkas</h5>';
    if (!selected.reqs.length) {
        reqHtml += '<div class="alert alert-light border">Tidak ada berkas khusus yang harus diunggah.</div>';
    } else {
        selected.reqs.forEach(req => {
            const required = req.required ? 'required' : '';
            const mark = req.required ? ' <span class="text-danger">*</span>' : '';
            reqHtml += `<div class="mb-3"><label class="form-label">${escapeHtml(req.title)}${mark}</label><input type="file" class="form-control" name="letter_req_${req.id}" ${required}></div>`;
        });
    }
    reqHtml += '<h6 class="mt-4">Alur Pengurusan</h6>';
    reqHtml += selected.steps.length ? `<div class="small text-secondary">${selected.steps.map(escapeHtml).join(' → ')}</div>` : '<div class="alert alert-warning">Jenis surat belum memiliki alur.</div>';
    reqBox.innerHTML = reqHtml;
}

document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('type').value) renderType();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/surat/create.blade.php ENDPATH**/ ?>