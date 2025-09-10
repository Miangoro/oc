<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class RevisionDictamen extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    protected $table = 'dictamenes_revision';
    protected $primaryKey = 'id_revision';

    protected $fillable = [
        'tipo_revision',
        'id_revisor',
        'id_dictamen',
        'numero_revision',
        'es_correccion',
        'observaciones',
        'respuestas',
        'decision',
        'id_aprobador',
        'aprobacion',
        'fecha_aprobacion',
        'tipo_dictamen'
    ];

    public function getLogName2(): string
    {
        return 'Revisor'; // Devuelve el nombre que desees
    }

    public function dictamenInstalacion()
    {
        return $this->belongsTo(Dictamen_instalaciones::class, 'id_dictamen', 'id_dictamen');
    }
    
    public function dictamenGranel()
    {
        return $this->belongsTo(Dictamen_Granel::class, 'id_dictamen', 'id_dictamen');
    }

    public function dictamenEnvasado()
    {
        return $this->belongsTo(Dictamen_Envasado::class, 'id_dictamen', 'id_dictamen_envasado');
    }

    public function dictamenExportacion()
    {
        return $this->belongsTo(Dictamen_Exportacion::class, 'id_dictamen', 'id_dictamen');
    }


    public function getDictamenAttribute()
    {
        switch ($this->tipo_dictamen) {
            case 1:
                return $this->certificadoNormal;
            case 2:
                return $this->certificadoGranel;
            case 3:
                return $this->dictamenExportacion;
            default:
                return null;
        }
    }




    public function user()
    {
        return $this->belongsTo(User::class, 'id_revisor', 'id'); // id_revisor es la clave foránea en la tabla revisores
    }


    public function aprobador()
    {
        return $this->belongsTo(User::class, 'id_aprobador');
    }

    public function obtenerDocumentosClientes($id_documento, $id_cliente)
    {
        $documento = Documentacion_url::where("id_documento", "=", $id_documento)
            ->where("id_empresa", "=", $id_cliente)
            ->first(); // Devuelve el primer registro que coincida

        return $documento ? $documento->url : null; // Devuelve solo el atributo `url` o `null` si no hay documento
    }

    public function obtenerDocumentoActa($id_documento, $id_solicitud)
    {
        $documento = Documentacion_url::where("id_documento", "=", $id_documento)
            ->where("id_relacion", "=", $id_solicitud)
            ->first(); // Devuelve el primer registro que coincida

        return $documento ? $documento->url : null; // Devuelve solo el atributo `url` o `null` si no hay documento
    }

        public function evidencias()
        {
            return $this->hasMany(Documentacion_url::class, 'id_relacion', 'id_certificado')->where('id_documento',133);
        }
    
}
