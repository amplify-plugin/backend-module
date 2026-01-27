<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE `order_lists`
            MODIFY `list_type` VARCHAR(255) NOT NULL DEFAULT 'personal' COMMENT 'personal, global, quick-list, favorite possible options.'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE `order_lists`
            MODIFY `list_type` ENUM('personal', 'global', 'quick-list') NOT NULL COMMENT 'personal, global, quick-list, favorite possible options.'
        ");
    }
};
