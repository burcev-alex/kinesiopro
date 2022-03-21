<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId("course_id")->constrained("courses")->onDelete('cascade');
            $table->foreignId("ref_char_id")->constrained("ref_chars")->onDelete('cascade');
            $table->foreignId("ref_char_value_id")->constrained("ref_chars_values")->onDelete('cascade');
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
        Schema::dropIfExists('courses_properties');
    }
}
