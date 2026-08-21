<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('practicum_classes', function (Blueprint $table) {
            $table->foreignId('class_type_id')->nullable()->after('lecturer_id')->constrained('practicum_class_types')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('practicum_classes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('class_type_id');
        });
    }
};
