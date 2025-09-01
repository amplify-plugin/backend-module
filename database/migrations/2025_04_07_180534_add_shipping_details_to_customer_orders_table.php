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
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->string('customer_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('ship_to_address')->nullable();
            $table->string('ship_to_city')->nullable();
            $table->string('ship_to_country_code')->nullable();
            $table->string('ship_to_state')->nullable();
            $table->string('ship_to_zip_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'email',
                'phone',
                'ship_to_address',
                'ship_to_city',
                'ship_to_country_code',
                'ship_to_state',
                'ship_to_zip_code',
            ]);
        });
    }
};
