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
            $table->string('source')->after('customer_name')->default('admin');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->string('source')->after('name')->default('admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('source');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('source');
        });
    }
};
