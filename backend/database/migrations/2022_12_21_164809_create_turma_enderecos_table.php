<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turma_enderecos', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('Identificador do endereço');
            $table->uuid('turmas_id')->comment('Identificador da turma');
            $table->string('number')->comment('Número');
            $table->string('complement')->nullable()->comment('Complemento');
            $table->string('neighborhood')->comment('Bairro');
            $table->string('city')->comment('Cidade');
            $table->string('state')->comment('Estado');
            $table->string('zip_code')->comment('CEP');
            $table->string('street')->comment('Rua');
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
        Schema::dropIfExists('turma_enderecos');
    }
};
