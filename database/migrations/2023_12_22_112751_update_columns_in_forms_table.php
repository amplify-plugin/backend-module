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
        Schema::table('form_fields', function (Blueprint $table) {
            $table->string('minimum')->nullable()->after('options');
            $table->string('maximum')->nullable()->after('minimum');
            $table->text('validation')->nullable()->after('maximum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_fields', function (Blueprint $table) {
            $table->dropColumn('minimum');
            $table->dropColumn('maximum');
            $table->dropColumn('validation');
        });
    }
};
