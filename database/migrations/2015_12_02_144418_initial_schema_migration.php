<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialSchemaMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("folders", function ($table)
        {
            $table->increments("id");
            $table->string("name");
            $table->integer("parent")->unsigned()->nullable()->default(null);
            $table->integer("user_id")->unsigned();
            $table->foreign("user_id")->references("id")->on("users");
            $table->timestamps();
        });

        Schema::table("folders", function ($table)
        {
            $table->foreign("parent")->references("id")->on("folders");
        });

        Schema::create("extensions", function ($table)
        {
            $table->increments("id");
            $table->string("name");
            $table->timestamps();
        });

        Schema::create("files", function ($table)
        {
            $table->increments("id");
            $table->string("name");
            $table->integer("extension_id")->unsigned();
            $table->foreign("extension_id")->references("id")->on("extensions");
            $table->string("path");
            $table->integer("folder_id")->unsigned()->nullable()->default(null);
            $table->foreign("folder_id")->references("id")->on("folders");
            $table->integer("created_by")->unsigned();
            $table->foreign("created_by")->references("id")->on("users");
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
        Schema::drop("folders");
        Schema::drop("extensions");
        Schema::drop("files");
    }
}
