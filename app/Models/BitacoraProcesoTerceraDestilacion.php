<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraProcesoTerceraDestilacion extends Model
{

      use HasFactory;

    protected $table = 'bitacora_tercera_destilacion';
    protected $primaryKey = 'id'; // Laravel usa esto por defecto, puedes omitirlo

    protected $fillable = [
        'id_bitacora',
        'fecha_destilacion',
        'puntas_volumen',
        'puntas_porcentaje',
        'mezcal_volumen',
        'mezcal_porcentaje',
        'colas_volumen',
        'colas_porcentaje',
    ];

    public $timestamps = true; // opcional, ya que Laravel lo asume por default si tienes created_at y updated_at

    /**
     * Relación con la bitácora principal (si decides usarla desde modelos).
     */
    public function bitacora()
    {
        return $this->belongsTo(BitacoraProcesoElaboracion::class, 'id_bitacora');
    }

}
