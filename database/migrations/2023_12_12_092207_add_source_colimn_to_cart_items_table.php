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
        Schema::table('cart_items', function (Blueprint $table) {
            $table->string('source_type')->nullable()->after('product_image');
            $table->string('source')->nullable()->after('source_type');
            $table->string('expiry_date')->nullable()->after('source');
            $table->string('additional_info')->nullable()->after('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('source_type');
            $table->dropColumn('source');
            $table->dropColumn('expiry_date');
            $table->dropColumn('additional_info');
        });
    }
};
