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
        Schema::table('carts', function (Blueprint $table) {
            $table->index('contact_id', 'carts_contact_id_index');
            $table->index('session_id', 'carts_session_id_index');
            $table->index('status', 'carts_status_index');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->index('customer_code', 'customers_customer_code_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropIndex('carts_contact_id_index');
            $table->dropIndex('carts_session_id_index');
            $table->dropIndex('carts_status_index');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex('customers_customer_code_index');
        });
    }
};
