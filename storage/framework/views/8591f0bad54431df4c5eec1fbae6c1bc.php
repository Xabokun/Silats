

<?php $__env->startSection('title','Tipe Kelas'); ?>
<?php $__env->startSection('page_heading','Tipe Kelas'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Master Tipe Kelas</h2>
            <p class="text-secondary mb-0">Admin dapat menambah atau menghapus tipe kelas baru sesuai kebijakan kampus tiap tahun.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Tambah Tipe Kelas Baru</h5>
                    <form method="POST" action="<?php echo e(route('admin.class-types.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Kode</label>
                            <input type="text" class="form-control" name="code" value="<?php echo e(old('code')); ?>" placeholder="contoh: A, B, C" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Tipe Kelas</label>
                            <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" placeholder="contoh: Kelas Reguler" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Opsional"><?php echo e(old('description')); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">+ Simpan Tipe Kelas</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Kode</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $classTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="ps-4 fw-semibold"><?php echo e($type->code); ?></td>
                                        <td><?php echo e($type->name); ?></td>
                                        <td><?php echo e($type->description ?: '-'); ?></td>
                                        <td class="text-end pe-4">
                                            <form action="<?php echo e(route('admin.class-types.destroy', $type)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tipe kelas ini?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-secondary">Belum ada tipe kelas ditambahkan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/admin/class-types.blade.php ENDPATH**/ ?>