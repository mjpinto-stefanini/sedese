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

        Schema::create('professionals', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('ID');;
            $table->uuid('user_id')->comment('ID do usuário');
            $table->string('regional')->comment('Regional Label');
            $table->string('superintendencia')->comment('Superintendência Label');
            $table->string('protecao_social_basica')->nullable()->comment('Proteção Social Básica');
            $table->string('protecao_social_especial')->nullable()->comment('Proteção Social Especial');
            $table->string('vigilancia_capacitacao')->nullable()->comment('Vigilância e Capacitação');
            $table->string('vinculo_empregaticio')->nullable()->comment('Vínculo Empregaticio');
            $table->string('funcao')->nullable()->comment('Função');
            $table->string('diretoria_regional_des_social')->nullable()->comment('Diretoria Regional de Desenvolvimento Social');
            $table->string('creas_regional')->nullable()->comment('CREAS Regional');
            $table->string('exe_creas_funcao')->nullable()->comment('Exe CREAS Função');
            $table->string('exe_creas_vinc_empreg')->nullable()->comment('Exe CREAS Vínculo Empregaticio');
            $table->string('outros_publicos')->nullable()->comment('Outros Públicos');
            $table->string('outros_publicos_others')->nullable()->comment('Outros Públicos Others');
            $table->string('parceiros')->nullable()->comment('Parceiros');
            $table->string('orgao')->nullable()->comment('Órgão');
            $table->string('area_de_atuacao')->nullable()->comment('Área de Atuação');
            $table->string('protecao_social_basica_municipal')->nullable()->comment('Proteção Social Básica Municipal');
            $table->string('beneficios_socioassistenciais')->nullable()->comment('Benefícios Socioassistenciais');
            $table->string('protecao_social_especial_municipal')->nullable()->comment('Proteção Social Especial Municipal');
            $table->string('social_especial_municipal_media_complexidade')->nullable()->comment('Social Especial Municipal Média Complexidade');
            $table->string('social_especial_municipal_alta_complexidade')->nullable()->comment('Social Especial Municipal Alta Complexidade');
            $table->string('representacao')->nullable()->comment('Representação');
            $table->string('area_representada')->nullable()->comment('Área Representada');
            $table->string('area_representada_outros')->nullable()->comment('Área Representada Outros');
            $table->string('cargo')->nullable()->comment('Cargo');

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
        Schema::dropIfExists('professionals');
    }
};
