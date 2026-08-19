<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nidn', 30)->nullable()->unique()->after('email');
            $table->text('expertise')->nullable()->after('address');
            $table->string('position_title')->nullable()->after('expertise');
            $table->date('position_start_date')->nullable()->after('position_title');
            $table->date('position_end_date')->nullable()->after('position_start_date');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['nidn']);
            $table->dropColumn([
                'nidn', 'expertise', 'position_title', 'position_start_date', 'position_end_date',
            ]);
        });
    }
};
