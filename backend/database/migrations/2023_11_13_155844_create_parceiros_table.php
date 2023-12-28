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
        Schema::create('parceiros', function (Blueprint $table) {
            $table->id('id');
            $table->uuid('uuid')->index();
            $table->string('nome_instituicao');
            $table->string('status');
            $table->string('cnpj')->unique();
            $table->uuid('user_id')->index()->comment('O Responsavel legal é um usuário do sistema.');
            $table->string('phone')->comment('telefone da instituição');
            $table->string('observacao')->nullable();
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
        Schema::dropIfExists('parceiros');
    }
};
