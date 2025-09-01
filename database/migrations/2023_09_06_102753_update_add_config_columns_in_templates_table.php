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
        Schema::table('templates', function (Blueprint $table) {
            $table->string('author')->after('name')->nullable();
            $table->text('description')->after('asset_folder')->nullable();
            $table->string('screenshot')->after('description')->nullable();
            $table->string('readme')->after('screenshot')->nullable();
            $table->json('options')->after('readme')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('screenshot');
            $table->dropColumn('readme');
            $table->dropColumn('options');
        });
    }
};
