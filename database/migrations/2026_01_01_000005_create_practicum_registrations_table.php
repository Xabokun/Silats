<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('practicum_registrations', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('practicum_class_id');
            $table->unsignedBigInteger('final_class_id')->nullable();
            $table->string('status', 30)->default('pending_verification');
            $table->text('admin_note')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->foreign('student_id')
                ->references('id')->on('users')
                ->cascadeOnDelete();

            $table->foreign('practicum_class_id')
                ->references('id')->on('practicum_classes')
                ->restrictOnDelete();

            $table->foreign('final_class_id')
                ->references('id')->on('practicum_classes')
                ->nullOnDelete();

            $table->foreign('verified_by')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->unique(['student_id', 'practicum_class_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('practicum_registrations');
    }
};
