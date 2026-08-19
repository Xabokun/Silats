<?php $__env->startSection('title', 'Tracking Surat'); ?>
<?php $__env->startSection('page_heading', 'Tracking Surat'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between gap-3 align-items-start mb-4">
        <div>
            <div class="text-secondary small">Nomor Permohonan</div>
            <h2 class="fw-bold mb-1"><?php echo e($letterRequest->request_number); ?></h2>
            <p class="mb-0"><?php echo e($letterRequest->letterType->title); ?> — <?php echo e($letterRequest->subject); ?></p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-primary" target="_blank" href="<?php echo e(route('surat.document', $letterRequest)); ?>">
                <?php echo e($letterRequest->status === 'completed' ? 'Lihat Surat Resmi' : 'Preview Draft'); ?>

            </a>
            <?php if($letterRequest->status === 'completed'): ?>
                <a class="btn btn-primary" target="_blank" href="<?php echo e(route('surat.document', $letterRequest)); ?>#print">Cetak / Simpan PDF</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if($letterRequest->status === 'completed'): ?>
        <div class="alert alert-success d-flex flex-wrap justify-content-between gap-2">
            <span><strong>Surat resmi telah terbit.</strong></span>
            <span>Nomor: <strong><?php echo e($letterRequest->official_number); ?></strong> • <?php echo e(optional($letterRequest->letter_date)->format('d-m-Y')); ?></span>
        </div>
    <?php elseif($letterRequest->status === 'rejected'): ?>
        <div class="alert alert-danger"><strong>Pengajuan ditolak.</strong> Dokumen yang tersedia tetap berstatus draft dan tidak memiliki nomor surat resmi.</div>
    <?php else: ?>
        <div class="alert alert-warning"><strong>Draft tersedia.</strong> Nomor surat resmi baru diterbitkan setelah seluruh tahapan disetujui.</div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5>Alur Surat</h5>
            <div class="row g-2 mt-1">
                <?php $__currentLoopData = $letterRequest->letterType->workflowSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $done = $letterRequest->histories->where('step_order', $step->step_order)->where('action', 'approve')->isNotEmpty();
                        $active = $letterRequest->status === 'in_process' && $letterRequest->current_step_order == $step->step_order;
                    ?>
                    <div class="col-md">
                        <div class="p-3 rounded h-100 <?php echo e($done ? 'bg-success-subtle' : ($active ? 'bg-warning-subtle' : 'bg-light')); ?>">
                            <div class="small">Tahap <?php echo e($step->step_order); ?></div>
                            <strong><?php echo e($done ? '✓ ' : ($active ? '● ' : '○ ')); ?><?php echo e($step->label); ?></strong>
                            <div class="small text-secondary"><?php echo e(str_replace('_', ' ', $step->role)); ?></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5>Data Surat</h5>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <tr><th style="width:35%">Pemohon</th><td><?php echo e($letterRequest->applicant->name); ?></td></tr>
                            <?php if($letterRequest->applicant->npm): ?><tr><th>NPM</th><td><?php echo e($letterRequest->applicant->npm); ?></td></tr><?php endif; ?>
                            <tr><th>Perihal</th><td><?php echo e($letterRequest->subject); ?></td></tr>
                            <tr><th>Laboratorium</th><td><?php echo e($letterRequest->laboratory?->name ?? '-'); ?></td></tr>
                            <?php $__currentLoopData = $letterRequest->fieldValues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr><th><?php echo e($value->label); ?></th><td><?php echo nl2br(e($value->value ?: '-')); ?></td></tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5>Riwayat Surat</h5>
                    <?php $__currentLoopData = $letterRequest->histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border-start border-3 ps-3 mb-3">
                            <strong><?php echo e(ucfirst($history->action)); ?></strong>
                            <?php if($history->step_order): ?> • tahap <?php echo e($history->step_order); ?> <?php endif; ?>
                            <br><span><?php echo e($history->notes); ?></span><br>
                            <small class="text-secondary"><?php echo e($history->actor?->name ?? 'Sistem'); ?> • <?php echo e($history->created_at->format('d M Y H:i')); ?></small>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <h5>Lampiran Persyaratan</h5>
                    <?php $__empty_1 = true; $__currentLoopData = $letterRequest->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a class="d-block mb-2" target="_blank" href="<?php echo e(asset('storage/'.$file->file_path)); ?>"><?php echo e($file->requirement->title); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <span class="text-secondary">Tidak ada lampiran.</span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($letterRequest->status === 'in_process' && $current && $current->role === auth()->user()->role): ?>
                <div class="card border-primary shadow-sm">
                    <div class="card-body p-4">
                        <h5>Proses Tahap Anda</h5>
                        <p class="small text-secondary"><?php echo e($current->label); ?></p>
                        <form method="POST" action="<?php echo e(route('surat.action', $letterRequest)); ?>">
                            <?php echo csrf_field(); ?>
                            <textarea class="form-control mb-3" name="notes" rows="3" placeholder="Catatan verifikasi"></textarea>
                            <div class="d-flex flex-wrap gap-2">
                                <button name="action" value="approve" class="btn btn-success">Setujui & Lanjutkan</button>
                                <button name="action" value="reject" class="btn btn-outline-danger">Tolak</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SILATS_Laravel\resources\views/surat/show.blade.php ENDPATH**/ ?>