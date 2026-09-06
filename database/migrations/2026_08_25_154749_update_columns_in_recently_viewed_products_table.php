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
        Schema::table('recently_viewed_products', function (Blueprint $table) {
            $table->renameColumn('last_viewed_at', 'viewed_at')->change();
            $table->string('session')->after('product_id')->nullable()->index();
            $table->integer('repeat')->default(1)->after('session');
        });

        Schema::table('recently_viewed_products', function (Blueprint $table) {
            $table->dateTime('add_to_cart_at')->nullable()->after('viewed_at');
            $table->dateTime('rfq_at')->nullable()->after('add_to_cart_at');
            $table->dateTime('ordered_at')->nullable()->after('rfq_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recently_viewed_products', function (Blueprint $table) {
            $table->renameColumn('viewed_at', 'last_viewed_at')->change();
            $table->removeColumn('session');
            $table->removeColumn('repeat');
            $table->removeColumn('add_to_cart_at');
            $table->removeColumn('rfq_at');
            $table->removeColumn('ordered_at');
        });
    }
};
