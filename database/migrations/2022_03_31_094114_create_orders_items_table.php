<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId("order_id")->constrained("orders")->onDelete('cascade');
            $table->integer("product_id");
            $table->string("product_type");

            $table->integer('quantity');
            $table->integer('unit_price')->nullable();
            $table->integer('total');

            $table->string('name');
            
			$table->json('property')->nullable();

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
        Schema::dropIfExists('orders_items');
    }
}
