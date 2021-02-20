<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logins', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('login_ip', 30)->index();
            $table->dateTime('login_date');
            $table->tinyInteger('login_success')->default(0);
            $table->dateTime('logout_date')->nullable();
            $table->string('browser');
            $table->timestamps();
        });

        Schema::table('logins', function($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logins');
    }
}
