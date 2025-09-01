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
        Schema::create('saved_dynamic_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_category_id')->constrained('report_categories')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('prompt')->index();
            $table->string('report_type')->default('list');
            $table->longText('report');

            $table->string('schedule')->nullable();
            $table->timestamp('last_run')->nullable();
            $table->integer('report_sequence')->nullable();
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_dynamic_reports');
    }
};
