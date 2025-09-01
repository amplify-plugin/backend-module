<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_availabilities', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->after('item_number');
            $table->renameColumn('list_price', 'list_price_1');
            $table->double('list_price_2', 10, 2)->nullable()->after('list_price');
            $table->double('list_price_3', 10, 2)->nullable()->after('list_price_2');
            $table->double('list_price_4', 10, 2)->nullable()->after('list_price_3');
            $table->double('list_price_5', 10, 2)->nullable()->after('list_price_4');
            $table->boolean('suspended')->default(false)->after('list_price_5');
            $table->boolean('allow_backorder')->default(false)->after('suspended');
            $table->string('status')->nullable()->after('suspended');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_availabilities', function (Blueprint $table) {
            $table->dropColumn('product_id');
            $table->renameColumn('list_price_1', 'list_price');
            $table->dropColumn('list_price_2');
            $table->dropColumn('list_price_3');
            $table->dropColumn('list_price_4');
            $table->dropColumn('list_price_5');
            $table->dropColumn('suspended');
            $table->dropColumn('allow_backorder');
            $table->dropColumn('status');
        });
    }
};
