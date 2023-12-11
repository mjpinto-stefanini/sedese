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
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id('id');
            $table->uuid('uuid')->index();
            $table->uuid('parceiros_id')->index();
            $table->uuid('user_id')->index();
            $table->string('email')->index()->comment('email do colaborador');
            $table->string('status')->comment('Verifica o status do usuário dentro da instituição');
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
        Schema::dropIfExists('colaboradores');
    }
};
