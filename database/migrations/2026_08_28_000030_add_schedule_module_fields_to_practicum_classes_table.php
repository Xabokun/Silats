<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('practicum_classes', function (Blueprint $table) {
            $table->date('practicum_date')->nullable()->after('end_time');
            $table->timestamp('enrollment_deadline')->nullable()->after('practicum_date');
            $table->string('module_path')->nullable()->after('enrollment_deadline');
        });
    }

    public function down(): void
    {
        Schema::table('practicum_classes', function (Blueprint $table) {
            $table->dropColumn(['practicum_date', 'enrollment_deadline', 'module_path']);
        });
    }
};