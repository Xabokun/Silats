<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('letter_form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_type_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('sort_order')->default(1);
            $table->string('field_key', 80);
            $table->string('label');
            $table->string('input_type', 20)->default('text');
            $table->string('placeholder')->nullable();
            $table->boolean('is_required')->default(true);
            $table->timestamps();
            $table->unique(['letter_type_id', 'field_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letter_form_fields');
    }
};
