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
            $table->integer('lesson_section_id')->index();
            $table->string('value', 255);
            $table->string('label', 255);
            $table->double('order_weight', 6, 2)->index();
            $table->tinyInteger('is_valid')->default(0);
            $table->tinyInteger('is_public')->default(0)->index();
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
        Schema::dropIfExists('lesson_section_options');
    }
}
