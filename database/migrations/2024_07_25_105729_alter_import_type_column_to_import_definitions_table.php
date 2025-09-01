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
        Schema::table('import_definitions', function (Blueprint $table) {
            DB::statement("ALTER TABLE import_definitions MODIFY COLUMN import_type ENUM('Attribute', 'Category', 'Product', 'ProductClassification', 'AttributeProduct', 'AttributeProductClassification', 'CategoryProduct', 'ProductProductClassification', 'Customer', 'Contact', 'ModelCode', 'ContactPermissions')");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('import_definitions', function (Blueprint $table) {
            DB::statement("ALTER TABLE import_definitions MODIFY COLUMN import_type ENUM('Attribute', 'Category', 'Product', 'ProductClassification', 'AttributeProduct', 'AttributeProductClassification', 'CategoryProduct', 'ProductProductClassification', 'Customer', 'Contact', 'ModelCode')");
        });
    }
};
