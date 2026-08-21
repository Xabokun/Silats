<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('testing_workflow_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('testing_service_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('step_order');
            $table->string('role');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('testing_workflow_steps');
    }
};
