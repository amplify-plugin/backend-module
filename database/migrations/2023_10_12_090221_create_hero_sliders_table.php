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
        Schema::create('hero_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('content')->nullable();
            $table->string('image');
            $table->boolean('has_button')->default(false);
            $table->string('button_title')->nullable();
            $table->text('button_link')->nullable();
            $table->text('button_style')->nullable();
            $table->string('alignment')->default('left');
            $table->boolean('enabled')->default(true);
            $table->boolean('open_new_tab')->default(true);
            $table->foreignId('parent_id')->nullable();
            $table->unsignedBigInteger('depth')->nullable();
            $table->unsignedBigInteger('lft')->nullable();
            $table->unsignedBigInteger('rgt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_sliders');
    }
};
