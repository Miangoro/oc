<?php

namespace App\Exports;

use App\Models\Guias;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class GuiasExport implements FromCollection, WithHeadings
{
    protected $filtros;
    /**
     * Constructor para recibir filtros.
     *
     * @param array $filtros
     */


    public function __construct(array $filtros = [])
    {
        $this->filtros = $filtros;
    }
    /**
     * Retorna la colección de predios filtrados.
     *
     * @return \Illuminate\Support\Collection
     */


    public function collection()
    {
        $query = Guias::query();

        // Aplicar filtros opcionales
        if (!empty($this->filtros['id_empresa'])) {
            $query->where('id_empresa', $this->filtros['id_empresa']);
        }

        if (!empty($this->filtros['anio'])) {
            $query->whereYear('created_at', $this->filtros['anio']);
        }

        if (!empty($this->filtros['mes'])) {
            $query->whereMonth('created_at', $this->filtros['mes']);
        }

        // Selecciona los campos que quieres exportar
        // Traer la colección
        $guias = $query->select(
            'folio',
            'num_anterior',
            'num_comercializadas',
            'numero_plantas',
        )
        ->orderBy('id_guia', 'desc') // <-- orden descendente
        ->get();

            // Agregar numerador automático
            return $guias->map(function($guia, $index) {
                return [
                    '#'                   => $index + 1,
                    'Guias'               => $guia->folio,
                    'Anteriores'          => $guia->num_anterior,
                    'Comercializadas'     => $guia->num_comercializadas,
                    'Actuales'            => $guia->numero_plantas,
                ];
            });
    }
    /**
     * Encabezados de las columnas en el Excel.
     *
     * @return array
     */


    public function headings(): array//ENCABEZADOS
    {
        return [
            '#', 'Guias', 'Anteriores', 'Comercializadas', 'Actuales'
        ];
    }
    


}
