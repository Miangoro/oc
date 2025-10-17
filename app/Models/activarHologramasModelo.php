<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activarHologramasModelo extends Model
{
    use HasFactory;

    protected $table = 'activar_hologramas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_inspeccion',
        'folio_activacion',
        'no_lote_agranel',
        'categoria',
        'no_analisis',
        'cont_neto',
        'unidad',
        'clase',
        'contenido',
        'no_lote_envasado',
        'id_tipo',
        'lugar_produccion',
        'lugar_envasado',
        'id_solicitud',
        'folios',



    ];

    protected $casts = [
    'id_tipo' => 'array',
        ];



    public function inspeccion()
    {
        return $this->belongsTo(inspecciones::class, 'id_inspeccion');
    }

    public function categorias()
    {
        return $this->belongsTo(categorias::class, 'categoria','id_categoria');
    }

    public function clases()
    {
        return $this->belongsTo(clases::class, 'clase','id_clase');
    }

    public function solicitudHolograma()
    {
        return $this->belongsTo(solicitudHolograma::class, 'id_solicitud');
    }

public function tipos()
{
    $ids = $this->id_tipo;

    // Si es JSON (array de IDs)
    if (is_array($ids)) {
        // Convertir a enteros o strings según el tipo de tus IDs
        $ids = array_map('intval', $ids);

        return tipos::whereIn('id_tipo', $ids)
            ->orderByRaw('FIELD(id_tipo, ' . implode(',', $ids) . ')') // mantiene el orden
            ->get();
    }

    // Si sigue siendo entero (compatibilidad con datos viejos)
    return tipos::where('id_tipo', $ids)->get();
}

// Dentro de activarHologramasModelo
public function getTiposAttribute()
{
    $ids = $this->id_tipo ?? [];

    // Si viene como string con un solo id (compatibilidad)
    if (!is_array($ids)) {
        // si está vacío o nulo, devolver colección vacía
        if ($ids === null || $ids === '') {
            return collect();
        }
        $ids = [$ids];
    }

    // Normalizar a enteros o strings según necesites (aquí uso integers)
    $ids = array_values(array_map('intval', $ids));

    if (empty($ids)) {
        return collect();
    }

    // Construir placeholders para bindings: ?,?,?
    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    // Usamos orderByRaw con bindings para FIELD(...) y evitar inyección
    // Nota: ajusta 'id_tipo' si en la tabla de tipos tu PK tiene otro nombre
    $query = \App\Models\tipos::whereIn('id_tipo', $ids)
        ->orderByRaw("FIELD(id_tipo, {$placeholders})", $ids);

    return $query->get();
}




public function activarHologramasDesdeVariasSolicitudes($solicitudes, $folios)
{
    // Buscamos si alguno de estos folios ya ha sido activado
    $foliosExistentes = $this->whereRaw("FIND_IN_SET(folios, ?) > 0", [implode(',', $folios)])->pluck('folios')->toArray();
    $foliosExistentes = array_unique(explode(',', implode(',', $foliosExistentes))); // Convertimos en un array único

    // Filtramos solo los folios que aún no han sido activados
    $foliosNuevos = array_diff($folios, $foliosExistentes);

    if (!empty($foliosNuevos)) {
        // Creamos una nueva activación
        $this->create([
            'id_solicitud' => implode(',', $solicitudes),  // Guardamos múltiples solicitudes en una sola activación
            'folios'       => implode(',', $foliosNuevos),
            'estado'       => 'activado'
        ]);
    }
}

 public function cantidadActivando(): int
    {
        $folios = json_decode($this->folios, true) ?? [];
        $folio_inicial = $folios['folio_inicial'] ?? [];
        $folio_final = $folios['folio_final'] ?? [];

        $total = 0;

        foreach ($folio_inicial as $index => $inicio) {
            $fin = $folio_final[$index] ?? $inicio;
            $total += ((int)$fin - (int)$inicio + 1);
        }

        return $total;
    }


}