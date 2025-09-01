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
        Schema::table('products', function (Blueprint $table) {
            $table->json('flags')->nullable()->after('id');
            $table->boolean('in_stock')->nullable()->change();
            $table->dropUnique('products_product_code_unique');
            $table->index('product_code', 'products_product_code_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('flags');
            $table->dropIndex('products_product_code_index');
            $table->unique('product_code', 'products_product_code_unique');
        });
    }
};
