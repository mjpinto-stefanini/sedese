<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurmaEndereco extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'turmas_id',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'street',
    ];
}
