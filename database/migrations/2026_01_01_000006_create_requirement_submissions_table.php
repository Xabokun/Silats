<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('requirement_submissions', function (Blueprint $table) { $table->id(); $table->foreignId('registration_id')->constrained('practicum_registrations')->cascadeOnDelete(); $table->foreignId('requirement_id')->constrained('practicum_requirements')->cascadeOnDelete(); $table->string('file_path'); $table->string('status', 20)->default('pending'); $table->text('note')->nullable(); $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete(); $table->timestamp('verified_at')->nullable(); $table->timestamps(); $table->unique(['registration_id','requirement_id']); }); } public function down(): void { Schema::dropIfExists('requirement_submissions'); } };
