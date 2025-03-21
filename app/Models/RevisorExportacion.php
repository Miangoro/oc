<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class RevisorExportacion extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    protected $table = 'certificados_revision_exportacion';
    protected $primaryKey = 'id_revision'; 

    protected $fillable = [
        'id_revision',
        'id_certificado',
        'tipo_revision',
        'id_revisor',
        'id_revisor2', 
        'numero_revision',
        'es_correccion',
        'observaciones',
        'respuestas',
        'desicion',
        'id_aprobador',
        'aprobacion',
        'fecha_aprobacion'  
    ];

    public function getLogName2(): string
    {
        return 'Revisor'; // Devuelve el nombre que desees
    }

    // Relación inversa con Certificados
    public function certificado()
    {
        return $this->belongsTo(Certificado_Exportacion::class, 'id_certificado', 'id_certificado');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_revisor', 'id'); // id_revisor es la clave foránea en la tabla revisores
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'id_revisor2', 'id'); // id_revisor2 es la clave foránea en la tabla revisores
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

}