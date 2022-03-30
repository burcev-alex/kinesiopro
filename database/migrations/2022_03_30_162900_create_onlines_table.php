<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOnlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onlines', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->string('type');
            $table->boolean('active')->default(true);
            $table->integer('sort')->default(500);
            $table->integer('attachment_id');
            
            $table->dateTime('start_date')->nullable();
            $table->dateTime('finish_date')->nullable();
            $table->integer('price')->default(0);
            
            $table->text('preview')->nullable();

            $table->string('meta_h1')->nullable();
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
        Schema::dropIfExists('onlines');
    }
}
