<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FileRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('folder_id');
            $table->boolean('is_uploaded');
            $table->string('description');
            $table->string('type');
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
        Schema::drop('file_request');
    }
}
