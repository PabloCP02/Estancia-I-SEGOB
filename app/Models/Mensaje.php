<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'receiver_id',
        'mensaje',
    ];

    // Relación con el modelo User para el remitente (usuario que envía el mensaje)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el modelo User para el receptor (usuario que recibe el mensaje)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
