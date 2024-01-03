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
        Schema::create('users_perfil_status', function (Blueprint $table) {
            $table->uuid('id')->comment('ID');
            $table->uuid('user_id')->unique()->comment('ID do usuário');
            $table->integer('tipo_perfil_id');
            $table->tinyInteger('status')->comment('Status');
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
        
        Schema::dropIfExists('users_perfil_status');
    }
};
