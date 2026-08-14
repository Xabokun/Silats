<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('practicum_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('practicum_class_id')->constrained('practicum_classes')->restrictOnDelete();
            $table->foreignId('final_class_id')->nullable()->constrained('practicum_classes')->nullOnDelete();
            $table->string('status', 30)->default('pending_verification');
            $table->text('admin_note')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->unique(['student_id', 'practicum_class_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('practicum_registrations');
    }
};
