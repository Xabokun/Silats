<?php $__env->startSection('title', 'Pengurusan Surat'); ?>
<?php $__env->startSection('page_heading', 'Pengurusan Surat'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Pengurusan Surat</h2>
            <p class="text-secondary mb-0">Pantau posisi workflow, dokumen draft, dan surat resmi yang telah diterbitkan.</p>
        </div>
        <a class="btn btn-primary" href="<?php echo e(route('surat.create')); ?>">+ Ajukan Surat</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-secondary text-uppercase fw-semibold">Total Permohonan</div>
                    <div class="display-6 fw-bold mt-2"><?php echo e($requests->count()); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-secondary text-uppercase fw-semibold">Dalam Proses</div>
                    <div class="display-6 fw-bold mt-2"><?php echo e($requests->where('status', 'in_process')->count()); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-secondary text-uppercase fw-semibold">Selesai</div>
                    <div class="display-6 fw-bold mt-2"><?php echo e($requests->where('status', 'completed')->count()); ?></div>
                </div>
            </div>
        </div>
    </div>

    <?php if(auth()->user()->isRole('admin', 'prodi')): ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-1">Surat Menunggu Persetujuan</h5>
                        <p class="text-secondary mb-0">Daftar semua pengajuan surat yang masih menunggu approval di tahap aktif.</p>
                    </div>
                    <span class="badge text-bg-warning"><?php echo e($pendingLetters->count()); ?> menunggu</span>
                </div>

                <?php if($pendingLetters->isEmpty()): ?>
                    <div class="text-secondary">Tidak ada surat yang menunggu persetujuan saat ini.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nomor</th>
                                    <th>Jenis Surat</th>
                                    <th>Pemohon</th>
                                    <th>Tahap Saat Ini</th>
                                    <th>Role Penanggung Jawab</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $pendingLetters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $step = $letter->letterType->workflowSteps->firstWhere('step_order', $letter->current_step_order);
                                        $roleLabel = [
                                            'admin' => 'Admin',
                                            'mahasiswa' => 'Mahasiswa',
                                            'dosen' => 'Dosen',
                                            'tenaga_labor' => 'Tenaga Labor',
                                            'kepala_labor' => 'Kepala Labor',
                                            'prodi' => 'Ka/Sekretaris Program Studi',
                                            'umum' => 'Umum',
                                        ][$step?->role ?? 'admin'];
                                    ?>
                                    <tr>
                                        <td class="fw-semibold"><?php echo e($letter->request_number); ?></td>
                                        <td><?php echo e($letter->letterType->title); ?></td>
                                        <td><?php echo e($letter->applicant->name); ?></td>
                                        <td><?php echo e($step?->label ?? '-'); ?></td>
                                        <td><?php echo e($roleLabel); ?></td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-outline-primary" href="<?php echo e(route('surat.show', $letter)); ?>">Lihat</a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Nomor</th>
                        <th>Jenis</th>
                        <th>Pemohon</th>
                        <th>Laboratorium</th>
                        <th>Status</th>
                        <th>Posisi</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $step = $letter->letterType->workflowSteps->firstWhere('step_order', $letter->current_step_order);
                    ?>
                    <tr>
                        <td class="ps-4">
                            <div class="fw-semibold"><?php echo e($letter->official_number ?: $letter->request_number); ?></div>
                            <?php if($letter->official_number): ?><div class="small text-secondary">Ref: <?php echo e($letter->request_number); ?></div><?php endif; ?>
                        </td>
                        <td><?php echo e($letter->letterType->title); ?></td>
                        <td><?php echo e($letter->applicant->name); ?></td>
                        <td><?php echo e($letter->laboratory?->name ?? '-'); ?></td>
                        <td>
                            <span class="badge text-bg-<?php echo e($letter->status === 'completed' ? 'success' : ($letter->status === 'rejected' ? 'danger' : 'warning')); ?>">
                                <?php echo e($letter->status === 'completed' ? 'Selesai' : ($letter->status === 'rejected' ? 'Ditolak' : 'Diproses')); ?>

                            </span>
                        </td>
                        <td><?php echo e($letter->status === 'completed' ? 'Surat resmi terbit' : ($letter->status === 'rejected' ? 'Pengajuan ditolak' : ($step?->label ?? '-'))); ?></td>
                        <td class="text-end text-nowrap pe-4">
                            <a class="btn btn-sm btn-outline-secondary" target="_blank" href="<?php echo e(route('surat.document', $letter)); ?>"><?php echo e($letter->status === 'completed' ? 'Surat' : 'Draft'); ?></a>
                            <a class="btn btn-sm btn-outline-primary" href="<?php echo e(route('surat.show', $letter)); ?>">Tracking</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7" class="text-center py-5 text-secondary">Belum ada pengurusan surat.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/surat/index.blade.php ENDPATH**/ ?>