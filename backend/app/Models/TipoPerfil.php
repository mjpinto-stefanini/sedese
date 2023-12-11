<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPerfil extends Model
{
    use HasFactory, Uuids;

    protected $table = 'tipo_perfil';

    const RESPONSAVEL_TECNICO = 1;
    const PARTICIPANTE = 2;
    const COLABORADOR = 3;

    protected $fillable = [
        'id',
        'nome'
    ];
}
