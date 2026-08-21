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
        'prodi'=>'Ka/Sekretaris Program Studi',
        'umum'=>'Masyarakat'
    ];
?>

<?php if(auth()->guard()->guest()): ?>
    <nav class="navbar navbar-dark navbar-silats shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="<?php echo e(route('home')); ?>">
                <span class="brand-mark">S</span><span>SILATS</span>
            </a>
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
<?php endif; ?>

<?php if(auth()->guard()->check()): ?>
<div class="silats-shell">
    <aside class="silats-sidebar" id="silatsSidebar">
        <div class="sidebar-brand">
            <a class="d-flex align-items-center gap-2 text-decoration-none text-white fw-bold" href="<?php echo e(route('dashboard')); ?>">
                <span class="brand-mark">S</span>
                <span>
                    <span class="d-block">SILATS</span>
                    <small class="sidebar-brand-subtitle">Teknik Sipil</small>
                </span>
            </a>
            <button type="button" class="btn-close btn-close-white d-lg-none" id="sidebarClose" aria-label="Tutup menu"></button>
        </div>

        <div class="sidebar-profile">
            <div class="sidebar-avatar"><?php echo e(strtoupper(substr(auth()->user()->name,0,1))); ?></div>
            <div class="min-w-0">
                <div class="fw-semibold text-white sidebar-profile-name"><?php echo e(auth()->user()->name); ?></div>
                <small><?php echo e($roleLabels[auth()->user()->role]??auth()->user()->role); ?></small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <?php if(auth()->user()->isRole('admin')): ?>
                <div class="sidebar-section-title">ADMINISTRASI</div>
                <a class="sidebar-link <?php echo e(request()->routeIs('admin.dashboard')?'active':''); ?>" href="<?php echo e(route('admin.dashboard')); ?>"><span class="sidebar-dot"></span>Dashboard</a>
                <a class="sidebar-link <?php echo e(request()->routeIs('admin.users*')?'active':''); ?>" href="<?php echo e(route('admin.users')); ?>"><span class="sidebar-dot"></span>Manajemen Akun</a>
                <a class="sidebar-link <?php echo e(request()->routeIs('admin.classes*')?'active':''); ?>" href="<?php echo e(route('admin.classes')); ?>"><span class="sidebar-dot"></span>Jadwal & Kelas</a>
                <a class="sidebar-link <?php echo e(request()->routeIs('admin.class-types*')?'active':''); ?>" href="<?php echo e(route('admin.class-types')); ?>"><span class="sidebar-dot"></span>Master Tipe Kelas</a>
                <a class="sidebar-link <?php echo e(request()->routeIs('admin.registrations*')?'active':''); ?>" href="<?php echo e(route('admin.registrations')); ?>"><span class="sidebar-dot"></span>Verifikasi Praktikum</a>
                <a class="sidebar-link <?php echo e(request()->routeIs('admin.letter-types*')?'active':''); ?>" href="<?php echo e(route('admin.letter-types')); ?>"><span class="sidebar-dot"></span>Manajemen Surat</a>
                <a class="sidebar-link <?php echo e(request()->routeIs('admin.letter-settings*')?'active':''); ?>" href="<?php echo e(route('admin.letter-settings')); ?>"><span class="sidebar-dot"></span>Pengaturan Kop Surat</a>
                <a class="sidebar-link <?php echo e(request()->routeIs('admin.services*')||request()->routeIs('admin.categories*')?'active':''); ?>" href="<?php echo e(route('admin.services')); ?>"><span class="sidebar-dot"></span>Jenis Pengujian</a>
            <?php elseif(auth()->user()->isRole('mahasiswa')): ?>
                <div class="sidebar-section-title">PRAKTIKUM</div>
                <a class="sidebar-link <?php echo e(request()->routeIs('mahasiswa.dashboard')?'active':''); ?>" href="<?php echo e(route('mahasiswa.dashboard')); ?>"><span class="sidebar-dot"></span>Praktikum Saya</a>
                <a class="sidebar-link <?php echo e(request()->routeIs('mahasiswa.practicums')||request()->routeIs('mahasiswa.apply')?'active':''); ?>" href="<?php echo e(route('mahasiswa.practicums')); ?>"><span class="sidebar-dot"></span>Daftar Praktikum</a>
            <?php elseif(auth()->user()->isRole('dosen')): ?>
                <div class="sidebar-section-title">PENGAJARAN</div>
                <a class="sidebar-link <?php echo e(request()->routeIs('dosen.*')?'active':''); ?>" href="<?php echo e(route('dosen.dashboard')); ?>"><span class="sidebar-dot"></span>Mata Kuliah Saya</a>
            <?php elseif(auth()->user()->isRole('tenaga_labor')): ?>
                <div class="sidebar-section-title">LABORATORIUM</div>
                <a class="sidebar-link <?php echo e(request()->routeIs('tenaga-labor.*')?'active':''); ?>" href="<?php echo e(route('tenaga-labor.dashboard')); ?>"><span class="sidebar-dot"></span>Pengujian Lab</a>
            <?php elseif(auth()->user()->isRole('kepala_labor')): ?>
                <div class="sidebar-section-title">LABORATORIUM</div>
                <a class="sidebar-link <?php echo e(request()->routeIs('kepala-labor.*')?'active':''); ?>" href="<?php echo e(route('kepala-labor.dashboard')); ?>"><span class="sidebar-dot"></span>Aktivitas Lab</a>
            <?php elseif(auth()->user()->isRole('prodi')): ?>
                <div class="sidebar-section-title">MONITORING PRODI</div>
                <a class="sidebar-link <?php echo e(request()->routeIs('prodi.dashboard')?'active':''); ?>" href="<?php echo e(route('prodi.dashboard')); ?>"><span class="sidebar-dot"></span>Monitoring Semua Lab</a>
                <a class="sidebar-link <?php echo e(request()->routeIs('prodi.classes')?'active':''); ?>" href="<?php echo e(route('prodi.classes')); ?>"><span class="sidebar-dot"></span>Semua Kelas Praktikum</a>
            <?php elseif(auth()->user()->isRole('umum')): ?>
                <div class="sidebar-section-title">PENGUJIAN</div>
                <a class="sidebar-link <?php echo e(request()->routeIs('umum.dashboard')||request()->routeIs('umum.tests.show')?'active':''); ?>" href="<?php echo e(route('umum.dashboard')); ?>"><span class="sidebar-dot"></span>Pengujian Saya</a>
                <a class="sidebar-link <?php echo e(request()->routeIs('umum.tests.create')?'active':''); ?>" href="<?php echo e(route('umum.tests.create')); ?>"><span class="sidebar-dot"></span>Ajukan Pengujian</a>
            <?php endif; ?>

            <div class="sidebar-section-title mt-3">PERSURATAN</div>
            <a class="sidebar-link <?php echo e(request()->routeIs('surat.*')?'active':''); ?>" href="<?php echo e(route('surat.index')); ?>"><span class="sidebar-dot"></span>Pengurusan Surat</a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="btn btn-sidebar-logout w-100">Keluar</button>
            </form>
        </div>
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="silats-main">
        <header class="silats-topbar">
            <button type="button" class="btn btn-outline-secondary d-lg-none" id="sidebarOpen" aria-label="Buka menu">☰</button>
            <div>
                <div class="small text-secondary">Sistem Informasi Laboratorium Teknik Sipil</div>
                <strong><?php echo $__env->yieldContent('page_heading', $roleLabels[auth()->user()->role]??auth()->user()->role); ?></strong>
            </div>
            <span class="badge text-bg-light border ms-auto d-none d-sm-inline"><?php echo e($roleLabels[auth()->user()->role]??auth()->user()->role); ?></span>
        </header>

        <main class="silats-content">
            <?php if(session('success')||session('error')||$errors->any()): ?>
                <div class="pb-3">
                    <?php if(session('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?>
                    <?php if(session('error')): ?><div class="alert alert-danger"><?php echo e(session('error')); ?></div><?php endif; ?>
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger"><strong>Periksa data:</strong><ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <footer class="silats-footer">
            <span>&copy; <?php echo e(date('Y')); ?> SILATS</span>
            <span>Praktikum • Pengujian • Persuratan</span>
        </footer>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<?php if(auth()->guard()->check()): ?>
<script>
(function () {
    const sidebar = document.getElementById('silatsSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const open = document.getElementById('sidebarOpen');
    const close = document.getElementById('sidebarClose');

    function showSidebar() {
        sidebar?.classList.add('show');
        overlay?.classList.add('show');
        document.body.classList.add('sidebar-mobile-open');
    }
    function hideSidebar() {
        sidebar?.classList.remove('show');
        overlay?.classList.remove('show');
        document.body.classList.remove('sidebar-mobile-open');
    }

    open?.addEventListener('click', showSidebar);
    close?.addEventListener('click', hideSidebar);
    overlay?.addEventListener('click', hideSidebar);
    document.querySelectorAll('.sidebar-link').forEach(link => link.addEventListener('click', () => {
        if (window.innerWidth < 992) hideSidebar();
    }));
})();
</script>
<?php endif; ?>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>