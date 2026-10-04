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
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->index()->change();
            $table->foreignId('contact_id')->nullable()->index()->change();
            $table->foreignId('approver_id')->nullable()->after('order_status')->change();
            $table->renameColumn('customer_order_number', 'po_number');

            $table->dropColumn('submitted_at');
            $table->nullableMorphs('submitter', 'customer_orders_submitter_index', 'user_id');

            $table->decimal('total_net_price', 18,6)->nullable()->change();
            $table->decimal('total_tax_amount', 18,6)->nullable()->change();
            $table->decimal('total_shipping_cost', 18,6)->nullable()->change();
            $table->decimal('total_amount', 18,6)->nullable()->change();
            $table->json('total_additional')->nullable()->after('total_amount');

            $table->renameColumn('shipping_method', 'ship_to_method');
            $table->string('ship_to_method_label')->nullable()->after('ship_to_method');
            $table->renameColumn('shipping_number', 'ship_to_number');
            $table->string('ship_to_address')->nullable()->after('ship_to_number')->change();
            $table->string('ship_to_city')->nullable()->after('ship_to_address')->change();
            $table->string('ship_to_state')->nullable()->after('ship_to_city')->change();
            $table->string('ship_to_zip_code')->nullable()->after('ship_to_state')->change();
            $table->string('ship_to_country_code')->nullable()->after('ship_to_zip_code')->change();
            $table->string('ship_to_instruction')->nullable()->after('ship_to_country_code');
            $table->string('ship_to_contact')->nullable()->after('ship_to_number');
            $table->string('ship_to_phone')->nullable()->after('ship_to_contact');
            $table->json('ship_to_additional')->nullable()->after('ship_to_contact');

            $table->string('draft_name')->nullable()->after('id')->change();
            $table->renameColumn('draft_name', 'order_name');
            $table->dropColumn('temp_address');
            $table->dropColumn('spare_1');
            $table->dropColumn('spare_2');
            $table->dropColumn('notes');
            $table->string('order_warehouse')->nullable()->after('order_status');
            $table->foreignId('order_warehouse_id')->nullable()->after('order_warehouse');
            $table->foreignId('ship_to_id')->nullable()->after('ship_to_method');

            $table->string('pay_to_method')->nullable()->after('ship_to_phone');
            $table->string('pay_to_address')->nullable()->after('pay_to_method');
            $table->string('pay_to_city')->nullable()->after('pay_to_address');
            $table->string('pay_to_state')->nullable()->after('pay_to_city');
            $table->string('pay_to_country_code')->nullable()->after('pay_to_state');
            $table->string('pay_to_zip_code')->nullable()->after('pay_to_country_code');
            $table->string('pay_to_additional')->nullable()->after('pay_to_zip_code');

            $table->string('customer_name')->nullable()->after('customer_id')->change();
            $table->string('customer_code')->nullable()->after('customer_name');
            $table->string('customer_address_1')->nullable()->after('customer_code');
            $table->string('customer_address_2')->nullable()->after('customer_address_1');
            $table->string('customer_address_3')->nullable()->after('customer_address_2');
            $table->string('customer_city')->nullable()->after('customer_address_3');
            $table->string('customer_state')->nullable()->after('customer_city');
            $table->string('customer_country_code')->nullable()->after('customer_state');
            $table->string('customer_zip_code')->nullable()->after('customer_country_code');

            $table->string('name')->nullable()->after('contact_id')->comment('contact information');
            $table->string('email')->nullable()->after('name')->comment('contact information')->change();
            $table->string('phone')->nullable()->after('email')->comment('contact information')->change();
        });

        Schema::table('customer_order_lines', function (Blueprint $table) {
            $table->string('source')->nullable()->after('spare_2')->change();
            $table->string('source_type')->nullable()->after('source')->change();
            $table->json('additional_info')->nullable()->after('options')->change();

            $table->decimal('shipping_cost', 18,6)->nullable()->change();
            $table->decimal('ssp', 18,6)->nullable()->change();
            $table->decimal('discount_amount', 18,6)->nullable()->change();
            $table->decimal('customer_price', 18,6)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //No Rollback
    }
};
