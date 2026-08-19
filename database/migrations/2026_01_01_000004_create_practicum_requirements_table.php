<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('practicum_requirements', function (Blueprint $table) { $table->engine = 'InnoDB'; $table->id(); $table->foreignId('course_id')->constrained()->cascadeOnDelete(); $table->string('title'); $table->text('description')->nullable(); $table->boolean('is_required')->default(true); $table->timestamps(); }); } public function down(): void { Schema::dropIfExists('practicum_requirements'); } };
