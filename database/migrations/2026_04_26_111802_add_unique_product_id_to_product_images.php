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
        Schema::table('product__images', function (Blueprint $table) {
            $table->unique('product_id', 'uq_product_images_product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product__images', function (Blueprint $table) {
            $table->dropUnique('uq_product_images_product_id');
        });
    }
};
