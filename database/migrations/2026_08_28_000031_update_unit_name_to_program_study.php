<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('letterhead_settings')
            ->where('faculty_name', 'FAKULTAS TEKNIK SIPIL')
            ->update(['faculty_name' => 'PROGRAM STUDI TEKNIK SIPIL']);
    }

    public function down(): void
    {
        DB::table('letterhead_settings')
            ->where('faculty_name', 'PROGRAM STUDI TEKNIK SIPIL')
            ->update(['faculty_name' => 'FAKULTAS TEKNIK SIPIL']);
    }
};