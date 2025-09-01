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
        Schema::create('customer_credit_cards', function (Blueprint $table) {
            $table->id();

            $table->string('customer_number');
            $table->string('name');
            $table->string('number');
            $table->string('expiry');
            $table->string('cvc');
            $table->string('customer_email');
            $table->string('billing_address');
            $table->string('zip_code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_credit_cards');
    }
};
