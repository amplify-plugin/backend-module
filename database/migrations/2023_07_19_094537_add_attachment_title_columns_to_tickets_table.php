<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttachmentTitleColumnsToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('tickets', 'attachment_title')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->longText('attachment_title')->nullable()->change();
            });
        } else {
            Schema::table('tickets', function (Blueprint $table) {
                $table->longText('attachment_title')->nullable()->after('attachments');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('tickets', 'attachment_title')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->dropColumn('attachment_title');
            });
        }
    }
}
