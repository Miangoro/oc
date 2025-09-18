<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraProductoEtiqueta extends Model
{
   use HasFactory;
    protected $table = 'bitacora_producto_sin_etiqueta';
    protected $primaryKey = 'id';
      protected $fillable = [
          'id_empresa',
          'id_instalacion',
          'tipo_operacion',
          'tipo',
          'fecha',
          'id_lote_granel',
          'id_lote_envasado',
          'id_marca',
          'id_categoria',
          'id_clase',
          'folio_fq',
          'id_tipo',
          'cantidad_botellas_cajas',
          'ingredientes',
          'edad',
          'alcohol_inicial',
          'cant_cajas_inicial',
          'cant_bot_inicial',

          'capacidad',
          'procedencia_entrada',
          'cant_cajas_entrada',
          'cant_bot_entrada',

          'destino_salidas',
          'cant_cajas_salidas',
          'cant_bot_salidas',

          'cant_cajas_final',
          'cant_bot_final',

          'observaciones',

          'mermas',
          'id_firmante',
          'id_usuario_registro',
      ];

       public $timestamps = false;
   public function loteGranelBitacora()
    {
        return $this->belongsTo(LotesGranel::class, 'id_lote_granel', 'id_lote_granel');
    }
        public function loteBitacora()
    {
        return $this->belongsTo(lotes_envasado::class, 'id_lote_envasado', 'id_lote_envasado');
    }
       // En BitacoraMezcal.php
    public function marca()
    {
        return $this->belongsTo(marcas::class, 'id_marca', 'id_marca');
    }
        public function categorias()
    {
        return $this->belongsTo(categorias::class, 'id_categoria', 'id_categoria');
    }
        public function clases()
    {
        return $this->belongsTo(clases::class, 'id_clase', 'id_clase');
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
    public function getTiposAgaveAttribute()
    {
        $ids = json_decode($this->id_tipo ?? '[]', true);
        return tipos::whereIn('id_tipo', $ids)->get();
    }

    public function instalacion()
    {
        return $this->belongsTo(instalaciones::class, 'id_instalacion','id_instalacion');
    }
    public function registro()
    {
        return $this->belongsTo(User::class, 'id_usuario_registro','id');
    }

}
