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
        Schema::create('turma_polos_municipios', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('Identificador do polo');
            $table->uuid('turma_polo_id')->comment('Identificador do polo');
            $table->uuid('ambito_atuacaos_id')->comment('Identificador do município');
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
        Schema::dropIfExists('turma_polos_municipios');
    }
};
