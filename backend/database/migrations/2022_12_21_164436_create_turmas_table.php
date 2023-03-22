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
        /*
            quantidade_turma
            nome
            turma_endereco_id
            turma_ferramenta_id
            turma_data_inicio
            turma_data_fim
            carga_horaria_aula
            carga_horaria_total
            turma_periodo
            quantidade_vagas_estaduais
            intramunicipais
            inscricoes_data_inicio
            inscricoes_data_fim
            perfil_participantes
            criterio_certificacao
        */

        Schema::create('turmas', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('Identificador da turma');
            $table->string('nome')->comment('Nome da turma');
            $table->uuid('turma_endereco_id')->comment('Identificador do endereço da turma');
            $table->uuid('turma_ferramenta_id')->comment('Identificador da ferramenta da turma');
            $table->date('turma_data_inicio')->comment('Data de início da turma');
            $table->date('turma_data_fim')->comment('Data de fim da turma');
            $table->integer('carga_horaria_aula')->comment('Carga horária da aula');
            $table->integer('carga_horaria_total')->comment('Carga horária total');
            $table->string('turma_periodo')->comment('Período da turma');
            $table->integer('quantidade_vagas_estaduais')->comment('Quantidade de vagas estaduais');
            $table->integer('quantidade_vagas_municipais')->comment('Quantidade de vagas municipais');
            $table->date('inscricoes_data_inicio')->comment('Data de início das inscrições');
            $table->date('inscricoes_data_fim')->comment('Data de fim das inscrições');
            $table->string('perfil_participantes')->comment('Perfil dos participantes');
            $table->string('criterio_certificacao')->comment('Critério de certificação');
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
        Schema::dropIfExists('turmas');
    }
};
