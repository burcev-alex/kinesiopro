<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlinesMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onlines_description_media', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId("component_id")->constrained('onlines_description_components')->onDelete('cascade');
            $table->integer('attachment_id');

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
        Schema::dropIfExists('onlines_description_media');
    }
}
