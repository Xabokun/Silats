<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::table('practicum_classes', function(Blueprint $table){ $table->boolean('is_verified')->default(false); }); } public function down(): void { Schema::table('practicum_classes', function(Blueprint $table){ $table->dropColumn('is_verified'); }); } };