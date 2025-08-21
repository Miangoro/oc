<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class respuesta_bebidas extends Model
{
    //
      use HasFactory;

    protected $table = 'respuesta_bebidas';
    protected $primaryKey = 'id_respuesta';
    public $timestamps = false; // Como solo tienes created_at y no updated_at

    protected $fillable = [
        'id_empresa',
        'id_clasificacion',
        'id_bebida',
        'bebida_personalizada',
        'created_at'
    ];

    // Relación opcional con catalogo_bebidas
    public function catalogoBebida()
    {
        return $this->belongsTo(catalogo_bebidas::class, 'id_bebida', 'id_bebida');
    }

    // Relación opcional con catalogo_clasificacion_bebidas
    public function clasificacion()
    {
        return $this->belongsTo(catalogo_clasificacion_bebidas::class, 'id_clasificacion', 'id_clasificacion');
    }
}
