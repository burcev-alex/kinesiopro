<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_description_components', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->integer('component_id');
            $table->integer('sort')->default(0);
            $table->json('fields');

            $table->timestamps();
        });

        Schema::table('courses_description_components', function (Blueprint $table) {
            $table->foreignId("course_id")->after('id')->constrained('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses_description_components');
    }
}
