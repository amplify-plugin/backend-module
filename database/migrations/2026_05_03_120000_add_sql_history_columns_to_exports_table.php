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
        Schema::table('exports', function (Blueprint $table) {
            $table->string('type', 50)->default('sql')->after('name');
            $table->longText('query_text')->nullable()->after('type');
            $table->string('query_hash', 64)->nullable()->after('query_text');
            $table->timestamp('last_used_at')->nullable()->after('query_hash');

            $table->index('type');
            $table->unique('query_hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exports', function (Blueprint $table) {
            $table->dropUnique(['query_hash']);
            $table->dropIndex(['type']);

            $table->dropColumn([
                'type',
                'query_text',
                'query_hash',
                'last_used_at',
            ]);
        });
    }
};

