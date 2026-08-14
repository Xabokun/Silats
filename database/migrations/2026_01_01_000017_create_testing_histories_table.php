<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('testing_histories', function (Blueprint $table) { $table->id(); $table->foreignId('testing_request_id')->constrained()->cascadeOnDelete(); $table->string('status', 30); $table->text('description')->nullable(); $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete(); $table->timestamps(); }); } public function down(): void { Schema::dropIfExists('testing_histories'); } };
