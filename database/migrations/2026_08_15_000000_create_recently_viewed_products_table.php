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
        Schema::create('recently_viewed_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('contact_id')->constrained('contacts')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->timestamp('last_viewed_at');
            $table->timestamps();

            $table->unique(['contact_id', 'product_id'], 'uq_recently_viewed_contact_product');
            $table->index(['contact_id', 'last_viewed_at'], 'idx_recently_viewed_contact_viewed_at');
            $table->index(['customer_id', 'contact_id', 'last_viewed_at'], 'idx_recently_viewed_customer_contact_viewed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recently_viewed_products');
    }
};
