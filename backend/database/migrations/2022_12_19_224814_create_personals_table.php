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
    public function up(): void
    {

        Schema::create('personals', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('ID');
            $table->uuid('user_id')->comment('ID do usuário');
            $table->string('social_name')->nullable()->comment('Nome social');
            $table->string('gender_identity')->comment('Identidade de gênero');
            $table->string('gender_identity_others')->nullable()->comment('Outras identidades de gênero');
            $table->string('rg')->comment('RG');
            $table->string('issuing_body')->comment('Órgão emissor');
            $table->string('uf')->comment('UF');
            $table->string('education')->comment('Escolaridade');
            $table->string('profission')->nullable()->comment('Profissão');
            $table->string('profission_others')->nullable()->comment('Outras profissões');
            $table->boolean('is_deficiency')->default(false)->comment('Possui deficiência');
            $table->string('deficiency')->nullable()->comment('ID da deficiência');
            $table->string('deficiency_others')->nullable()->comment('Outras deficiências');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('personals');
    }
};
