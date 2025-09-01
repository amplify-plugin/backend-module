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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->string('line_number')->nullable();
            $table->string('item_number')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('item_type')->nullable();
            $table->string('item_description_1')->nullable();
            $table->string('item_description_2')->nullable();
            $table->integer('quantity_ordered')->nullable();
            $table->integer('quantity_shipped')->nullable();
            $table->integer('quantity_backordered')->nullable();
            $table->string('unit_of_measure')->nullable();
            $table->string('pricing_um')->nullable();
            $table->decimal('actual_sell_price', 10, 2)->nullable();
            $table->string('ship_whse')->nullable();
            $table->decimal('total_line_amount', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
