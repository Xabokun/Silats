<?php $__env->startSection('title', $class->exists ? 'Edit Kelas' : 'Tambah Kelas'); ?>
<?php $__env->startSection('content'); ?>
<?php
    $classTypes = App\Models\PracticumClassType::orderBy('name')->get();
?>

<div class="container py-4">
    <div class="row justify-content-center g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4"><?php echo e($class->exists ? 'Edit' : 'Tambah'); ?> Jadwal/Kelas</h3>

                    <form method="POST" action="<?php echo e($class->exists ? route('admin.classes.update', $class) : route('admin.classes.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php if($class->exists): ?>
                            <?php echo method_field('PUT'); ?>
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Mata Kuliah</label>
                                <select class="form-select" name="course_id" required>
                                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $x): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($x->id); ?>" <?php if(old('course_id', $class->course_id) == $x->id): echo 'selected'; endif; ?>><?php echo e($x->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Dosen</label>
                                <select class="form-select" name="lecturer_id">
                                    <option value="">- Belum ditentukan -</option>
                                    <?php $__currentLoopData = $lecturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $x): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($x->id); ?>" <?php if(old('lecturer_id', $class->lecturer_id) == $x->id): echo 'selected'; endif; ?>><?php echo e($x->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Laboratorium</label>
                                <select class="form-select" name="laboratory_id" required>
                                    <?php $__currentLoopData = $laboratories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $x): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($x->id); ?>" <?php if(old('laboratory_id', $class->laboratory_id) == $x->id): echo 'selected'; endif; ?>><?php echo e($x->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Tipe Kelas</label>
                                <select class="form-select" name="class_type_id">
                                    <option value="">- Pilih tipe kelas -</option>
                                    <?php $__currentLoopData = $classTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->id); ?>" <?php if(old('class_type_id', $class->class_type_id) == $type->id): echo 'selected'; endif; ?>><?php echo e($type->name); ?> (<?php echo e($type->code); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Kelas</label>
                                <input class="form-control" name="class_name" value="<?php echo e(old('class_name', $class->class_name)); ?>" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Kapasitas</label>
                                <input type="number" class="form-control" name="capacity" value="<?php echo e(old('capacity', $class->capacity ?: 40)); ?>" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Hari</label>
                                <select class="form-select" name="day" required>
                                    <?php $__currentLoopData = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hari): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($hari); ?>" <?php if(old('day', $class->day) == $hari): echo 'selected'; endif; ?>><?php echo e($hari); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Ruangan</label>
                                <input class="form-control" name="room" value="<?php echo e(old('room', $class->room)); ?>" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Semester</label>
                                <input class="form-control" name="semester" value="<?php echo e(old('semester', $class->semester ?: 'Ganjil')); ?>" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Tahun Akademik</label>
                                <input class="form-control" name="academic_year" value="<?php echo e(old('academic_year', $class->academic_year ?: date('Y').'/'.(date('Y') + 1))); ?>" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Waktu Mulai</label>
                                <input type="time" class="form-control" name="start_time" value="<?php echo e(old('start_time', $class->start_time)); ?>" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Waktu Selesai</label>
                                <input type="time" class="form-control" name="end_time" value="<?php echo e(old('end_time', $class->end_time)); ?>" required>
                            </div>

                            <div class="col-12 d-flex justify-content-between align-items-center mt-3">
                                <a class="btn btn-outline-secondary" href="<?php echo e(route('admin.classes')); ?>">Kembali</a>
                                <button class="btn btn-primary"><?php echo e($class->exists ? 'Simpan Perubahan' : 'Simpan Kelas'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Kelola Mata Kuliah</h5>
                    <form method="POST" action="<?php echo e(route('admin.courses.store')); ?>" class="mb-3">
                        <?php echo csrf_field(); ?>
                        <div class="mb-2">
                            <label class="form-label small">Kode</label>
                            <input class="form-control" name="code" placeholder="contoh: TSP-101" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Nama Mata Kuliah</label>
                            <input class="form-control" name="name" placeholder="contoh: Struktur Beton" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">SKS</label>
                            <input type="number" class="form-control" name="credits" placeholder="3">
                        </div>
                        <button class="btn btn-sm btn-primary w-100">+ Tambah Mata Kuliah</button>
                    </form>

                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center gap-2">
                                <span><?php echo e($course->code); ?> - <?php echo e($course->name); ?></span>
                                <form method="POST" action="<?php echo e(route('admin.courses.destroy', $course)); ?>" onsubmit="return confirm('Hapus mata kuliah ini?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Kelola Laboratorium</h5>
                    <form method="POST" action="<?php echo e(route('admin.laboratories.store')); ?>" class="mb-3">
                        <?php echo csrf_field(); ?>
                        <div class="mb-2">
                            <label class="form-label small">Nama Laboratorium</label>
                            <input class="form-control" name="name" placeholder="contoh: Laboratorium Beton" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Kode</label>
                            <input class="form-control" name="code" placeholder="contoh: LAB-BT">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="2" placeholder="Opsional"></textarea>
                        </div>
                        <button class="btn btn-sm btn-primary w-100">+ Tambah Laboratorium</button>
                    </form>

                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $laboratories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center gap-2">
                                <span><?php echo e($lab->name); ?></span>
                                <form method="POST" action="<?php echo e(route('admin.laboratories.destroy', $lab)); ?>" onsubmit="return confirm('Hapus laboratorium ini?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Kelola Tipe Kelas</h5>
                    <form method="POST" action="<?php echo e(route('admin.class-types.store')); ?>" class="mb-3">
                        <?php echo csrf_field(); ?>
                        <div class="mb-2">
                            <label class="form-label small">Kode</label>
                            <input class="form-control" name="code" placeholder="contoh: A" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Nama Tipe Kelas</label>
                            <input class="form-control" name="name" placeholder="contoh: Kelas Reguler" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Deskripsi</label>
                            <textarea class="form-control" name="description" rows="2" placeholder="Opsional"></textarea>
                        </div>
                        <button class="btn btn-sm btn-primary w-100">+ Tambah Tipe Kelas</button>
                    </form>

                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $classTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center gap-2">
                                <span><?php echo e($type->name); ?> (<?php echo e($type->code); ?>)</span>
                                <form method="POST" action="<?php echo e(route('admin.class-types.destroy', $type)); ?>" onsubmit="return confirm('Hapus tipe kelas ini?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/admin/class-form.blade.php ENDPATH**/ ?>