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
        Schema::create('cartas_recomendacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('e_mail_fornecido');
            $table->string('e_mail_preferido');
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
