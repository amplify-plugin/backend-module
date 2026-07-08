<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('contact_logins', function (Blueprint $table) {
            $table->enum('row_type', ['assignment', 'session'])
                ->default('assignment')
                ->after('id');
            $table->nullableMorphs('impersonate');

            $table->index(['contact_id', 'row_type']);
            $table->index(['contact_id', 'row_type', 'last_logged_out'], 'contact_logins_open_sessions_index');
        });

        DB::table('contact_logins')->update(['row_type' => 'assignment']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_logins', function (Blueprint $table) {
            $table->dropIndex('contact_logins_open_sessions_index');
            $table->dropIndex(['contact_id', 'row_type']);
            $table->dropMorphs('impersonate');
            $table->dropColumn('row_type');
        });
    }
};
