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
        Schema::create('product_image_files', function (Blueprint $table) {
            $table->id();

            // product code parsed from filename
            $table->string('code')->index();

            // relative path inside disk
            $table->string('path', 512)->unique();

            // main or additional
            $table->enum('kind', ['main', 'additional'])->index();

            // variant (optional)
            $table->string('variant', 10)->nullable();

            // file size in bytes
            $table->unsignedBigInteger('size')->nullable();

            // last modified time (unix timestamp)
            $table->unsignedBigInteger('mtime')->nullable();

            $table->timestamps();

            // composite index
            $table->index(['code', 'kind']);

            // optional stricter dedupe
            // $table->unique(['code', 'kind', 'path'], 'uq_code_kind_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_image_files');
    }
};