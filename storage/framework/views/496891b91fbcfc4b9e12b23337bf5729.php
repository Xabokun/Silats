
<?php $__env->startSection('title','Daftar Akun Mahasiswa'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-5"><div class="row justify-content-center"><div class="col-lg-6"><div class="card shadow-sm border-0"><div class="card-body p-4">
	<h3 class="fw-bold">Daftar Akun Mahasiswa</h3>
	<p class="text-secondary">Buat akun untuk mendaftar praktikum. Gunakan email student UIR yang aktif.</p>
	<form method="POST" action="<?php echo e(route('register.store')); ?>"><?php echo csrf_field(); ?>
		<div class="mb-3"><label class="form-label">Nama lengkap</label><input class="form-control" name="name" value="<?php echo e(old('name')); ?>" required autofocus></div>
		<div class="mb-3"><label class="form-label">NPM</label><input class="form-control" name="npm" value="<?php echo e(old('npm')); ?>" required></div>
		<div class="mb-3"><label class="form-label">Email student UIR</label><input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" placeholder="nama@student.uir.ac.id" required><div class="form-text">Wajib menggunakan domain <strong>@student.uir.ac.id</strong>.</div></div>
		<div class="row"><div class="col-md-6 mb-3"><label class="form-label">Password</label><input type="password" class="form-control" name="password" minlength="6" required></div><div class="col-md-6 mb-3"><label class="form-label">Konfirmasi password</label><input type="password" class="form-control" name="password_confirmation" minlength="6" required></div></div>
		<button class="btn btn-primary">Daftar & Masuk</button>
		<a class="btn btn-link" href="<?php echo e(route('login')); ?>">Sudah punya akun?</a>
	</form>
</div></div></div></div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/auth/register.blade.php ENDPATH**/ ?>