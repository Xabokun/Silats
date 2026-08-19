<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('letter_field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('letter_form_field_id')->nullable()->constrained()->nullOnDelete();
            $table->string('field_key', 80);
            $table->string('label');
            $table->longText('value')->nullable();
            $table->timestamps();
            $table->unique(['letter_request_id', 'field_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letter_field_values');
    }
};
