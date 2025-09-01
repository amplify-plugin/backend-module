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
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('visibility_for');
            $table->boolean('for_authenticated')->nullable()->default(false);
            $table->boolean('for_guest')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('for_authenticated');
            $table->dropColumn('for_guest');
            $table->string('visibility_for')->nullable();
        });
    }
};
