<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DocumentPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("document_permission",function(Blueprint $table){
            $table->increments("id");
            $table->integer("document_id");
            $table->integer("user_id");
            $table->integer("permission_id");
            $table->string("type");
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
        Schema::drop("document_permission");
    }
}
