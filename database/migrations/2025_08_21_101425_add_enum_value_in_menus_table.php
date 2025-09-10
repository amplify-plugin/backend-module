<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE menus MODIFY COLUMN type ENUM('default', 'mega-menu', 'categories') NOT NULL DEFAULT 'default'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE menus MODIFY COLUMN type ENUM('default', 'mega-menu') NOT NULL DEFAULT 'default'");
    }
};
