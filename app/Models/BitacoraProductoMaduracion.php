<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraProductoMaduracion extends Model
{

    use HasFactory;

       protected $table = 'bitacora_maduracion';
       protected $primaryKey = 'id';
       protected $fillable = [
        'id_empresa',
        'id_instalacion',
        'tipo_operacion',
        'tipo', // 1=Productor, 2=Envasador, 3=Comercializador
        'fecha',
        'id_lote_granel',
        'tipo_recipientes',
        'tipo_madera',
        'num_recipientes',
        'volumen_inicial',
        'alcohol_inicial',
        'num_recipientes_entrada',
        'procedencia_entrada',
        'volumen_entrada',
        'alcohol_entrada',
        'fecha_salida',
        'num_recipientes_salida',
        'volumen_salidas',
        'alcohol_salidas',
        'destino_salidas',
        'num_recipientes_final',
        'volumen_final',
        'alcohol_final',
        'observaciones',
        'id_firmante',
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
    public function registro()
    {
        return $this->belongsTo(User::class, 'id_usuario_registro','id');
    }

}
