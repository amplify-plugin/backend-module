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
        if (Schema::hasColumn('products', 'model_code', 'model_name')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('model_code')->change();
                $table->dropColumn('model_name')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('model_code', 40)->nullable();
            $table->text('model_name')->nullable();
        });
    }
};
