<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApproverIdToCustomerOrderRuleTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_order_rule_tracks', function (Blueprint $table) {
            $table->integer('approver_id')->after('order_rule_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_order_rule_tracks', function (Blueprint $table) {
            $table->dropColumn('approver_id');
        });
    }
}
