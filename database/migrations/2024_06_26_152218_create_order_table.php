<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {

            $table->increments('id', true);

            $table->integer('receipt_number')->unsigned()->nullable();
            $table->integer('cashier_id')->index()->unsigned();
            $table->foreign('cashier_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('customer_id')->index()->unsigned();
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('total_price')->nullable();
            $table->dateTime('ordered_at')->nullable();

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
        Schema::dropIfExists('order');
    }
}
