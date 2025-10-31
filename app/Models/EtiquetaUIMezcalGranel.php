<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EtiquetaUIMezcalGranel extends Model
{
    use HasFactory;

    protected $table = 'etiqueta_mezcal_granel';
    protected $primaryKey = 'id'; // Clave primaria
    public $timestamps = false; // Desactivar created_at / updated_at
    // Campos comunes de todas las tablas
    protected $fillable = [
        'fecha_servicio',
        'num_servicio',
        'razon_social',
        'nombre_lote',
        'volumen',
        'folio_fq',
        'categoria',
        'clase',
        'tipo_agave',
        'edad',
        'tanque',
        'ingredientes',
        'num_certificado',
        'inspector',
        'responsable',
    ];


    /*public function getLogName2(): string
    {
        return 'Revisor'; // Devuelve el nombre que desees
    }*/

}

/*
// 1. Mezcal a granel
class EtiquetaMezcalGranel extends EtiquetasUI
{
    protected $table = 'etiqueta_mezcal_granel';

    protected $fillable = [
        'id_tanque',
        'n_certificado',
    ];
}

// 2. Agave ART
class EtiquetaAgaveArt extends EtiquetasUI
{
    protected $table = 'etiqueta_agave_art';

    protected $fillable = [
        'peso_maguey',
        'n_pinas',
        'n_pinas_anterior',
        'n_pinas_restantes',
        'domicilio',
        'n_guias',
        'maguey',
        'maestro_mezcalero',
        'edad'
    ];
}

// 3. Tapa muestra
class EtiquetaTapaMuestra extends EtiquetasUI
{
    protected $table = 'etiqueta_tapa_muestra';

    protected $fillable = [
        'producto',
        'lote_procedencia',
        'clase',
        'edad',
        'ingredientes',
        'destino',
        'n_fisicoquimico_tanque',
        'estado_productor',
        'domicilio',
        't_analisis',
        'especifique',
        'id_tanque',
        'n_certificado',
        'edad_tanque',
        'ing_tanque'
    ];
}

// 4. Ingreso maduración
class EtiquetaIngresoMaduracion extends EtiquetasUI
{
    protected $table = 'etiqueta_ingreso_maduracion';

    protected $fillable = [
        'razon_social',
        'id_inspector',
        'responsable',
        'n_servicio',
        'fecha',
        'n_lote',
        'categoria',
        'clase',
        'fisicoquimico',
        'grado_alc',
        'barrica',
        'de',
        'fecha_registro',
        'persona_registro',
        'habilitado'
    ];
}*/