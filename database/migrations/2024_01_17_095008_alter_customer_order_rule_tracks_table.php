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
        Schema::table('customer_order_rule_tracks', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('approver_id');
            $table->dropColumn('passed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_order_rule_tracks', function (Blueprint $table) {
            $table->boolean('passed')->default(false)->after('approver_id');
            $table->dropColumn('status');
        });
    }
};
