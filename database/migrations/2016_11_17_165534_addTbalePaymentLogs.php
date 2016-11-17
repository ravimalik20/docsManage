<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTbalePaymentLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_logs', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->float('amount');
            $table->string('status');
            $table->string('stripe_token');
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
        Schema::drop('payment_logs');
    }
}
