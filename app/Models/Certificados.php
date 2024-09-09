<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Certificados extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;
    protected $table = 'certificados';
    protected $primaryKey = 'id_certificado';

    protected $fillable = [
        'id_dictamen',
        'id_firmante',
        'id_empresa',
        'num_certificado',
        'fecha_vigencia',
        'fecha_vencimiento',
        'maestro_mezcalero',
        'num_autorizacion',
    ];

      // Método para obtener el nombre del registro que sirve para la trazabilidad
      public function getLogName2(): string
      {
          return 'certificados'; // Devuelve el nombre que desees
      }

    public function dictamen()
    {
        return $this->belongsTo(Dictamen_instalaciones::class, 'id_dictamen', 'id_dictamen');
    }
    
    // Relación con el modelo User
    public function firmante()
    {
        return $this->belongsTo(User::class, 'id_firmante', 'id');
    }

    // Relación con Empresa
    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa', 'id');
    }
}
