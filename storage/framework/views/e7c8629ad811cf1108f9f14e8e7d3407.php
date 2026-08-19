<?php $__env->startSection('title', 'Pengurusan Surat'); ?>
<?php $__env->startSection('page_heading', 'Pengurusan Surat'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Pengurusan Surat</h2>
            <p class="text-secondary mb-0">Pantau posisi workflow, preview draft, dan buka surat resmi setelah selesai.</p>
        </div>
        <a class="btn btn-primary" href="<?php echo e(route('surat.create')); ?>">+ Ajukan Surat</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Jenis</th>
                        <th>Pemohon</th>
                        <th>Laboratorium</th>
                        <th>Status</th>
                        <th>Posisi</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $step = $letter->letterType->workflowSteps->firstWhere('step_order', $letter->current_step_order);
                    ?>
                    <tr>
                        <td>
                            <div class="fw-semibold"><?php echo e($letter->official_number ?: $letter->request_number); ?></div>
                            <?php if($letter->official_number): ?><div class="small text-secondary">Ref: <?php echo e($letter->request_number); ?></div><?php endif; ?>
                        </td>
                        <td><?php echo e($letter->letterType->title); ?></td>
                        <td><?php echo e($letter->applicant->name); ?></td>
                        <td><?php echo e($letter->laboratory?->name ?? '-'); ?></td>
                        <td>
                            <span class="badge text-bg-<?php echo e($letter->status === 'completed' ? 'success' : ($letter->status === 'rejected' ? 'danger' : 'warning')); ?>">
                                <?php echo e($letter->status === 'completed' ? 'Selesai' : ($letter->status === 'rejected' ? 'Ditolak' : 'Diproses')); ?>

                            </span>
                        </td>
                        <td><?php echo e($letter->status === 'completed' ? 'Surat resmi terbit' : ($letter->status === 'rejected' ? 'Pengajuan ditolak' : ($step?->label ?? '-'))); ?></td>
                        <td class="text-end text-nowrap">
                            <a class="btn btn-sm btn-outline-secondary" target="_blank" href="<?php echo e(route('surat.document', $letter)); ?>"><?php echo e($letter->status === 'completed' ? 'Surat' : 'Draft'); ?></a>
                            <a class="btn btn-sm btn-outline-primary" href="<?php echo e(route('surat.show', $letter)); ?>">Tracking</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7" class="text-center py-5 text-secondary">Belum ada pengurusan surat.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/surat/index.blade.php ENDPATH**/ ?>