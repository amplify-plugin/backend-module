<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddWarehouseIdInCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('cart_items', 'warehouse_id')) {
            Schema::table('cart_items', function (Blueprint $table) {
                $table->foreignId('warehouse_id')
                    ->nullable()
                    ->after('product_code')
                    ->index()
                    ->constrained('warehouses');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('cart_items', 'warehouse_id')) {
            Schema::table('cart_items', function (Blueprint $table) {
                $table->dropColumn('warehouse_id');
            });
        }
    }
}
