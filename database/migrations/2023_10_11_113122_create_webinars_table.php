<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebinarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webinars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webinar_type_id')->nullable()->constrained('webinar_types')->cascadeOnDelete();
            $table->foreignId('page_id')->constrained('pages')->cascadeOnDelete();
            $table->foreignId('banner_zone_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('code')->nullable();
            $table->string('title')->nullable();
            $table->text('short_description')->nullable();
            $table->dateTime('start_date_time')->nullable();
            $table->dateTime('end_date_time')->nullable();
            $table->string('address_name')->nullable();
            $table->text('address_url')->nullable();
            $table->string('cover_photo');
            $table->string('additional_photos')->nullable();
            $table->string('booking_label')->nullable();
            $table->string('booking_url')->nullable();
            $table->longText('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webinars');
    }
}
