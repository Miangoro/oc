<?php

namespace App\Models;

use App\Exports\CertificadosExport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TranslatableActivityLog;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Collection;

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
        'id_firmante',
        'estatus',
        'observaciones',
      ];

      protected $casts = [
    'hologramas' => 'array',
];

    // Método para obtener el nombre del registro que sirve para la trazabilidad
    public function getLogName2(): string
    {
        return 'certificado de exportación'; // Devuelve el nombre que desees
    }

    // Relación con el modelo Dictamen_Exportacion (dictamenes)
    public function dictamen()
    {
        return $this->belongsTo(Dictamen_Exportacion::class, 'id_dictamen', 'id_dictamen');
    }

    // Relación con el modelo User (Firmante)
    public function firmante()
    {
        return $this->belongsTo(User::class, 'id_firmante', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_firmante', 'id'); 
    }

    public function revisorPersonal()
    {
        return $this->hasOne(Revisor::class, 'id_certificado')
            ->where('tipo_revision', 1)
            ->where('tipo_certificado', 3);
    }

    public function revisorConsejo()
    {
        return $this->hasOne(Revisor::class, 'id_certificado')
            ->where('tipo_revision', 2)
            ->where('tipo_certificado', 3);
    }


    public function certificadoReexpedido()
    {
        $datos = json_decode($this->observaciones, true);
        if (isset($datos['id_sustituye'])) {
            return Certificado_Exportacion::find($datos['id_sustituye']);
        }
        return null;
    }

           public function certificadoEscaneado()
    {
        return $this->hasMany(Documentacion_url::class, 'id_relacion', 'id_certificado')->where('id_documento', 135);
    }

    
 public function hologramas(): Collection
{
    $hologramasData = json_decode($this->id_hologramas, true);

    if (!$hologramasData || !is_array($hologramasData)) {
        return collect();
    }

    $ids = collect($hologramasData)->pluck('id')->filter()->unique()->toArray();

    // 👇 Incluye la relación
    return activarHologramasModelo::with('solicitudHolograma')
        ->whereIn('id', $ids)
        ->get();
}


}
