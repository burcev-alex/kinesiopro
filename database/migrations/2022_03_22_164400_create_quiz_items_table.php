<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->string('slug');
            $table->boolean('active')->default(true);

            $table->text('preview')->nullable();
            $table->longText('description')->nullable();
            
            $table->integer('attachment_id')->nullable();
            $table->integer('detail_attachment_id')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();

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
        Schema::dropIfExists('quiz_items');
    }
}
