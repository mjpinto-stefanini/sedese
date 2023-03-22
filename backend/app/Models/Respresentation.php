<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respresentation extends Model
{

    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'user_id',
        'representacao_conselho',
        'representacao_titularidade',
        'representacao_representacao',
        'representacao_segmento',
        'representacao_area_representada',
        'outros_reperesentacao_area_representada',
        'created_at',
        'updated_at',
    ];
}
