<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('testing_requests', function (Blueprint $table) { $table->engine = 'InnoDB'; $table->id(); $table->string('request_number')->unique(); $table->foreignId('applicant_id')->constrained('users')->cascadeOnDelete(); $table->foreignId('testing_service_id')->constrained()->restrictOnDelete(); $table->foreignId('assigned_lab_staff_id')->nullable()->constrained('users')->nullOnDelete(); $table->string('status', 30)->default('pending_sample'); $table->string('sample_description'); $table->text('purpose')->nullable(); $table->text('notes')->nullable(); $table->timestamp('submitted_at')->nullable(); $table->timestamp('completed_at')->nullable(); $table->timestamps(); }); } public function down(): void { Schema::dropIfExists('testing_requests'); } };
