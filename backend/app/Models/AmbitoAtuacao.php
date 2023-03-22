<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbitoAtuacao extends Model
{
    use HasFactory, Uuids;

    const ESTADO = 1;
    const MUNICIPIO = 2;

    protected $fillable = [
        'id',
        'nome',
        'regiao_administrativa',
        'ativo',
        'outro',
        'outro_nome',
    ];
}
