<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraProductoTerminado extends Model
{
    use HasFactory;
    protected $table = 'bitacora_producto_terminado';
    protected $primaryKey = 'id';
      protected $fillable = [
          'id_empresa',
          'tipo_operacion',
          'tipo',
          'fecha',
          'lote_granel',
          'lote_envasado',
          'id_marca',
          'id_categoria',
          'id_clase',
          'proforma_predio',
          'folio_fq',
          'id_tipo',
          'alc_vol',
          'sku',
          'cantidad_botellas_cajas',
          'ingredientes',
          'edad',
          'cant_cajas_inicial',
          'cant_bot_inicial',
          'procedencia_entrada',
          'cant_cajas_entrada',
          'cant_bot_entrada',
          'destino_salidas',
          'cant_cajas_salidas',
          'cant_bot_salidas',
          'cant_cajas_final',
          'cant_bot_final',
          'observaciones',
          'id_firmante',
      ];

       public $timestamps = false;
       // En BitacoraMezcal.php
/*     public function loteBitacora()
    {
        return $this->belongsTo(LotesGranel::class, 'id_lote_granel', 'id_lote_granel');
    } */
    public function empresaBitacora()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }
    // BitacoraMezcal.php
    public function firmante()
    {
        return $this->belongsTo(User::class, 'id_firmante');
    }


}
