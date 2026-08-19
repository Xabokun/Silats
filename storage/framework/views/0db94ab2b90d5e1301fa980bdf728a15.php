<?php $__env->startSection('title', 'Pengaturan Kop Surat'); ?>
<?php $__env->startSection('page_heading', 'Pengaturan Kop Surat'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <div class="row g-4">
        <div class="col-xl-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="mb-1">Identitas Kop Surat</h3>
                    <p class="text-secondary">Data ini otomatis digunakan pada semua surat resmi yang diterbitkan SILATS.</p>

                    <form method="POST" enctype="multipart/form-data" action="<?php echo e(route('admin.letter-settings.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label class="form-label">Nama Universitas / Institusi</label>
                            <input class="form-control" name="institution_name" required value="<?php echo e(old('institution_name', $settings->institution_name ?: 'UNIVERSITAS CONTOH')); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Fakultas</label>
                            <input class="form-control" name="faculty_name" required value="<?php echo e(old('faculty_name', $settings->faculty_name ?: 'FAKULTAS TEKNIK SIPIL')); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Unit / Program Studi / Laboratorium</label>
                            <input class="form-control" name="unit_name" value="<?php echo e(old('unit_name', $settings->unit_name)); ?>" placeholder="Contoh: PROGRAM STUDI TEKNIK SIPIL">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" rows="2" name="address"><?php echo e(old('address', $settings->address)); ?></textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Telepon</label><input class="form-control" name="phone" value="<?php echo e(old('phone', $settings->phone)); ?>"></div>
                            <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="<?php echo e(old('email', $settings->email)); ?>"></div>
                            <div class="col-md-6"><label class="form-label">Website</label><input class="form-control" name="website" value="<?php echo e(old('website', $settings->website)); ?>"></div>
                            <div class="col-md-6"><label class="form-label">Kota Penerbitan</label><input class="form-control" name="city" required value="<?php echo e(old('city', $settings->city ?: 'Palu')); ?>"></div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Logo Kop</label>
                            <input type="file" class="form-control" name="logo" accept=".png,.jpg,.jpeg">
                            <div class="form-text">PNG/JPG maksimal 2 MB. Jika tidak diunggah, surat menampilkan placeholder identitas.</div>
                        </div>
                        <button class="btn btn-primary mt-4">Simpan Pengaturan Kop</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <h5>Preview Identitas Kop</h5>
                    <?php if($settings->logo_path): ?>
                        <img src="<?php echo e(asset('storage/'.$settings->logo_path)); ?>" alt="Logo" style="max-height:90px" class="my-3">
                    <?php else: ?>
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle border my-3" style="width:80px;height:80px;font-weight:700">FTS</div>
                    <?php endif; ?>
                    <div class="fw-bold fs-5"><?php echo e($settings->institution_name ?: 'UNIVERSITAS CONTOH'); ?></div>
                    <div class="fw-bold"><?php echo e($settings->faculty_name ?: 'FAKULTAS TEKNIK SIPIL'); ?></div>
                    <?php if($settings->unit_name): ?><div><?php echo e($settings->unit_name); ?></div><?php endif; ?>
                    <div class="small text-secondary mt-2"><?php echo e($settings->address); ?></div>
                    <div class="small text-secondary"><?php echo e(collect([$settings->phone, $settings->email, $settings->website])->filter()->join(' • ')); ?></div>
                    <hr class="border-2 border-dark opacity-100">
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/admin/letter-settings.blade.php ENDPATH**/ ?>