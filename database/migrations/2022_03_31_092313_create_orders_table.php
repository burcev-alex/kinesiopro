<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->datetime('completed_at')->nullable();
            $table->string('number');
            $table->integer('items_total');
            $table->integer('total');
            $table->boolean('confirmed')->default(false);
            $table->string('confirmation_token')->nullable();
            $table->string('state');
            $table->string('email')->nullable();

            $table->bigInteger('user_id')->unsigned()->nullable();
			$table->string('comment')->nullable();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('phone')->nullable();
			$table->string('promocode')->nullable();

            $table->string('payment_method')->nullable();
			$table->string('payment_status')->nullable();
			$table->json('payment')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
