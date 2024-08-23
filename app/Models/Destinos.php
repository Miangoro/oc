<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destinos extends Model
{
    use HasFactory;

    // Puedes especificar la tabla si no sigue la convención
    protected $table = 'direcciones';

    protected $primaryKey = 'id_direccion'; // Clave primaria de la tabla

    // Define los campos que se pueden llenar de forma masiva
    protected $fillable = [
        'tipo_direccion',
        'id_empresa',
        'direccion',
        'destinatario',
        'aduana',
        'pais_destino',
        'nombre_recibe',
        'correo_recibe',
        'celular_recibe',
    ];
      
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }


}
