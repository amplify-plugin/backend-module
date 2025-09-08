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
        Schema::table('pages', function (Blueprint $table) {
            // Add a generated column that mimics a partial unique index
            $table->string('slug_unique_helper')->after('slug')->storedAs('CASE WHEN deleted_at IS NULL THEN slug ELSE NULL END');

            // Add the unique index on the generated column
            $table->unique('slug_unique_helper', 'idx_unique_slug_not_deleted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropUnique('idx_unique_slug_not_deleted');
            $table->dropColumn('slug_unique_helper');
        });
    }
};
