<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catalogo_clasificacion_bebidas extends Model
{
    //
    use HasFactory;
    protected $table = 'catalogo_clasificacion_bebidas';
    protected $primaryKey = 'id_clasificacion';
    protected $fillable = [
        'nombre'
    ];


}
