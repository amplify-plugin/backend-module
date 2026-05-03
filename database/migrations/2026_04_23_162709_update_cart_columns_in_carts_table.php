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
        Schema::table('carts', function (Blueprint $table) {
            $table->decimal('sub_total', 18, 6)->nullable()->change();
            $table->decimal('tax_amount', 18, 6)->nullable()->change();
            $table->decimal('ship_charge', 18, 6)->nullable()->change();
            $table->decimal('total', 18, 6)->nullable()->change();
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->decimal('quantity', 18, 6)->nullable()->change();
            $table->decimal('unitprice', 18, 6)->nullable()->change();
            $table->decimal('subtotal', 18, 6)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
