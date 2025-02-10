<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TranslatableActivityLog;
use Spatie\Activitylog\Traits\LogsActivity;

class Certificado_Exportacion extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    protected $table = 'certificados_exportacion';
    protected $primaryKey = 'id_certificado';
    protected $fillable = [
        'id_certificado',
        'num_certificado',
        'id_dictamen',
        'fecha_emision',
        'fecha_vigencia',
        'id_firmante'
      ];

      // Método para obtener el nombre del registro que sirve para la trazabilidad
        public function getLogName2(): string
        {
            return 'dictamen de instalaciones'; // Devuelve el nombre que desees
        }

      public function inspeccione()
        {
            return $this->belongsTo(inspecciones::class, 'id_inspeccion', 'id_inspeccion');
        }

        public function instalaciones()
        {
            return $this->belongsTo(instalaciones::class, 'id_instalacion', 'id_instalacion');
        }
 
        public function firmante()
        {
            return $this->belongsTo(User::class, 'id_firmante', 'id');
        }
}
