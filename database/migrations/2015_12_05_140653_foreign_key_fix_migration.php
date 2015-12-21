<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeyFixMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("folders", function ($table)
        {
            $table->dropForeign('folders_parent_foreign');
            $table->foreign('parent')
                ->references('id')->on('folders')
                ->onDelete('cascade');

            $table->dropForeign('folders_user_id_foreign');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::table("files", function ($table)
        {
            $table->dropForeign('files_extension_id_foreign');
            $table->foreign('extension_id')
                ->references('id')->on('extensions')
                ->onDelete('cascade');

            $table->dropForeign('files_folder_id_foreign');
            $table->foreign('folder_id')
                ->references('id')->on('folders')
                ->onDelete('cascade');

            $table->dropForeign('files_created_by_foreign');
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("folders", function ($table)
        {
            $table->dropForeign('folders_parent_foreign');
            $table->foreign('parent')
                ->references('id')->on('folders');

            $table->dropForeign('folders_user_id_foreign');
            $table->foreign('user_id')
                ->references('id')->on('users');
        });

        Schema::table("files", function ($table)
        {
            $table->dropForeign('files_extension_id_foreign');
            $table->foreign('extension_id')
                ->references('id')->on('extensions');

            $table->dropForeign('files_folder_id_foreign');
            $table->foreign('folder_id')
                ->references('id')->on('folders');

            $table->dropForeign('files_created_by_foreign');
            $table->foreign('created_by')
                ->references('id')->on('users');
        });
    }
}
