<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("history",function(Blueprint $table){
            $table->increments("id");
            $table->integer("user_id")->nullable();
            $table->integer("document_id")->nullable();
            $table->string("type")->nullable();
            $table->string("status")->nullable();
            $table->string("reason")->nullable();
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
        Schema::drop("history");
    }
}
