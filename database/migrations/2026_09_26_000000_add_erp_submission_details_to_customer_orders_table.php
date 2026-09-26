<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->longText('erp_request_body')->nullable();
            $table->longText('erp_response_body')->nullable();
            $table->text('erp_error_message')->nullable();
            $table->timestamp('erp_request_at')->nullable();
            $table->timestamp('erp_response_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->dropColumn([
                'erp_request_body',
                'erp_response_body',
                'erp_error_message',
                'erp_request_at',
                'erp_response_at',
            ]);
        });
    }
};