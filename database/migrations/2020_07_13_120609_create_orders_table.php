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
            $table->string('session_id');
            $table->integer('user_id')->nullable();
            $table->string('username');
            $table->string('email');
            $table->string('address');
            $table->tinyInteger('shipping_method'); // 1 pick from store | 2 delivery
            $table->tinyInteger('payment_method'); // 1 pay at store | 2 cash on delivery
            $table->string('coupon')->nullable();
            $table->float('final_total');
            $table->integer('status')->default(0);
            /*
             * status
             *  0 => Pending
             *  1 => Processing
             *  2 => Shipping
             *  3 => Delivered
             *  4 => Returned
             */

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
