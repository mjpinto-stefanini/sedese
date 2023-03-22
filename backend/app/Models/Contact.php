<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'id',
        'user_id',
        'phone',
        'cell_phone',
        'cell_phone_whatsapp',
        'institutional_phone',
        'institutional_email',
        'isWhatsapp',
        'created_at',
        'updated_at',
    ];
}
