<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title','SILATS'); ?> | Sistem Informasi Laboratorium Teknik Sipil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/silats.css')); ?>">
    <?php echo $__env->yieldPushContent('head'); ?>
</head>
<body>
<?php
    $roleLabels = [
        'admin'=>'Admin',
        'mahasiswa'=>'Mahasiswa',
        'dosen'=>'Dosen',
        'tenaga_labor'=>'Tenaga Labor',
        'kepala_labor'=>'Kepala Labor',
        'prodi'=>'Program Studi',
        'umum'=>'Masyarakat'
    ];
?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-silats sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="<?php echo e(auth()->check()?route('dashboard'):route('home')); ?>">
            <span class="brand-mark">S</span><span>SILATS</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <?php if(auth()->guard()->guest()): ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('home')); ?>">Beranda</a></li>
                <?php endif; ?>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isRole('admin')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.users')); ?>">Manajemen Akun</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.classes')); ?>">Jadwal & Kelas</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.registrations')); ?>">Verifikasi Praktikum</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.letter-types')); ?>">Manajemen Surat</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('admin.services')); ?>">Jenis Pengujian</a></li>
                    <?php elseif(auth()->user()->isRole('mahasiswa')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('mahasiswa.dashboard')); ?>">Praktikum Saya</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('mahasiswa.practicums')); ?>">Daftar Praktikum</a></li>
                    <?php elseif(auth()->user()->isRole('dosen')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('dosen.dashboard')); ?>">Mata Kuliah Saya</a></li>
                    <?php elseif(auth()->user()->isRole('tenaga_labor')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('tenaga-labor.dashboard')); ?>">Pengujian Lab</a></li>
                    <?php elseif(auth()->user()->isRole('kepala_labor')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('kepala-labor.dashboard')); ?>">Aktivitas Lab</a></li>
                    <?php elseif(auth()->user()->isRole('prodi')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('prodi.dashboard')); ?>">Monitoring Semua Lab</a></li>
                    <?php elseif(auth()->user()->isRole('umum')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('umum.dashboard')); ?>">Pengujian Saya</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('umum.tests.create')); ?>">Ajukan Pengujian</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('surat.index')); ?>">Pengurusan Surat</a></li>
                <?php endif; ?>
            </ul>

            <?php if(auth()->guard()->check()): ?>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge badge-role d-none d-md-inline"><?php echo e($roleLabels[auth()->user()->role]??auth()->user()->role); ?></span>
                    <span class="text-white small d-none d-lg-inline"><?php echo e(auth()->user()->name); ?></span>
                    <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button class="btn btn-outline-light btn-sm">Keluar</button></form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main>
    <?php if(session('success')||session('error')||$errors->any()): ?>
        <div class="container pt-3">
            <?php if(session('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?>
            <?php if(session('error')): ?><div class="alert alert-danger"><?php echo e(session('error')); ?></div><?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger"><strong>Periksa data:</strong><ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <?php echo $__env->yieldContent('content'); ?>
</main>
<footer class="py-4 mt-5 border-top bg-white">
    <div class="container d-flex justify-content-between small text-secondary"><span>&copy; <?php echo e(date('Y')); ?> SILATS</span><span>Praktikum • Pengujian • Persuratan</span></div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>