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
        Schema::table('pages', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('middleware')->constrained('pages', 'id');
            $table->unsignedBigInteger('level')->nullable()->after('parent_id');
            $table->unsignedBigInteger('depth')->nullable()->after('level');
            $table->unsignedBigInteger('lft')->nullable()->after('depth');
            $table->unsignedBigInteger('rgt')->nullable()->after('lft');
            $table->boolean('has_breadcrumb')->default(true)->after('rgt');
            $table->boolean('has_footer')->default(true)->after('has_breadcrumb');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('parent_id');
            $table->dropColumn('level');
            $table->dropColumn('depth');
            $table->dropColumn('lft');
            $table->dropColumn('rgt');
            $table->dropColumn('has_breadcrumb');
            $table->dropColumn('has_footer');
        });
    }
};
