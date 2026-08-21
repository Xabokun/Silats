

<?php $__env->startSection('title','Jadwal & Kelas'); ?>
<?php $__env->startSection('page_heading','Jadwal & Kelas'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Jadwal & Kelas Praktikum</h2>
            <p class="text-secondary mb-0">Admin mengelola jadwal, ruang, kapasitas, dan penugasan dosen sesuai standar operasional praktikum.</p>
        </div>
        <a class="btn btn-primary align-self-start" href="<?php echo e(route('admin.classes.create')); ?>">+ Tambah Jadwal</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Mata Kuliah</th>
                        <th>Kelas</th>
                        <th>Dosen</th>
                        <th>Lab / Ruangan</th>
                        <th>Jadwal</th>
                        <th>Kapasitas</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="ps-4 fw-semibold"><?php echo e($c->course->name); ?></td>
                            <td><?php echo e($c->class_name); ?></td>
                            <td><?php echo e($c->lecturer?->name ?? '-'); ?></td>
                            <td>
                                <?php echo e($c->laboratory->name); ?>

                                <div class="small text-secondary"><?php echo e($c->room); ?></div>
                            </td>
                            <td><?php echo e($c->day); ?>, <?php echo e(substr($c->start_time,0,5)); ?>–<?php echo e(substr($c->end_time,0,5)); ?></td>
                            <td>
                                <span class="fw-semibold"><?php echo e($c->final_registrations_count); ?>/<?php echo e($c->capacity); ?></span>
                                <div class="small text-secondary"><?php echo e($c->registrations_count); ?> pemilih</div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a class="btn btn-sm btn-outline-primary" href="<?php echo e(route('admin.classes.edit',$c)); ?>">Edit</a>
                                    <form action="<?php echo e(route('admin.classes.destroy', $c)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/admin/classes.blade.php ENDPATH**/ ?>