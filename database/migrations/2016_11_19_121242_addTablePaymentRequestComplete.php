<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTablePaymentRequestComplete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('payment_requests', function(Blueprint $table){
          $table->string('is_complete')->nullable();
          $table->float('current_amount')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('payment_requests', function(Blueprint $table){
          $table->dropColumn('is_complete', 'current_amount');
      });
    }
}
