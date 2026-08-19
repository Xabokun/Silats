<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->string('official_number')->nullable()->unique()->after('request_number');
            $table->date('letter_date')->nullable()->after('official_number');
            $table->longText('generated_body')->nullable()->after('notes');
            $table->timestamp('published_at')->nullable()->after('completed_at');
        });
    }

    public function down(): void
    {
        Schema::table('letter_requests', function (Blueprint $table) {
            $table->dropUnique(['official_number']);
            $table->dropColumn(['official_number', 'letter_date', 'generated_body', 'published_at']);
        });
    }
};
