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
            if (Schema::hasColumn('recently_viewed_products', 'last_viewed_at')
                && ! Schema::hasColumn('recently_viewed_products', 'viewed_at')) {
                $table->renameColumn('last_viewed_at', 'viewed_at');
            }
        });

        Schema::table('recently_viewed_products', function (Blueprint $table) {
            if (! Schema::hasColumn('recently_viewed_products', 'session')) {
                $table->string('session')->nullable()->after('product_id')->index();
            }

            if (! Schema::hasColumn('recently_viewed_products', 'repeat')) {
                $table->unsignedInteger('repeat')->default(1)->after('session');
            }

            if (! Schema::hasColumn('recently_viewed_products', 'add_to_cart_at')) {
                $table->dateTime('add_to_cart_at')->nullable()->after('viewed_at');
            }

            if (! Schema::hasColumn('recently_viewed_products', 'rfq_at')) {
                $table->dateTime('rfq_at')->nullable()->after('add_to_cart_at');
            }

            if (! Schema::hasColumn('recently_viewed_products', 'ordered_at')) {
                $table->dateTime('ordered_at')->nullable()->after('rfq_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recently_viewed_products', function (Blueprint $table) {
            if (Schema::hasColumn('recently_viewed_products', 'session')) {
                $table->dropColumn('session');
            }

            if (Schema::hasColumn('recently_viewed_products', 'repeat')) {
                $table->dropColumn('repeat');
            }

            if (Schema::hasColumn('recently_viewed_products', 'add_to_cart_at')) {
                $table->dropColumn('add_to_cart_at');
            }

            if (Schema::hasColumn('recently_viewed_products', 'rfq_at')) {
                $table->dropColumn('rfq_at');
            }

            if (Schema::hasColumn('recently_viewed_products', 'ordered_at')) {
                $table->dropColumn('ordered_at');
            }
        });

        Schema::table('recently_viewed_products', function (Blueprint $table) {
            if (Schema::hasColumn('recently_viewed_products', 'viewed_at')
                && ! Schema::hasColumn('recently_viewed_products', 'last_viewed_at')) {
                $table->renameColumn('viewed_at', 'last_viewed_at');
            }
        });
    }
};
