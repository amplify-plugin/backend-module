<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //Remove entries main column empty
        DB::table('product__images')->whereNull('main')
            ->delete();

        //Remove entries are soft deleted
        DB::table('product__images')->whereNotNull('deleted_at')
            ->delete();

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
