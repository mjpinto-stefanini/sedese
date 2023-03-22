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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('ID');
            $table->string('name')->comment('Nome');
            $table->string('email')->unique()->comment('E-mail');
            $table->timestamp('email_verified_at')->nullable()->comment('E-mail verificado em');
            $table->string('password')->comment('Senha');
            $table->rememberToken()->comment('Token de recuperação de senha');
            $table->timestamps();
            $table->boolean('is_active')->default(true)->comment('Usuário ativo');
            $table->boolean('is_admin')->default(false)->comment('Usuário administrador');
            $table->boolean('is_superuser')->default(false)->comment('Usuário super administrador');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
