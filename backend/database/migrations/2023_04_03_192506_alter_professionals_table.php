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
        Schema::table('professionals', function (Blueprint $table) {
            $table->string('beneficios_municipal')->nullable()->after('cargo');
            $table->string('beneficios_municipal_outro')->nullable()->after('cargo');
            $table->string('servicos_programa')->nullable()->after('cargo');
            $table->string('servicos_programa_outro')->nullable()->after('cargo');
            $table->string('municipio_id')->nullable()->after('cargo');
            $table->string('vinculo_empregaticio_outro')->nullable()->after('cargo');
            $table->string('funcao_outro')->nullable()->after('cargo');
            $table->string('representacao_area_representada')->nullable()->after('cargo');
            $table->string('representacao_area_representada_outros')->nullable()->after('cargo');
            $table->string('representacao_conselho')->nullable()->after('cargo');
            $table->string('representacao_representacao')->nullable()->after('cargo');
            $table->string('representacao_segmento')->nullable()->after('cargo');
            $table->string('representacao_titularidade')->nullable()->after('cargo');
            $table->string('representante')->nullable()->after('cargo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('professionals', function (Blueprint $table) {
            $table->dropColumn('beneficios_municipal');
            $table->dropColumn('beneficios_municipal_outro');
            $table->dropColumn('servicos_programa');
            $table->dropColumn('servicos_programa_outro');
            $table->dropColumn('municipio_id');
            $table->dropColumn('vinculo_empregaticio_outro');
            $table->dropColumn('funcao_outro');
            $table->dropColumn('representacao_area_representada');
            $table->dropColumn('representacao_area_representada_outros');
            $table->dropColumn('representacao_conselho');
            $table->dropColumn('representacao_representacao');
            $table->dropColumn('representacao_segmento');
            $table->dropColumn('representacao_titularidade');
            $table->dropColumn('representante');
        });
    }
};
