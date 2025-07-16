<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraProcesoMoliendaDestilacion extends Model
{
    use HasFactory;

    protected $table = 'bitacora_molienda_destilacion';
    protected $primaryKey = 'id'; // Laravel lo asume por default

    protected $fillable = [
        'id_bitacora',
        'fecha_molienda',
        'numero_tina',
        'fecha_formulacion',
        'volumen_formulacion',
        'fecha_destilacion',
        'puntas_volumen',
        'puntas_porcentaje',
        'mezcal_volumen',
        'mezcal_porcentaje',
        'colas_volumen',
        'colas_porcentaje',
    ];

    public $timestamps = true; // Laravel manejará created_at y updated_at

    /**
     * Relación con la bitácora principal (opcional, si decides usar Eloquent relationships).
     */
    public function bitacora()
    {
        return $this->belongsTo(BitacoraProcesoElaboracion::class, 'id_bitacora');
    }
}
