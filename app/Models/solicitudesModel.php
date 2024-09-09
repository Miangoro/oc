<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class solicitudesModel extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    protected $table = 'solicitudes';
    protected $primaryKey = 'id_solicitud';
    protected $fillable = [
        'id_empresa',
        'id_tipo',
        'folio',
        'fecha_visita',
        'id_instalacion'
    ];

    // Método para obtener el nombre del registro que sirve para la trazabilidad
    public function getLogName2(): string
    {
        return 'solicitud'; // Devuelve el nombre que desees
    }

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }

    public function inspeccion()
    {
        return $this->hasOne(inspecciones::class, 'id_solicitud', 'id_solicitud');
    }

    public function inspector()
    {
        return $this->hasOneThrough(User::class, inspecciones::class, 'id_solicitud', 'id', 'id_solicitud', 'id_inspector');
    }

    public function instalacion()
    {
        return $this->hasOne(Instalaciones::class, 'id_instalacion', 'id_instalacion');
    }

    public function tipo_solicitud()
    {
        return $this->hasOne(solicitudTipo::class, 'id_tipo', 'id_tipo');
    }


    
}
