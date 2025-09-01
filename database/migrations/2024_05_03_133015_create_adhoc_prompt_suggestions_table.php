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
        Schema::create('adhoc_prompt_suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_category_id')->constrained('report_categories')->cascadeOnDelete();
            $table->string('prompt')->index();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adhoc_prompt_suggestions');
    }
};
