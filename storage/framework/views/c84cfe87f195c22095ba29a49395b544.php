<?php $__env->startSection('title', 'Pilih Jadwal Praktikum'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="mb-4">
        <a href="<?php echo e(route('mahasiswa.dashboard')); ?>" class="text-decoration-none small">&larr; Kembali ke KRS Praktikum</a>
        <h1 class="h3 section-title mt-2">Pilih Jadwal Praktikum</h1>
        <p class="text-secondary mb-0">Pilih satu jadwal untuk setiap mata praktikum. Laboratorium mengikuti jadwal yang dipilih.</p>
    </div>

    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $full = $schedule->registrations_count >= $schedule->quota;
                $registered = in_array($schedule->id, $registeredScheduleIds, true);
            ?>
            <div class="col-md-6 col-xl-4">
                <div class="card card-soft h-100">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between gap-2 mb-2">
                            <span class="badge text-bg-secondary"><?php echo e($schedule->practicum->code); ?></span>
                            <span class="badge text-bg-<?php echo e($full ? 'danger' : 'success'); ?>"><?php echo e($schedule->registrations_count); ?>/<?php echo e($schedule->quota); ?></span>
                        </div>
                        <h5 class="fw-bold"><?php echo e($schedule->practicum->name); ?></h5>
                        <div class="small text-secondary mb-3"><?php echo e($schedule->academic_year); ?> - <?php echo e($schedule->term); ?></div>
                        <dl class="row small mb-4">
                            <dt class="col-4">Labor</dt><dd class="col-8"><?php echo e($schedule->laboratory->name); ?></dd>
                            <dt class="col-4">Jadwal</dt><dd class="col-8"><?php echo e($schedule->day); ?>, <?php echo e(substr($schedule->start_time,0,5)); ?>-<?php echo e(substr($schedule->end_time,0,5)); ?></dd>
                            <dt class="col-4">Ruang</dt><dd class="col-8"><?php echo e($schedule->room ?? '-'); ?></dd>
                            <dt class="col-4">Dosen</dt><dd class="col-8"><?php echo e($schedule->lecturer?->name ?? 'Belum ditentukan'); ?></dd>
                        </dl>
                        <div class="mt-auto">
                            <?php if($registered): ?>
                                <button class="btn btn-success w-100" disabled>Sudah Dipilih</button>
                            <?php elseif($full): ?>
                                <button class="btn btn-secondary w-100" disabled>Kuota Penuh</button>
                            <?php else: ?>
                                <form method="POST" action="<?php echo e(route('mahasiswa.register', $schedule)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-primary w-100">Pilih Jadwal Ini</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12"><div class="alert alert-info">Belum ada jadwal praktikum aktif.</div></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/mahasiswa/schedules.blade.php ENDPATH**/ ?>