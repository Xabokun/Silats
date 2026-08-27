<?php $__env->startSection('title','Beranda'); ?>
<?php $__env->startSection('content'); ?>
<section class="hero-silats py-5">
    <div class="container py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge text-bg-light mb-3">Program Studi Teknik Sipil</span>
                <h1 class="display-5 fw-bold">SILATS</h1>
                <p class="lead">Sistem terpadu untuk pendaftaran praktikum, pengujian material masyarakat, dan pengurusan surat berjenjang.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-light px-4" href="<?php echo e(route('login')); ?>">Login SILATS</a>
                    <a class="btn btn-outline-light px-4" href="<?php echo e(route('register')); ?>">Register Mahasiswa</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow">
                    <div class="card-body p-4 text-dark">
                        <h5 class="fw-bold">Layanan utama</h5>
                        <div class="vstack gap-2">
                            <div>✓ Praktikum & verifikasi kelas</div>
                            <div>✓ Tracking pengujian sampel</div>
                            <div>✓ Workflow surat berjenjang</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container py-5">
    <h2 class="fw-bold mb-4">Layanan Pengujian</h2>
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h4><?php echo e($cat->name); ?></h4>
                        <p class="text-secondary"><?php echo e($cat->description); ?></p>
                        <ul class="mb-0">
                            <?php $__currentLoopData = $cat->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($service->name); ?> <span class="text-secondary">(<?php echo e($service->laboratory->name); ?>)</span></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>Belum ada layanan pengujian.</p>
        <?php endif; ?>
    </div>

    <h2 class="fw-bold mt-5 mb-4">Laboratorium</h2>
    <div class="row g-3">
        <?php $__currentLoopData = $laboratories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4"><div class="p-4 bg-light rounded-3 h-100"><h5><?php echo e($lab->name); ?></h5><p class="mb-0 text-secondary"><?php echo e($lab->description); ?></p></div></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/public/home.blade.php ENDPATH**/ ?>