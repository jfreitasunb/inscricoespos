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
        Schema::create('formacao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_ptbr',50);
            $table->string('tipo_en',50)->nullable();
            $table->string('tipo_es',50)->nullable();
            $table->string('nivel',50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formacao');
    }
};
