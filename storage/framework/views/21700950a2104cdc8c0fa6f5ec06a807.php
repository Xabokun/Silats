<?php $__env->startSection('title','Manajemen Akun'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Akun</h2>
            <p class="text-secondary mb-0">Registrasi publik dinonaktifkan. Hanya Admin yang dapat membuat akun SILATS.</p>
        </div>
        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">+ Buat Akun</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light"><tr><th>Nama</th><th>NPM</th><th>Email</th><th>Role</th><th>Laboratorium</th></tr></thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-semibold"><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->npm ?? '-'); ?></td>
                        <td><?php echo e($user->email); ?></td>
                        <td><span class="badge text-bg-light"><?php echo e(ucwords(str_replace('_',' ',$user->role))); ?></span></td>
                        <td><?php echo e($user->laboratory?->name ?? '-'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada akun.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/admin/users.blade.php ENDPATH**/ ?>