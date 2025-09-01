<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTracepartsAttributeIdToAttributesTable extends Migration
{
    public function up(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            // add a nullable unsignedBigInteger after the primary key
            $table->unsignedBigInteger('traceparts_attribute_id')
                ->after('id')
                ->nullable()
                ->comment('Original Traceparts XML Attribute ID');
        });
    }

    public function down(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropColumn('traceparts_attribute_id');
        });
    }
}
