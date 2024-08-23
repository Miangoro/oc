<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hologramas extends Model
{
    use HasFactory;

    protected $table = 'solicitud_hologramas'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_solicitud'; // Clave primaria de la tabla
    protected $fillable = [
        'id_solicitud',
        'folio',
        'id_empresa',
        'id_solicitante',
        'id_marca',
        'cantidad_hologramas',
        'id_direccion',
        'comentarios',
 
    ];
    
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }


}

