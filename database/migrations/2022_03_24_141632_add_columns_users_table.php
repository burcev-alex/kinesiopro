<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname')->nullable();
            $table->string('surname')->nullable();
            $table->string('phone')->nullable();

            $table->date('birthday')->nullable();
			$table->string('country')->nullable();
			$table->string('work')->nullable();
			$table->string('position')->nullable();

            $table->integer('avatar_id')->nullable();
            $table->integer('scan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('firstname');
            $table->dropColumn('surname');
            $table->dropColumn('phone');
            $table->dropColumn('birthday');
            $table->dropColumn('country');
            $table->dropColumn('work');
            $table->dropColumn('position');
            $table->dropColumn('avatar_id');
            $table->dropColumn('scan_id');
        });
    }
}
