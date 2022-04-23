<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizItemsQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_item_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->integer('question_id');
            $table->integer('sort')->default(0);
            $table->json('fields');

            $table->timestamps();
        });

        Schema::table('quiz_item_questions', function (Blueprint $table) {
            $table->foreignId("item_id")->after('id')->constrained('quiz_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_item_questions');
    }
}
