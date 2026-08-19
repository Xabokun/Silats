<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('letter_workflow_steps', function (Blueprint $table) { $table->engine = 'InnoDB'; $table->id(); $table->foreignId('letter_type_id')->constrained()->cascadeOnDelete(); $table->unsignedSmallInteger('step_order'); $table->string('role', 30); $table->string('label'); $table->timestamps(); $table->unique(['letter_type_id','step_order']); }); } public function down(): void { Schema::dropIfExists('letter_workflow_steps'); } };
