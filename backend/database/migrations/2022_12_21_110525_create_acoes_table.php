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
        Schema::create('acoes', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('Identificador único da ação');
            $table->string('ano')->comment('Ano da ação');
            $table->string('nome')->comment('Nome da ação');
            $table->string('tipo')->comment('Tipo da ação: Capacitação, Formação, Apoio Técnico');
            $table->string('tematica')->comment('Temática da ação');
            $table->string('tipologia')->comment('Tipologia da ação');
            $table->string('modalidade')->comment('Modalidade da ação');
            $table->date('data_inicio')->comment('Data de início da ação');
            $table->date('data_fim')->comment('Data de fim da ação');
            $table->integer('num_vagas')->comment('Número de vagas da ação');
            $table->integer('acao_regionalizada')->comment('Ação regionalizada? 1 - Sim, 0 - Não, 2 - Não se aplica');
            $table->string('areas_envolvidas')->comment('Áreas envolvidas na ação');
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
        Schema::dropIfExists('acoes');
    }
};
