<?php $__env->startSection('title', 'Manajemen Surat'); ?>
<?php $__env->startSection('page_heading', 'Manajemen Surat'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Surat</h2>
            <p class="text-secondary mb-0">Admin menentukan jenis surat, data kebutuhan, template dokumen, penandatangan, persyaratan, dan workflow.</p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="<?php echo e(route('admin.letter-settings')); ?>">Pengaturan Kop</a>
            <a class="btn btn-primary" href="<?php echo e(route('admin.letter-types.create')); ?>">+ Jenis Surat</a>
        </div>
    </div>

    <div class="row g-3">
        <?php $__empty_1 = true; $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between gap-3">
                            <div>
                                <span class="badge text-bg-secondary"><?php echo e($type->code); ?></span>
                                <h5 class="mt-2 mb-1"><?php echo e($type->title); ?></h5>
                                <p class="text-secondary"><?php echo e($type->description); ?></p>
                            </div>
                            <a class="btn btn-sm btn-outline-primary align-self-start" href="<?php echo e(route('admin.letter-types.edit', $type)); ?>">Atur Template</a>
                        </div>

                        <div class="row g-3 small">
                            <div class="col-md-6"><strong>Perihal default</strong><div class="text-secondary"><?php echo e($type->default_subject ?: '-'); ?></div></div>
                            <div class="col-md-6"><strong>Penandatangan</strong><div class="text-secondary"><?php echo e($type->signatory_name ?: '-'); ?></div></div>
                            <div class="col-md-6"><strong>Data kebutuhan</strong><div class="text-secondary"><?php echo e($type->formFields->count()); ?> field</div></div>
                            <div class="col-md-6"><strong>Riwayat pengajuan</strong><div class="text-secondary"><?php echo e($type->requests_count); ?> surat</div></div>
                        </div>

                        <hr>
                        <h6>Persyaratan Berkas</h6>
                        <ul class="mb-3">
                            <?php $__empty_2 = true; $__currentLoopData = $type->requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requirement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <li><?php echo e($requirement->title); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <li class="text-secondary">Tanpa lampiran khusus</li>
                            <?php endif; ?>
                        </ul>

                        <h6>Alur</h6>
                        <div class="d-flex flex-wrap gap-1">
                            <?php $__currentLoopData = $type->workflowSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge rounded-pill text-bg-primary"><?php echo e($step->step_order); ?>. <?php echo e($step->label); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12"><div class="alert alert-light border">Belum ada jenis surat.</div></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/admin/letter-types.blade.php ENDPATH**/ ?>