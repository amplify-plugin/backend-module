<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTracepartsCategoryIdToCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // add a nullable unsignedBigInteger after the primary key
            $table->unsignedBigInteger('traceparts_category_id')
                ->after('id')
                ->nullable()
                ->comment('Original Traceparts XML Category ID');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('traceparts_category_id');
        });
    }
}
