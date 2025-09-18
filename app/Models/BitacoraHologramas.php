<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraHologramas extends Model
{
    use HasFactory;
    protected $table = 'bitacora_hologramas';
    protected $primaryKey = 'id';
       protected $fillable = [
        'fecha',
        'id_empresa',
        'id_instalacion',
        'id_lote_envasado',
        'tipo_operacion',
        'tipo',
        //INVENTARIO INICIAL
        'serie_inicial',
        'num_sellos_inicial',

        //ENTRADA
        'serie_entrada',
        'num_sellos_entrada',

        //SALIDAS
        'serie_salidas',
        'num_sellos_salidas',

        //INVENTARIO FINAL
        'serie_final',
        'num_sellos_final',
        'serie_merma',
        'num_sellos_merma',
        'id_firmante',
        'observaciones',
        'id_usuario_registro',
    ];
       public $timestamps = false;
    public function loteBitacora()
    {
        return $this->belongsTo(lotes_envasado::class, 'id_lote_envasado', 'id_lote_envasado');
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

