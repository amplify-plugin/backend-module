<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('adhoc_prompt_suggestions', function (Blueprint $table) {
            $table->foreignId('report_category_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adhoc_prompt_suggestions', function (Blueprint $table) {
            $table->dropColumn('report_category_id');
        });
    }
};
