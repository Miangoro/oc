<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class direcciones extends Model
{
    use HasFactory;

    protected $table = 'direcciones'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_direccion '; // Clave primaria de la tabla
    protected $fillable = [
        'id_direccion',
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
