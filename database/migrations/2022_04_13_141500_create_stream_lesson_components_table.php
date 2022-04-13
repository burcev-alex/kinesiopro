<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamLessonComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stream_lesson_components', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->integer('component_id');
            $table->integer('sort')->default(0);
            $table->json('fields');

            $table->timestamps();
        });

        Schema::table('stream_lesson_components', function (Blueprint $table) {
            $table->foreignId("lesson_id")->after('id')->constrained('stream_lessons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stream_lesson_components');
    }
}
