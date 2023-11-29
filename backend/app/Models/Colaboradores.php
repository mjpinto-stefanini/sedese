<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaboradores extends Model
{
    use HasFactory;
    protected $table = "colaboradores";
    protected $fillable = [
        'id',
        'uuid',
        'parceiros_id',
        'user_id',
    ];
}
