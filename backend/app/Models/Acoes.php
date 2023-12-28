<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acoes extends Model
{
    use HasFactory, Uuids;

    const TIPO_CAPACITACAO = 'Capacitação';
    const TIPO_FORMACAO = 'Formação';
    const TIPO_APOIO_TECNICO = 'Apoio Técnico';

    const ACAO_REGIONALIZADA_SIM = 1;
    const ACAO_REGIONALIZADA_NAO = 0;
    const ACAO_REGIONALIZADA_NAO_SE_APLICA = 2;

    protected $fillable = [
        'ano',
        'nome',
        'tipo',
        'tematica',
        'tipologia',
        'modalidade',
        'data_inicio',
        'data_fim',
        'num_vagas',
        'acao_regionalizada',
        'areas_envolvidas',
    ];
}
