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
        Schema::table('product_availabilities', function (Blueprint $table) {
            $table->decimal('price', 18, 6)->change();
            $table->decimal('list_price_1', 18, 6)->change();
            $table->decimal('list_price_2', 18, 6)->change();
            $table->decimal('list_price_3', 18, 6)->change();
            $table->decimal('list_price_4', 18, 6)->change();
            $table->decimal('list_price_5', 18, 6)->change();
            $table->decimal('standard_price', 18, 6)->change();
            $table->decimal('extended_price', 18, 6)->change();
            $table->decimal('order_price', 18, 6)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_availabilities', function (Blueprint $table) {
            $table->decimal('price', 18, 6)->change();
            $table->decimal('list_price_1', 10, 2)->change();
            $table->decimal('list_price_2', 10, 2)->change();
            $table->decimal('list_price_3', 10, 2)->change();
            $table->decimal('list_price_4', 10, 2)->change();
            $table->decimal('list_price_5', 10, 2)->change();
            $table->decimal('standard_price', 10, 2)->change();
            $table->decimal('extended_price', 10, 2)->change();
            $table->decimal('order_price', 10, 2)->change();
        });
    }
};
