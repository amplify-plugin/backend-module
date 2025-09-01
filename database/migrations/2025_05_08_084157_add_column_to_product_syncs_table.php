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
        Schema::table('product_syncs', function (Blueprint $table) {
            $table->string('standard_part_number')->nullable()->after('primary_vendor')->default(null);
            $table->string('brand')->nullable()->after('standard_part_number')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_syncs', function (Blueprint $table) {
            $table->dropColumn('standard_part_number');
            $table->dropColumn('brand');
        });
    }
};
