<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('letter_requirement_submissions', function (Blueprint $table) { $table->id(); $table->foreignId('letter_request_id')->constrained()->cascadeOnDelete(); $table->foreignId('letter_requirement_id')->constrained()->cascadeOnDelete(); $table->string('file_path'); $table->timestamps(); $table->unique(['letter_request_id','letter_requirement_id'], 'lrs_request_requirement_unique'); }); } public function down(): void { Schema::dropIfExists('letter_requirement_submissions'); } };
