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
        Schema::create('respresentations', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('ID');
            $table->uuid('user_id')->comment('ID do usuário');
            $table->string('representacao_conselho')->comment('Representação no conselho');
            $table->string('representacao_titularidade')->comment('Representação titularidade');
            $table->string('representacao_representacao')->comment('Representação representação');
            $table->string('representacao_segmento')->comment('Representação segmento');
            $table->string('representacao_area_representada')->comment('Representação área representada');
            $table->string('outros_reperesentacao_area_representada')->nullable()->comment('Outros representação área representada');
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
        Schema::dropIfExists('respresentations');
    }
};
