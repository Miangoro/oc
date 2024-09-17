<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actas_testigo extends Model
{
    use HasFactory;

    protected $table = 'actas_testigo'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_acta_testigo '; // Clave primaria de la tabla
    protected $fillable = [
        'id_acta_testigo ',
        'id_acta',
        'nombre_testigo',
        'domicilio',



 
    ];
    






    
}
