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
            $table->string('ship_to_name')->nullable()->after('ship_to_number');
            $table->dropColumn('ship_to_address');
            $table->string('ship_to_address_1')->nullable()->after('ship_to_name');
            $table->string('ship_to_address_2')->nullable()->after('ship_to_address_1');
            $table->string('ship_to_address_3')->nullable()->after('ship_to_address_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //No Rollback
    }
};
