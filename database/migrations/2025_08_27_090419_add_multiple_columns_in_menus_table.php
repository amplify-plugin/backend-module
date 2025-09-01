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
        Schema::table('menus', function (Blueprint $table) {
            $table->string('seo_path')->nullable();
            $table->integer('sub_category_depth')->default(0);
            $table->boolean('display_product_count')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('seo_path');
            $table->dropColumn('sub_category_depth');
            $table->dropColumn('display_product_count');
        });
    }
};
