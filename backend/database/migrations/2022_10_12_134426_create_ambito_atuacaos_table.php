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
        Schema::create('ambito_atuacaos', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('ID');
            $table->string('nome', 255)->comment('Nome do Ambito de Atuação');
            $table->string('regiao_administrativa', 255)->comment('Região Administrativa, 1 - Estadual e 2 - Municipal');
            $table->boolean('ativo')->default(true)->comment('Indica se o registro está ativo ou não');
            $table->boolean('outro')->default(false)->comment('Indica se há outro registro não listado ou adicionado pelo usuário');
            $table->string('outro_nome', 255)->nullable()->comment('Nome do outro registro');
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
        Schema::dropIfExists('ambito_atuacaos');
    }
};
