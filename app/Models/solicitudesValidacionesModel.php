<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitudesValidacionesModel extends Model
{
    use HasFactory;
    protected $table = 'solicitudes_validaciones';
    protected $primaryKey = 'id_validacion';
    public $timestamps = false;
    protected $fillable = [
        'id_solicitud', 
        'estatus', 
        'tipo_validacion', 
        'id_usaurio', 
        'fecha_realizo', 
        'validacion'
    ];
}
