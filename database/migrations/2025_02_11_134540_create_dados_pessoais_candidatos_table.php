<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dados_pessoais_candidato', function (Blueprint $table){
            $table->Increments('id');
            $table->unsignedInteger('id_candidato');
            $table->foreign('id_candidato')->references('id')->on('users')->onDelete('cascade');
            $table->date('data_nascimento')->nullable();
            $table->string('numerorg',30)->nullable();
            $table->string('endereco',255)->nullable();
            $table->string('cep',30)->nullable();
            $table->integer('pais')->nullable();
            $table->integer('estado')->nullable();
            $table->integer('cidade')->nullable();
            $table->string('celular',20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dados_pessoais_candidato');
    }
};
