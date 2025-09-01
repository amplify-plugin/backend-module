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
        Schema::table('event_actions', function (Blueprint $table) {
            $table->tinyInteger('is_get_salesperson')->default(0)->nullable()->after('is_get_customer_business_contact');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_actions', function (Blueprint $table) {
            $table->dropColumn('is_get_salesperson');
        });
    }
};
