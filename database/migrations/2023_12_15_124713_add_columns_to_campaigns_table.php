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
        Schema::table('campaigns', function (Blueprint $table) {
            $table->foreignId('page_id')->nullable()->after('id')->constrained('pages');
            $table->foreignId('banner_zone_id')->nullable()->after('page_id')->constrained('banner_zones');
            $table->string('slug')->after('name');
            $table->string('banner')->nullable()->after('slug');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropConstrainedForeignId('page_id');
            $table->dropConstrainedForeignId('banner_zone_id');
            $table->dropColumn('slug');
            $table->dropColumn('banner');
        });
    }
};
