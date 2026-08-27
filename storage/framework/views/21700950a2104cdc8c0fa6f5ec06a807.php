<?php $__env->startSection('title','Manajemen Akun'); ?>
<?php $__env->startSection('page_heading','Manajemen Akun'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Akun</h2>
            <p class="text-secondary mb-0">Daftar akun pengguna SILATS yang dikelola secara terpusat oleh Admin.</p>
        </div>
        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">+ Buat Akun</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama</th>
                            <th>NPM / NIDN</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Jabatan</th>
                            <th>Laboratorium</th>
                            <th>Periode Jabatan</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4 fw-semibold"><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->npm ?: ($user->nidn ?: '-')); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td><span class="badge text-bg-light border"><?php echo e(ucwords(str_replace('_',' ',$user->role))); ?></span></td>
                            <td><?php echo e($user->position_title ?? '-'); ?></td>
                            <td><?php echo e($user->laboratory?->name ?? '-'); ?></td>
                            <td class="small">
                                <?php if($user->position_start_date || $user->position_end_date): ?>
                                    <?php echo e($user->position_start_date?->format('d/m/Y') ?? '-'); ?>

                                    <br>
                                    <?php if($user->position_end_date): ?>
                                        <span class="<?php echo e($user->position_end_date->isPast() ? 'text-danger' : ''); ?>">
                                            <?php echo e($user->position_end_date->format('d/m/Y')); ?><?php echo e($user->position_end_date->isPast() ? ' (Berakhir)' : ''); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-success">Berjalan</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <?php if($user->id !== auth()->id()): ?>
                                        <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" onsubmit="return confirm('Hapus akun <?php echo e(addslashes($user->name)); ?>? Data terkait akun ini juga dapat ikut terhapus.');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="8" class="text-center text-secondary py-4">Belum ada akun yang terdaftar.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/admin/users.blade.php ENDPATH**/ ?>