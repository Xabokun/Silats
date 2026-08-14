<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->string('letter_number')->nullable();
            $table->string('type', 30)->default('keluar');
            $table->string('subject');
            $table->string('recipient');
            $table->date('letter_date');
            $table->text('body')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('status', 30)->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
