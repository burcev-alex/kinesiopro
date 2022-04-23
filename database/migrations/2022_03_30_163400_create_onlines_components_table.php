<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlinesComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onlines_description_components', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->integer('component_id');
            $table->integer('sort')->default(0);
            $table->json('fields');

            $table->timestamps();
        });

        Schema::table('onlines_description_components', function (Blueprint $table) {
            $table->foreignId("online_id")->after('id')->constrained('onlines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('onlines_description_components');
    }
}
