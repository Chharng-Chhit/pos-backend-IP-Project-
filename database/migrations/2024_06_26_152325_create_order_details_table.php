<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {

            $table->increments('id', true);

            $table->integer('order_id')->index()->unsigned();
            $table->foreign('order_id')->references('id')->on('order')->onDelete('cascade');

            $table->integer('product_id')->index()->unsigned();
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');

            $table->integer('customer_id')->index()->unsigned();
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');

            $table->double('unit_price')->nullable();
            $table->integer('qty')->unsigned()->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
