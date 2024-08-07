<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class predio_plantacion extends Model
{
    use HasFactory;

    protected $table = 'predio_plantacion'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_plantacion'; // Clave primaria de la tabla
    protected $fillable = [
        'id_plantacion',
        'id_predio', // Asegúrate de que el nombre del campo sea correcto en la tabla
        'id_tipo',
        'num_plantas',
        'anio_plantacion',
        'tipo_plantacion',
    ];
    
    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }
    public function tipo()
    {
        return $this->belongsTo(Tipos::class, 'id_tipo');
    }
    
}
