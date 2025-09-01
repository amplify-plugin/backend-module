<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoreConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('global_currency')->unique()->default('USD');
            $table->string('navbar_brand')->default('img/Amplify Logo 280 tagline.png')->nullable();
            $table->string('footer_image')->default('img/Powered by EasyAsk.png')->nullable();
            $table->text('default_language');
            $table->boolean('auto_publish')->default(0);
            $table->boolean('required_fields')->default(1);
            $table->integer('default_reorder_limit')->default(10);
            $table->text('mandatory_fields')->nullable();
            $table->boolean('use_classifications')->default(1);
            $table->boolean('categorization_required')->default(1);
            $table->boolean('is_elfinder_drag_and_drop')->default(0);
            $table->foreignId('mandatory_field_id')->nullable();
            $table->text('product_search_by_id_prefix')->nullable();
            $table->text('easyask_host')->nullable();
            $table->text('easyask_port')->nullable();
            $table->text('easyask_dictionary')->nullable();
            $table->text('hierarchies')->nullable();
            $table->enum('project_mode', ['developer', 'production'])->default('developer');
            $table->string('date_time_format', 20)->default('Y-m-d H:i:s');
            $table->string('primary_color')->default('#ff914d');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_configurations');
    }
}
