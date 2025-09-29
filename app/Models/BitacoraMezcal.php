<?php

namespace App\Models;
/* use App\Models\LotesGranel; */
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraMezcal extends Model
{
    use HasFactory;
    protected $table = 'bitacora_mezcal';
    protected $primaryKey = 'id';

    protected $fillable = [
        'fecha',
        'id_tanque',
        'id_empresa',
        'nombre_lote',
        'id_lote_granel',
        'id_lote_granel_destino',
        'id_instalacion',
        'operacion_adicional',
        'tipo_operacion',
        'tipo',
        //INVENTARIO INICIAL
        'volumen_inicial',
        'alcohol_inicial',

        //ENTRADA
        'procedencia_entrada',
        'volumen_entrada',
        'alcohol_entrada',
        'agua_entrada',

        //SALIDAS
        'volumen_salidas',
        'alcohol_salidas',
        'destino_salidas',

        //INVENTARIO FINAL
        'volumen_final',
        'alcohol_final',
        'id_firmante',
        'observaciones',
        'id_usuario_registro',
    ];
       public $timestamps = false;
       // En BitacoraMezcal.php
    public function loteBitacora()
    {
        return $this->belongsTo(LotesGranel::class, 'id_lote_granel', 'id_lote_granel');
    }
    public function empresaBitacora()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }
    // BitacoraMezcal.php
    public function firmante()
    {
        return $this->belongsTo(User::class, 'id_firmante');
    }

    public function instalacion()
    {
        return $this->belongsTo(instalaciones::class, 'id_instalacion','id_instalacion');
    }

    public function lotesProcedencia()
    {
        return $this->hasMany(LotesGranel::class, 'lote_original_id', 'id_lote_granel');
    }

    public function registro()
    {
        return $this->belongsTo(User::class, 'id_usuario_registro','id');
    }

}
