<?php $__env->startSection('title','Manajemen Akun'); ?>
<?php $__env->startSection('page_heading','Manajemen Akun'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Akun</h2>
            <p class="text-secondary mb-0">Hanya Admin yang dapat membuat dan mengubah akun SILATS.</p>
        </div>
        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">+ Buat Akun</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Nama</th><th>NPM / NIDN</th><th>Email</th><th>Role</th><th>Jabatan</th><th>Laboratorium</th><th>Periode</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-semibold"><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->npm ?: ($user->nidn ?: '-')); ?></td>
                        <td><?php echo e($user->email); ?></td>
                        <td><span class="badge text-bg-light"><?php echo e(ucwords(str_replace('_',' ',$user->role))); ?></span></td>
                        <td><?php echo e($user->position_title ?? '-'); ?></td>
                        <td><?php echo e($user->laboratory?->name ?? '-'); ?></td>
                        <td class="small"><?php echo e($user->position_start_date?->format('d/m/Y') ?? '-'); ?><br><?php if($user->position_end_date): ?><span class="<?php echo e($user->position_end_date->isPast() ? 'text-danger' : ''); ?>"><?php echo e($user->position_end_date->format('d/m/Y')); ?><?php echo e($user->position_end_date->isPast() ? ' (Berakhir)' : ''); ?></span><?php else: ?><span>Berjalan</span><?php endif; ?></td>
                        <td><a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-sm btn-outline-primary">Edit</a></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="8" class="text-center text-secondary py-4">Belum ada akun.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/admin/users.blade.php ENDPATH**/ ?>