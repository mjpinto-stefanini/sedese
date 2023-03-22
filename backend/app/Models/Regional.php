<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];
}
