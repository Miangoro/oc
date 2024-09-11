<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Dictamen_instalaciones extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;
    protected $table = 'dictamenes_instalaciones';
    protected $primaryKey = 'id_dictamen';
    protected $fillable = [
        'id_dictamen',
        'id_inspeccion',
        'tipo_dictamen',
        'id_instalacion',
        'num_dictamen',
        'fecha_dictamen',
        'fecha_vigencia',
        'categorias',
        'clases',
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
            return $this->belongsTo(Instalaciones::class, 'id_instalacion', 'id_instalacion');
        }

        Public function certificado()
        {
            return $this->belongsTo(Certificados::class, 'id_certificado', 'id_certificado');   
        }        
}
