<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('letterhead_settings', function (Blueprint $table) { $table->engine = 'InnoDB';
            $table->id();
            $table->string('institution_name')->default('UNIVERSITAS CONTOH');
            $table->string('faculty_name')->default('FAKULTAS TEKNIK SIPIL');
            $table->string('unit_name')->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('city')->default('Palu');
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letterhead_settings');
    }
};
