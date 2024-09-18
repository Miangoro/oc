<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actas_produccion extends Model
{
    use HasFactory;

    protected $table = 'actas_produccion'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_produccion'; // Clave primaria de la tabla
    protected $fillable = [
        'id_produccion',
        'id_acta',
        'id_predio',
        'nom_predio',
        'espacio_agave',
        'superficie',
        'madurez_agave',
        'plagas',
        'cant_plantas',
        'coordenadas',


 
    ];
    


    public function predios()
    {
        return $this->belongsTo(Predios::class,'id_predio', 'nom_predio');
    }



    
}
