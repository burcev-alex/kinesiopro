<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stream_lessons', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->string('slug');
            $table->integer('sort')->default(500);
            
            $table->integer('attachment_id')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();

            $table->text('description')->nullable();
            

            $table->timestamps();
        });

        Schema::table('stream_lessons', function (Blueprint $table) {
            $table->foreignId("stream_id")->after('id')->constrained('streams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stream_lessons');
    }
}
