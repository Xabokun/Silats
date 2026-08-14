<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('testing_samples', function (Blueprint $table) { $table->id(); $table->foreignId('testing_request_id')->constrained()->cascadeOnDelete(); $table->string('code')->unique(); $table->string('name'); $table->decimal('quantity', 10, 2)->default(1); $table->string('unit', 30)->default('buah'); $table->string('condition')->nullable(); $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete(); $table->timestamp('received_at')->nullable(); $table->text('notes')->nullable(); $table->timestamps(); }); } public function down(): void { Schema::dropIfExists('testing_samples'); } };
