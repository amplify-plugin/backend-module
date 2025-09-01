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
        Schema::table('contacts', function (Blueprint $table) {
            $table->text('assigned_customers')->nullable()->after('login_id');
            $table->foreignId('active_customer_id')->nullable()->after('assigned_customers');
            $table->foreignId('warehouse_id')->nullable()->after('active_customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('assigned_customers');
            $table->dropColumn('active_customer_id');
            $table->dropColumn('warehouse_id');
        });
    }
};
