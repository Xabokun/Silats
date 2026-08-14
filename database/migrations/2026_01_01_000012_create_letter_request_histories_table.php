<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('letter_request_histories', function (Blueprint $table) { $table->id(); $table->foreignId('letter_request_id')->constrained()->cascadeOnDelete(); $table->unsignedSmallInteger('step_order')->nullable(); $table->string('action', 30); $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete(); $table->string('actor_role', 30)->nullable(); $table->text('notes')->nullable(); $table->timestamps(); }); } public function down(): void { Schema::dropIfExists('letter_request_histories'); } };
