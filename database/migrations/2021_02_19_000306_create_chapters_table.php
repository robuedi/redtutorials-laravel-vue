<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id')->nullable()->index();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->double('order_weight', 6, 2)->index();
            $table->tinyInteger('is_public')->default(0)->index();
            $table->tinyInteger('is_draft')->default(1)->index();
            $table->string('slug', 100)->nullable()->index();
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
        Schema::dropIfExists('chapters');
    }
}
