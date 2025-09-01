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
        Schema::table('mega_menus', function (Blueprint $table) {
            $table->boolean('only_featured_manufacturer')->default(false)->after('html_content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mega_menus', function (Blueprint $table) {
            $table->dropColumn('only_featured_manufacturer');
        });
    }
};
