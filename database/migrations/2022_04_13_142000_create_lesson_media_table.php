<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stream_lesson_media', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId("component_id")->constrained('stream_lesson_components')->onDelete('cascade');
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
        Schema::dropIfExists('stream_lesson_media');
    }
}
