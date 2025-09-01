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
        if (Schema::hasTable('invoices')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->foreignId('customer_id')->nullable()->after('invoice_number');
                $table->string('order_number')->nullable()->after('customer_id');
                $table->string('invoice_status')->default('OPEN')->after('invoice_number');
                $table->decimal('last_payment_amount', 10, 2)->nullable()->after('discount_amount');
                $table->date('last_payment_date')->nullable()->after('last_transaction_date');
                $table->string('invoice_note_1')->nullable()->after('customer_po_number');
                $table->string('invoice_note_2')->nullable()->after('invoice_note_1');
                $table->string('spare_1')->nullable()->after('invoice_note_2');
                $table->string('spare_2')->nullable()->after('spare_1');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('invoices')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dropColumn('customer_id');
                $table->dropColumn('order_number');
                $table->dropColumn('invoice_status');
                $table->dropColumn('last_payment_amount', 10, 2);
                $table->dropColumn('last_payment_date');
                $table->dropColumn('invoice_note_1');
                $table->dropColumn('invoice_note_2');
                $table->dropColumn('spare_1');
                $table->dropColumn('spare_2');
            });
        }
    }
};
