<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOrderNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            // $table->dropColumn('notes');
        });

        Schema::create('customer_order_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_order_id')->constrained('customer_orders')->cascadeOnDelete();
            $table->string('subject')->nullable();
            $table->text('note')->nullable();
            $table->string('type')->nullable();
            $table->bigInteger('erp_note_id')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            // $table->text('notes')->nullable()->after('spare_2');
        });

        Schema::dropIfExists('customer_order_notes');
    }
}
