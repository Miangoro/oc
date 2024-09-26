<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Predios_Inspeccion extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    protected $table = 'predios_inspeccion';
    protected $primaryKey = 'id_inspeccion';
    protected $fillable = [
      'id_predio',
      'no_orden_servicio',
      'no_cliente',
      'id_empresa',
      'id_tipo_agave',
      'domicilio_fiscal',
      'telefono',
      'ubicacion_predio',
      'localidad',
      'municipio',
      'distrito',
      'id_estado',
      'nombre_paraje',
      'zona_dom',
      'id_tipo_maguey',
      'marco_plantacion',
      'distancia_surcos',
      'distancia_plantas',
      'superficie',
      'fecha_inspeccion',
    ];

    public function getLogName2(): string
    {
        return 'equisde'; // Devuelve el nombre que desees
    }
    // Relación con PredioCoordenadas
    public function coordenadas()
    {
        return $this->hasMany(PredioCoordenadas::class, 'id_inspeccion', 'id_inspeccion');
    }

    // Relación con PredioPlantacion
    public function plantaciones()
    {
        return $this->hasMany(predio_plantacion::class, 'id_inspeccion', 'id_inspeccion');
    }



}
