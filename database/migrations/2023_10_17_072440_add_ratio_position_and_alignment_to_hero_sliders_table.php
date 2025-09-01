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
        Schema::table('hero_sliders', function (Blueprint $table) {
            $table->string('background_image')->nullable();
            $table->integer('slider_ratio')->nullable();
            $table->string('text_alignment', 10)->nullable();
            $table->string('image_alignment', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_sliders', function (Blueprint $table) {
            $table->dropColumn('background_image');
            $table->dropColumn('slider_ratio');
            $table->dropColumn('text_alignment');
            $table->dropColumn('image_alignment');
        });
    }
};
