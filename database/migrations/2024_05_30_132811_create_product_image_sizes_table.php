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
        Schema::create('product_image_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_image_id')->constrained('product__images')->cascadeOnDelete();
            $table->string('type')->nullable()->comment('"primary" or "alternate"');
            $table->string('name')->nullable();
            $table->string('path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_image_sizes');
    }
};
