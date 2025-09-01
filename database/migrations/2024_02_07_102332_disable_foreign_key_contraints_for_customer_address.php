<?php

use Amplify\System\Backend\Traits\HasForeignKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DisableForeignKeyContraintsForCustomerAddress extends Migration
{
    use HasForeignKey;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        if ($this->hasForeignKey('customer_addresses', 'customer_id')) {
            Schema::table('customer_addresses', function (Blueprint $table) {
                $table->dropForeign(['customer_id']);
            });
        }
        if ($this->hasForeignKey('contacts', 'customer_address_id')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropForeign(['customer_address_id']);
            });
        }
        if ($this->hasForeignKey('customer_order_lines', 'ship_to_address_id')) {
            Schema::table('customer_order_lines', function (Blueprint $table) {
                $table->dropForeign(['ship_to_address_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers');
        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->foreign('customer_address_id')->references('id')->on('customer_addresses');
        });
        Schema::table('customer_order_lines', function (Blueprint $table) {
            $table->foreign('ship_to_address_id')->references('id')->on('customer_addresses');
        });
    }
}
