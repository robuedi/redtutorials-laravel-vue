<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('from_address',255)->index();
            $table->text('to_address');
            $table->text('cc_address')->nullable();
            $table->text('bcc_address')->nullable();
            $table->string('email_subject',255);
            $table->longtext('email_content');
            $table->longText('email_attachment')->nullable();
            $table->enum('sent_success', array('yes', 'no'));
            $table->dateTime('sent_date');
            $table->integer('retries');
            $table->text('mailer_internal_id')->nullable();
            $table->text('mailer_last_response')->nullable();
            $table->dateTime('skip_check_date')->nullable();
            $table->timestamps();
        });

        Schema::table('emails', function($table) {
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
        Schema::dropIfExists('emails');
    }
}
