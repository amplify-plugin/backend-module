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
        if (Schema::hasColumn('contacts', 'assigned_customers')) {
            Schema::dropColumns('contacts', 'assigned_customers');
        }

        Schema::create('contact_logins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id');
            $table->foreignId('customer_id');
            $table->foreignId('warehouse_id')->nullable();
            $table->foreignId('customer_address_id')->nullable();
            $table->string('ship_to_name')->nullable();
            $table->timestamp('last_logged_in')->nullable();
            $table->timestamp('last_logged_out')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('contacts', 'assigned_customers')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->text('assigned_customers')->nullable()->after('login_id');
            });
        }

        Schema::dropIfExists('contact_logins');

    }
};
