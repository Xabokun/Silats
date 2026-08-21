<?php $__env->startSection('title', 'Pengaturan Kop Surat'); ?>
<?php $__env->startSection('page_heading', 'Pengaturan Kop Surat'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <div class="row g-4">
        <div class="col-xl-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="mb-1">Kop Surat Resmi</h3>
                    <p class="text-secondary">SILATS menggunakan kop Fakultas Teknik sesuai contoh UIR yang Anda berikan. Anda dapat mengganti gambar kop dari sini.</p>

                    <form method="POST" enctype="multipart/form-data" action="<?php echo e(route('admin.letter-settings.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Gambar Kop Surat Lengkap</label>
                            <input type="file" class="form-control" name="kop_image" accept=".png,.jpg,.jpeg">
                            <div class="form-text">Gunakan gambar kop lengkap (logo, nama universitas/fakultas, dan baris alamat). Maksimal 4 MB.</div>
                        </div>
                        <?php if($settings->header_image_path || file_exists(public_path('images/kop-ft-uir.jpg'))): ?>
                            <div class="border rounded-3 p-2 bg-light mb-4">
                                <img src="<?php echo e($settings->header_image_path ? asset('storage/'.$settings->header_image_path) : asset('images/kop-ft-uir.jpg')); ?>" alt="Kop Surat" class="img-fluid" style="width:100%; max-height:190px; object-fit:contain; object-position:left center;">
                            </div>
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Nama Universitas / Institusi</label><input class="form-control" name="institution_name" required value="<?php echo e(old('institution_name', $settings->institution_name ?: 'UNIVERSITAS ISLAM RIAU')); ?>"></div>
                            <div class="col-md-6"><label class="form-label">Nama Fakultas</label><input class="form-control" name="faculty_name" required value="<?php echo e(old('faculty_name', $settings->faculty_name ?: 'FAKULTAS TEKNIK')); ?>"></div>
                            <div class="col-md-6"><label class="form-label">Unit / Program Studi / Laboratorium</label><input class="form-control" name="unit_name" value="<?php echo e(old('unit_name', $settings->unit_name)); ?>"></div>
                            <div class="col-md-6"><label class="form-label">Kota Penerbitan</label><input class="form-control" name="city" required value="<?php echo e(old('city', $settings->city ?: 'Pekanbaru')); ?>"></div>
                            <div class="col-12"><label class="form-label">Alamat</label><textarea class="form-control" rows="2" name="address"><?php echo e(old('address', $settings->address)); ?></textarea></div>
                            <div class="col-md-4"><label class="form-label">Telepon</label><input class="form-control" name="phone" value="<?php echo e(old('phone', $settings->phone)); ?>"></div>
                            <div class="col-md-4"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="<?php echo e(old('email', $settings->email)); ?>"></div>
                            <div class="col-md-4"><label class="form-label">Website</label><input class="form-control" name="website" value="<?php echo e(old('website', $settings->website)); ?>"></div>
                        </div>
                        <button class="btn btn-primary mt-4">Simpan Pengaturan Kop</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5>Preview Format Surat</h5>
                    <div class="small text-secondary mb-3">Kop ditempatkan di bagian paling atas halaman A4, lalu tanggal Masehi dan Hijriyah ditampilkan dua baris seperti contoh surat UIR.</div>
                    <div class="border rounded-3 p-2 bg-light">
                        <img src="<?php echo e($settings->header_image_path ? asset('storage/'.$settings->header_image_path) : asset('images/kop-ft-uir.jpg')); ?>" class="img-fluid" alt="Preview kop surat">
                    </div>
                    <div class="small text-secondary mt-3">Tanggal contoh: <strong><?php echo e($settings->city ?: 'Pekanbaru'); ?>, <?php echo e(now()->translatedFormat('d F Y')); ?></strong> dan tanggal Hijriyah di baris berikutnya.</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/admin/letter-settings.blade.php ENDPATH**/ ?>