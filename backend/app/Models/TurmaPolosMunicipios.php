<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurmaPolosMunicipios extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'turma_polo_id',
        'ambito_atuacaos_id',
    ];
}
