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
            $table->string('image')->nullable()->change();
            $table->string('name')->nullable()->change();
            $table->boolean('has_heading')->default(false);
            $table->boolean('has_content')->default(false);
            $table->string('background_type')->nullable();
            $table->string('foreground_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_sliders', function (Blueprint $table) {
            //

        });
    }
};
