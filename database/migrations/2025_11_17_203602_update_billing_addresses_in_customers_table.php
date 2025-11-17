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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('address_1')->nullable()->after('allow_backorder');
            $table->string('address_2')->nullable()->after('address_1');
            $table->string('address_3')->nullable()->after('address_2');
            $table->string('city')->nullable()->after('address_3');
            $table->string('state')->nullable()->after('city');
            $table->string('zip_code')->nullable()->after('state');
            $table->string('country_code')->nullable()->after('zip_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('address_1');
            $table->dropColumn('address_2');
            $table->dropColumn('address_3');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('zip_code');
            $table->dropColumn('country_code');
        });
    }
};
