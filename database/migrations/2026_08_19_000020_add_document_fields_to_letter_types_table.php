<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('letter_types', function (Blueprint $table) {
            $table->string('default_subject')->nullable()->after('description');
            $table->string('attachment_text')->default('-')->after('default_subject');
            $table->longText('body_template')->nullable()->after('attachment_text');
            $table->string('number_format')->default('{seq}/{code}/{month_roman}/{year}')->after('body_template');
            $table->string('signatory_name')->nullable()->after('number_format');
            $table->string('signatory_position')->nullable()->after('signatory_name');
            $table->string('signatory_identifier')->nullable()->after('signatory_position');
        });
    }

    public function down(): void
    {
        Schema::table('letter_types', function (Blueprint $table) {
            $table->dropColumn([
                'default_subject', 'attachment_text', 'body_template', 'number_format',
                'signatory_name', 'signatory_position', 'signatory_identifier',
            ]);
        });
    }
};
