<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('letter_requests', function (Blueprint $table) { $table->id(); $table->string('request_number')->unique(); $table->foreignId('letter_type_id')->constrained()->restrictOnDelete(); $table->foreignId('applicant_id')->constrained('users')->cascadeOnDelete(); $table->foreignId('laboratory_id')->nullable()->constrained()->nullOnDelete(); $table->string('subject'); $table->text('notes')->nullable(); $table->string('status', 30)->default('in_process'); $table->unsignedSmallInteger('current_step_order')->default(1); $table->timestamp('completed_at')->nullable(); $table->timestamps(); }); } public function down(): void { Schema::dropIfExists('letter_requests'); } };
