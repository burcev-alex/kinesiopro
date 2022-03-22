<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsPaperComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_news_paper_components', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->integer('component_id');
            $table->integer('sort')->default(0);
            $table->json('fields');

            $table->timestamps();
        });

        Schema::table('blog_news_paper_components', function (Blueprint $table) {
            $table->foreignId("news_paper_id")->after('id')->constrained('blog_news_papers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_news_paper_components');
    }
}
