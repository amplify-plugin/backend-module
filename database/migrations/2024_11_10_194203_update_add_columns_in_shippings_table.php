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
        Schema::table('shippings', function (Blueprint $table) {
            $table->string('driver')->nullable();
            $table->string('code');
            $table->text('description')->nullable();
            $table->json('setting')->nullable();
            $table->boolean('enabled')->default(true);
        });

        Schema::table('threshold_ranges', function (Blueprint $table) {
            $table->foreignId('shipping_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shippings', function (Blueprint $table) {
            $table->dropColumn('driver');
            $table->dropColumn('code');
            $table->dropColumn('description');
            $table->dropColumn('setting');
            $table->dropColumn('enabled');
        });

        Schema::table('threshold_ranges', function (Blueprint $table) {
            $table->dropColumn('shipping_id');
        });
    }
};
