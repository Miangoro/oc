<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activarHologramasModelo extends Model
{
    use HasFactory;

    protected $table = 'activar_hologramas';
    protected $primaryKey = 'id_activacion';
    protected $fillable = [
  
        'id_solicitud'
    ];
}
