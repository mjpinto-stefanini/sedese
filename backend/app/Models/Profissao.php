<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profissao extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'nome',
        'outro',
        'outro_nome',
    ];
}
