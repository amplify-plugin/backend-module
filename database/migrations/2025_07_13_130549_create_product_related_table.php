<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('related_product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('product_relationship_type_id')->constrained('product_relationship_types')->cascadeOnDelete();
            $table->timestamps();

            // ensure one relationship only once
            $table->unique(
                ['product_id', 'related_product_id', 'product_relationship_type_id'],
                'unique_product_relationship'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_relationships');
    }
};
