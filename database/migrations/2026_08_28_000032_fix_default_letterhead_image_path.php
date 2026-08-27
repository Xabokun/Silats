<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('letterhead_settings')
            ->where('header_image_path', 'images/kop-ft-uir.jpg')
            ->update(['header_image_path' => null]);
    }

    public function down(): void
    {
        DB::table('letterhead_settings')
            ->whereNull('header_image_path')
            ->update(['header_image_path' => 'images/kop-ft-uir.jpg']);
    }
};