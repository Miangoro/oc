<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class inspecciones extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    protected $table = 'inspecciones';
    protected $primaryKey = 'id_inspeccion';
    protected $fillable = [
        'id_inspeccion',
        'id_solicitud',
        'id_inspector',
        'num_servicio',
        'fecha_servicio',
        'observaciones',
        'estatus_inspeccion',
    ];

    // Método para obtener el nombre del registro que sirve para la trazabilidad
    public function getLogName2(): string
    {
        return 'inspecciones'; // Devuelve el nombre que desees
    }

    public function solicitud()
    {
        return $this->belongsTo(solicitudesModel::class, 'id_solicitud', 'id_solicitud');
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'id_inspector', 'id');
    }

    public function dictamen()
    {
        return $this->hasOne(Dictamen_instalaciones::class, 'id_inspeccion', 'id_inspeccion');
    }


    public function actas_inspeccion()
    {
        return $this->belongsTo(actas_inspeccion::class, 'id_inspeccion', 'id_inspeccion');
    }
    
}

