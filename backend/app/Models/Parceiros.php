<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parceiros extends Model
{
    use HasFactory;
    protected $table = "parceiros";
    protected $fillable = [
        'id',
        'uuid',
        'nome_instituicao',
        'CNPJ',
        'status',
        'responsavel_legal',
        'CPF',
        'telefone',
        'email',
        'observacao',
    ];
}
