<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TranslatableActivityLog;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Traits\LogsActivity;

class Certificado_Nacional extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    protected $table = 'certificados_nacional';
    protected $primaryKey = 'id_certificado';
    protected $fillable = [
        'id_certificado',
        'num_certificado',
        'id_solicitud',
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
        return 'certificado de venta nacional'; // Devuelve el nombre que desees
    }

    public function dictamen()// Relación con el modelo Dictamen_Envasado 
    { //ID de tabla actual, ID de la relacion
        return $this->belongsTo(Dictamen_Envasado::class, 'id_dictamen', 'id_dictamen_envasado');
    }

    public function solicitud()
    {
        return $this->hasOne(solicitudesModel::class, 'id_solicitud', 'id_solicitud');
  
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


    //PENDIENTES
    public function revisorPersonal()
    {
        return $this->hasOne(Revisor::class, 'id_certificado')
            ->where('tipo_revision', 1)
            ->where('tipo_certificado', 4);
    }

    public function revisorConsejo()
    {
        return $this->hasOne(Revisor::class, 'id_certificado')
            ->where('tipo_revision', 2)
            ->where('tipo_certificado', 4);
    }


        public function certificadoReexpedido()
    {
        $datos = json_decode($this->observaciones, true);
        if (isset($datos['id_sustituye'])) {
            return Certificados::find($datos['id_sustituye']);
        }
        return null;
    }

public function hologramas(): Collection
{
    $hologramasData = json_decode($this->id_hologramas, true);

    if (!is_array($hologramasData)) {
        return collect();
    }

    // Asegura que sean enteros y únicos
    $ids = collect($hologramasData)
        ->pluck('id')
        ->map(fn($v) => (int) $v)
        ->filter()
        ->unique()
        ->toArray();

    return activarHologramasModelo::with('solicitudHolograma')
        ->whereIn('id', $ids)
        ->get();
}



}
