<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('practicum_classes', function (Blueprint $table) { $table->id(); $table->foreignId('course_id')->constrained()->cascadeOnDelete(); $table->foreignId('laboratory_id')->constrained()->restrictOnDelete(); $table->foreignId('lecturer_id')->nullable()->constrained('users')->nullOnDelete(); $table->string('class_name', 20); $table->string('room'); $table->string('day', 20); $table->time('start_time'); $table->time('end_time'); $table->unsignedSmallInteger('capacity')->default(40); $table->string('semester', 20)->default('Ganjil'); $table->string('academic_year', 20)->default('2026/2027'); $table->boolean('is_active')->default(true); $table->timestamps(); }); } public function down(): void { Schema::dropIfExists('practicum_classes'); } };
