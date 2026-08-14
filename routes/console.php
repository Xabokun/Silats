<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('silats:info', function () {
    $this->info('SILATS siap digunakan.');
})->purpose('Menampilkan status singkat aplikasi SILATS');
