<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actas_inspeccion extends Model
{
    use HasFactory;

    protected $table = 'actas_inspeccion'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_acta'; // Clave primaria de la tabla
    protected $fillable = [
        'id_acta',
        'id_inspeccion',
        'num_acta',
        'categoria_acta',
        'lugar_inspeccion',
        'fecha_inicio',
        'id_empresa',
        'encargado',
        'num_credencial_encargado',
        'testigos',
        'fecha_fin',
        'no_conf_infraestructura',
        'no_conf_equipo',


 
    ];
    
    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }


    public function inspecciones()
    {
        return $this->belongsTo(inspecciones::class,'id_inspeccion', 'id_inspeccion');
    }



    
}