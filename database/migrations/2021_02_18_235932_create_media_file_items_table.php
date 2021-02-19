<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaFileItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_fileables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('media_file_id')->unsigned();
            $table->morphs('media_fileable');
            $table->timestamps();
        });

        Schema::table('media_fileables', function($table) {
            $table->foreign('media_file_id')->references('id')->on('media_files')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_file_item');
    }
}
