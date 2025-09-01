<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOrderRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_order_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('order_rule_id')->constrained('order_rules');
            $table->foreignId('customer_id')->constrained('customers');
            $table->boolean('enabled')->default(false);
            $table->text('description')->nullable();
            $table->json('value')->nullable();
            $table->timestamps();
            $table->unique(['order_rule_id', 'customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_order_rules');
    }
}
