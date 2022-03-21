<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->foreignId('category_id')->constrained("categories");
            $table->boolean('marker_new')->default(false);
            $table->boolean('marker_popular')->default(false);
            $table->boolean('marker_archive')->default(false);
            $table->integer('sort')->default(500);
            $table->dateTime('start_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('finish_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('price')->default(0);
            $table->jsonb('teacher_id')->default(null);
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
        Schema::dropIfExists('courses');
    }
}
