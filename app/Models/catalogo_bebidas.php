<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class catalogo_bebidas extends Model
{
    //
     use HasFactory;

    protected $table = 'catalogo_bebidas';
    protected $primaryKey = 'id_bebida';
    public $timestamps = false; // Si tu tabla no tiene created_at y updated_at

    protected $fillable = [
        'id_clasificacion', // Relaciona con catalogo_clasificacion_bebidas
        'nombre'
    ];

    // Relación con la clasificación
    public function clasificacion()
    {
        return $this->belongsTo(catalogo_clasificacion_bebidas::class, 'id_clasificacion', 'id_clasificacion');
    }
}
