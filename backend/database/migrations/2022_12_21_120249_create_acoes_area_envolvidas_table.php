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
        Schema::create('acoes_area_envolvidas', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('Identificador único da área envolvida');
            $table->string('nome')->comment('Nome da área envolvida');
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
        Schema::dropIfExists('acoes_area_envolvidas');
    }
};
