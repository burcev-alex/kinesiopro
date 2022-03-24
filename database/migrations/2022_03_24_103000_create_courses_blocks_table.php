<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCoursesBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId("course_id")->constrained("courses")->onDelete('cascade');
            $table->string('title');
            $table->integer('sort')->default(0);
            $table->dateTime('start_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('finish_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreignId("teacher_id")->constrained("teachers")->onDelete('cascade');
            $table->text('description')->nullable();

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
        Schema::dropIfExists('courses_blocks');
    }
}
