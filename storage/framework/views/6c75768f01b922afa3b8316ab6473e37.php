<?php $__env->startSection('title','Jenis Pengujian'); ?>
<?php $__env->startSection('page_heading','Jenis Pengujian'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Jenis Pengujian</h2>
            <p class="text-secondary mb-0">Admin mengelola kategori, layanan, dan persyaratan pengujian secara terpusat.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="mb-3">Tambah Kategori Pengujian</h5>
                    <p class="small text-secondary">Contoh kategori: Beton, Tanah, Air, Aspal.</p>
                    <form method="POST" action="<?php echo e(route('admin.categories.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <input class="form-control mb-2" name="name" placeholder="Contoh: Aspal" required>
                        <textarea class="form-control mb-2" name="description" placeholder="Deskripsi kategori"></textarea>
                        <button class="btn btn-outline-primary">Tambah Kategori</button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Tambah Jenis Pengujian</h5>
                    <p class="small text-secondary">Layanan pengujian yang tersedia untuk pemohon dan laboratorium.</p>
                    <form method="POST" action="<?php echo e(route('admin.services.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-2">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" name="testing_category_id" required>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Laboratorium</label>
                            <select class="form-select" name="laboratory_id" required>
                                <?php $__currentLoopData = $laboratories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($l->id); ?>"><?php echo e($l->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Kode Jenis Pengujian</label>
                            <input class="form-control" name="code" placeholder="Contoh: UJI-BTN-KT" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Nama Jenis Pengujian</label>
                            <input class="form-control" name="name" placeholder="Contoh: Uji Kuat Tekan Beton" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="description" placeholder="Deskripsi pengujian"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Persyaratan Sampel</label>
                            <textarea class="form-control" name="requirements" placeholder="Contoh: Bawa 3 benda uji silinder beton"></textarea>
                        </div>

                        <button class="btn btn-primary w-100">Tambah Jenis Pengujian</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h5 class="mb-1"><?php echo e($c->name); ?></h5>
                                <p class="text-secondary mb-0"><?php echo e($c->description ?: 'Kategori pengujian belum memiliki deskripsi.'); ?></p>
                            </div>
                            <span class="badge text-bg-light border"><?php echo e($c->services->count()); ?> jenis</span>
                        </div>
                        <div class="list-group list-group-flush">
                            <?php $__empty_2 = true; $__currentLoopData = $c->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <div class="list-group-item px-0 py-3">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div>
                                            <div class="fw-semibold"><?php echo e($s->name); ?></div>
                                            <small class="text-secondary"><?php echo e($s->laboratory->name); ?> • <?php echo e($s->code); ?></small>
                                            <?php if($s->requirements): ?>
                                                <div class="small text-secondary mt-2">Syarat: <?php echo e($s->requirements); ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <span class="badge text-bg-light border"><?php echo e($s->is_active ? 'Aktif' : 'Nonaktif'); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <div class="list-group-item px-0 text-secondary">Belum ada jenis pengujian pada kategori ini.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="alert alert-light border">Belum ada kategori pengujian.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/admin/services.blade.php ENDPATH**/ ?>