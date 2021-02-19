<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_sections', function (Blueprint $table) {
            $table->id();
            $table->integer('lesson_id')->index();
            $table->string('name', 255)->nullable();
            $table->text('content')->nullable();
            $table->string('type', 255)->index();
            $table->string('options_type', 255)->nullable();
            $table->double('order_weight', 6, 2)->index();
            $table->tinyInteger('is_public')->default(0)->index();
            $table->tinyInteger('is_draft')->default(1)->index();
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
        Schema::dropIfExists('lesson_sections');
    }
}
