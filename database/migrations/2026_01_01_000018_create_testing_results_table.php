<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('testing_results', function (Blueprint $table) { $table->id(); $table->foreignId('testing_request_id')->unique()->constrained()->cascadeOnDelete(); $table->string('letter_number')->nullable(); $table->text('result_summary'); $table->string('result_file')->nullable(); $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete(); $table->timestamp('issued_at')->nullable(); $table->timestamps(); }); } public function down(): void { Schema::dropIfExists('testing_results'); } };
