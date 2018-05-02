<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssociaEmailsRecomendante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associa_emails_recomendante', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email_fornecido');
            $table->string('email_preferido');
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
        Schema::drop('associa_emails_recomendante');
    }
}
