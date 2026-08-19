<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requirement_submissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->unsignedBigInteger('registration_id');
            $table->unsignedBigInteger('requirement_id');
            $table->string('file_path');
            $table->string('status', 20)->default('pending');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->foreign('registration_id')
                ->references('id')->on('practicum_registrations')
                ->cascadeOnDelete();

            $table->foreign('requirement_id')
                ->references('id')->on('practicum_requirements')
                ->cascadeOnDelete();

            $table->foreign('verified_by')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->unique(['registration_id', 'requirement_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requirement_submissions');
    }
};
