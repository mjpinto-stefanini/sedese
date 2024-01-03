<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'user_id',
        'social_name',
        'gender_identity',
        'gender_identity_others',
        'rg',
        'issuing_body',
        'uf',
        'education',
        'profission',
        'profission_others',
        'is_deficiency',
        'deficiency',
        'deficiency_others',
        'deficiency_structure',
        'created_at',
        'updated_at',
    ];

}
