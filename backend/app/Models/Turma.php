<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'nome',
        'turma_endereco_id',
        'turma_ferramenta_id',
        'turma_data_inicio',
        'turma_data_fim',
        'carga_horaria_aula',
        'carga_horaria_total',
        'turma_periodo',
        'quantidade_vagas_estaduais',
        'quantidade_vagas_municipais',
        'inscricoes_data_inicio',
        'inscricoes_data_fim',
        'perfil_participantes',
        'criterio_certificacao',
    ];

}
