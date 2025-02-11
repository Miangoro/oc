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

      public function dictamen()
        {
            return $this->belongsTo(Dictamen_Exportacion::class, 'id_dictamen', 'id_dictamen');
        }

      // Método para obtener el nombre del registro que sirve para la trazabilidad
        public function getLogName2(): string
        {
            return 'certificado de exportación'; // Devuelve el nombre que desees
        }
}
