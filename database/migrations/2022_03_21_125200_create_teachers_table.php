<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger("attachment_id")->nullable();
            $table->string('full_name');
            $table->string('slug');
            $table->integer('sort')->default(100);
            $table->tinyInteger('active')->default(1);
            $table->longText('description')->nullable();

            $table->longText('education')->nullable();
            $table->longText('certificates')->nullable();
            $table->longText('specialization')->nullable();

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
        Schema::dropIfExists('teachers');
    }
}
