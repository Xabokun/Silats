<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('practicum_registrations', function (Blueprint $table) {
            $table->decimal('final_score', 5, 2)->nullable()->after('status');
            $table->unsignedBigInteger('score_entered_by')->nullable()->after('final_score');
            $table->timestamp('score_entered_at')->nullable()->after('score_entered_by');

            $table->foreign('score_entered_by')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('practicum_registrations', function (Blueprint $table) {
            $table->dropForeign(['score_entered_by']);
            $table->dropColumn(['final_score', 'score_entered_by', 'score_entered_at']);
        });
    }
};