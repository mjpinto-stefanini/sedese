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

        Schema::create('contacts', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('ID');
            $table->uuid('user_id')->comment('ID do usuário');
            $table->string('phone')->nullable()->comment('Telefone');
            $table->string('cell_phone')->comment('Celular');
            $table->string('cell_phone_whatsapp')->nullable()->comment('Celular Whatsapp');
            $table->string('institutional_phone')->nullable()->comment('Telefone institucional');
            $table->string('institutional_email')->nullable()->comment('E-mail institucional');
            $table->boolean('isWhatsapp')->default(true)->comment('É Whatsapp');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
