<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonSectionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_section_options', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lesson_section_id')->unsigned();
            $table->string('value', 255);
            $table->string('label', 255);
            $table->double('order_weight', 6, 2)->index();
            $table->tinyInteger('is_valid')->default(0);
            $table->tinyInteger('is_public')->default(0)->index();
            $table->timestamps();
        });

        Schema::table('lesson_section_options', function($table) {
            $table->foreign('lesson_section_id')->references('id')->on('lesson_sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_section_options');
    }
}
