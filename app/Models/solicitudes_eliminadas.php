<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class solicitudes_eliminadas extends Model
{
    protected $table = 'solicitudes_eliminadas';
    protected $primaryKey = 'id_solicitud';
    protected $fillable = [
        'id_solicitud',
        'motivo',
    ];

    public $timestamps = false;
}
