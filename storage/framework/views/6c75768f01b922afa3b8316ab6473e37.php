<?php $__env->startSection('title','Jenis Pengujian'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Jenis Pengujian</h2>
            <p class="text-secondary mb-0">Admin dapat menambah kategori dan jenis pengujian tanpa mengubah source code.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5>Tambah Kategori Pengujian</h5>
                    <p class="small text-secondary">Contoh kategori: Beton, Tanah, Air, Aspal.</p>
                    <form method="POST" action="<?php echo e(route('admin.categories.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <input class="form-control mb-2" name="name" placeholder="Contoh: Aspal" required>
                        <textarea class="form-control mb-2" name="description" placeholder="Deskripsi kategori"></textarea>
                        <button class="btn btn-outline-primary">Tambah Kategori</button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <h5>Tambah Jenis Pengujian</h5>
                    <p class="small text-secondary">Jenis pengujian akan langsung tersedia pada layanan yang dapat dipilih pemohon.</p>
                    <form method="POST" action="<?php echo e(route('admin.services.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <label class="form-label">Kategori</label>
                        <select class="form-select mb-2" name="testing_category_id" required>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <label class="form-label">Laboratorium</label>
                        <select class="form-select mb-2" name="laboratory_id" required>
                            <?php $__currentLoopData = $laboratories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($l->id); ?>"><?php echo e($l->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <label class="form-label">Kode Jenis Pengujian</label>
                        <input class="form-control mb-2" name="code" placeholder="Contoh: UJI-BTN-KT" required>

                        <label class="form-label">Nama Jenis Pengujian</label>
                        <input class="form-control mb-2" name="name" placeholder="Contoh: Uji Kuat Tekan Beton" required>

                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control mb-2" name="description" placeholder="Deskripsi pengujian"></textarea>

                        <label class="form-label">Persyaratan Sampel</label>
                        <textarea class="form-control mb-3" name="requirements" placeholder="Contoh: Bawa 3 benda uji silinder beton"></textarea>

                        <button class="btn btn-primary">Tambah Jenis Pengujian</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><h5 class="mb-1"><?php echo e($c->name); ?></h5><p class="text-secondary mb-0"><?php echo e($c->description); ?></p></div>
                            <span class="badge text-bg-light"><?php echo e($c->services->count()); ?> jenis</span>
                        </div>
                        <div class="list-group list-group-flush mt-2">
                            <?php $__empty_2 = true; $__currentLoopData = $c->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <div class="list-group-item px-0">
                                    <strong><?php echo e($s->name); ?></strong><br>
                                    <small class="text-secondary"><?php echo e($s->laboratory->name); ?> • <?php echo e($s->code); ?></small>
                                    <?php if($s->requirements): ?><div class="small mt-1">Syarat: <?php echo e($s->requirements); ?></div><?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <div class="list-group-item px-0 text-secondary">Belum ada jenis pengujian pada kategori ini.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="alert alert-light">Belum ada kategori pengujian.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/admin/services.blade.php ENDPATH**/ ?>