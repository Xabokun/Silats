<?php $__env->startSection('title', 'Manajemen Surat'); ?>
<?php $__env->startSection('page_heading', 'Manajemen Surat'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Surat</h2>
            <p class="text-secondary mb-0">Kelola semua jenis surat, template dokumen, persyaratan berkas, dan alur proses administrasi.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-outline-secondary" href="<?php echo e(route('admin.letter-settings')); ?>">Pengaturan Kop</a>
            <a class="btn btn-primary" href="<?php echo e(route('admin.letter-types.create')); ?>">+ Jenis Surat</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary small text-uppercase">Total jenis surat</div>
                    <div class="display-6 fw-bold mt-2"><?php echo e($types->count()); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary small text-uppercase">Template aktif</div>
                    <div class="display-6 fw-bold mt-2"><?php echo e($types->filter(fn($type) => $type->body_template)->count()); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary small text-uppercase">Riwayat pengajuan</div>
                    <div class="display-6 fw-bold mt-2"><?php echo e($types->sum('requests_count')); ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <?php $__empty_1 = true; $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <div>
                                <span class="badge text-bg-secondary"><?php echo e($type->code); ?></span>
                                <h5 class="mt-2 mb-1"><?php echo e($type->title); ?></h5>
                                <p class="text-secondary mb-0"><?php echo e($type->description ?: 'Belum ada deskripsi jenis surat.'); ?></p>
                            </div>
                            <a class="btn btn-sm btn-outline-primary align-self-start" href="<?php echo e(route('admin.letter-types.edit', $type)); ?>">Atur Template</a>
                        </div>

                        <div class="row g-3 small mb-3">
                            <div class="col-md-6">
                                <div class="text-secondary">Perihal default</div>
                                <div class="fw-semibold mt-1"><?php echo e($type->default_subject ?: '-'); ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-secondary">Penandatangan</div>
                                <div class="fw-semibold mt-1"><?php echo e($type->signatory_name ?: '-'); ?></div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-secondary">Data kebutuhan</div>
                                <div class="fw-semibold mt-1"><?php echo e($type->formFields->count()); ?> field</div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-secondary">Riwayat pengajuan</div>
                                <div class="fw-semibold mt-1"><?php echo e($type->requests_count); ?> surat</div>
                            </div>
                        </div>

                        <div class="border-top pt-3">
                            <h6 class="fw-semibold mb-2">Persyaratan Berkas</h6>
                            <ul class="mb-3 ps-3">
                                <?php $__empty_2 = true; $__currentLoopData = $type->requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requirement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <li><?php echo e($requirement->title); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <li class="text-secondary">Tanpa lampiran khusus</li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="border-top pt-3">
                            <h6 class="fw-semibold mb-2">Alur Proses</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <?php $__currentLoopData = $type->workflowSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge rounded-pill text-bg-primary-subtle border"><?php echo e($step->step_order); ?>. <?php echo e($step->label); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-light border mb-0">Belum ada jenis surat yang dikelola.</div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/admin/letter-types.blade.php ENDPATH**/ ?>