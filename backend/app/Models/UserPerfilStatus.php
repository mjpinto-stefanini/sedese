<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPerfilStatus extends Model
{
    use HasFactory, Uuids;

    const STATUS_ATIVO = 1;
    const STATUS_INATIVO = 2;
    const STATUS_PENDENTE = 3;
    const STATUS_REJEITADO = 4;

    protected $table = 'users_perfil_status';

    protected $fillable = [
        'id',
        'user_id',
        'tipo_perfil_id',
        'status'
    ];

    public function tipoPerfil()
    {
        return $this->belongsTo(TipoPerfil::class, 'tipo_perfil_id');
    }
}
