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
        'responsable',
        'fecha_eliminacion',
        'tipo'
    ];

    public $timestamps = false;

    public function motivo(){
      return $this->belongsTo(solicitudesModel::class, 'id_solicitud', 'id_solicitud');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'responsable', 'id');
    }

}
