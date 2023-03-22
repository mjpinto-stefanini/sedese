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
        Schema::create('profissaos', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('ID');
            $table->string('nome')->comment('Nome da Profissão');
            $table->boolean('ativo')->default(true)->comment('Indica se o registro está ativo ou não');
            $table->boolean('outro')->default(false)->comment('Indica se há outro registro não listado ou adicionado pelo usuário');
            $table->string('outro_nome')->nullable()->comment('Nome do outro registro');
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
        Schema::dropIfExists('profissaos');
    }
};
