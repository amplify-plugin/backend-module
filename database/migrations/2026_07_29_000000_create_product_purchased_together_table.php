<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_purchased_together', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id_a')->constrained('products', 'id', 'fk_pbt_product_a')->cascadeOnDelete();
            $table->foreignId('product_id_b')->constrained('products', 'id', 'fk_pbt_product_b')->cascadeOnDelete();
            $table->unsignedInteger('occurrence_count')->default(1);
            $table->timestamps();

            $table->unique(['product_id_a', 'product_id_b'], 'uq_product_pairs');
        });

        DB::statement('ALTER TABLE product_purchased_together ADD INDEX idx_product_a_count (product_id_a, occurrence_count DESC)');
        DB::statement('ALTER TABLE product_purchased_together ADD INDEX idx_product_b_count (product_id_b, occurrence_count DESC)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_purchased_together');
    }
};
