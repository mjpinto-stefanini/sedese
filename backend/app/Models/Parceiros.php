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
        'user_id',
        'nome_instituicao',
        'CNPJ',
        'status',
        'phone',
        'observacao',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
