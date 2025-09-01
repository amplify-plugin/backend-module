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
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('invoice_number')->nullable();
            $table->string('invoice_type')->nullable();
            $table->string('invoice_dispute_code')->nullable();
            $table->string('finance_charge_flag')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('entry_date')->nullable();
            $table->date('age_date')->nullable();
            $table->decimal('invoice_amount', 10, 2)->nullable();
            $table->decimal('invoice_balance', 10, 2)->nullable();
            $table->decimal('pending_payment', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->date('discount_due_date')->nullable();
            $table->date('last_transaction_date')->nullable();
            $table->integer('pay_days')->nullable();
            $table->string('allow_ar_payments')->nullable();
            $table->string('has_invoice_detail')->nullable();
            $table->string('customer_po_number')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_number', 'invoice_type', 'invoice_dispute_code', 'finance_charge_flag',
                'invoice_date', 'entry_date', 'age_date', 'invoice_amount', 'invoice_balance',
                'pending_payment', 'discount_amount', 'discount_due_date', 'last_transaction_date',
                'pay_days', 'allow_ar_payments', 'has_invoice_detail', 'customer_po_number', 'created_at', 'updated_at',
            ]);
        });
    }
};
