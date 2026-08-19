<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('testing_services', function (Blueprint $table) { $table->engine = 'InnoDB'; $table->id(); $table->foreignId('testing_category_id')->constrained()->cascadeOnDelete(); $table->foreignId('laboratory_id')->constrained()->restrictOnDelete(); $table->string('code')->unique(); $table->string('name'); $table->text('description')->nullable(); $table->text('requirements')->nullable(); $table->boolean('is_active')->default(true); $table->timestamps(); }); } public function down(): void { Schema::dropIfExists('testing_services'); } };
