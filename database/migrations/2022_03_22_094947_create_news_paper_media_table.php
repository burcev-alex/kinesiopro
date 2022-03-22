<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsPaperMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_news_paper_media', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId("component_id")->constrained('blog_news_paper_components')->onDelete('cascade');
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
        Schema::dropIfExists('blog_news_paper_media');
    }
}
