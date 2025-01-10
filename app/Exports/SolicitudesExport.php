<?php

namespace App\Exports;

use App\Models\solicitudesModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SolicitudesExport implements FromCollection, WithHeadings, WithEvents, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $filtros;

    // Recibir los filtros desde el controlador
    public function __construct($filtros)
    {
        // Asignar filtros con valores predeterminados vacíos si no están definidos
        $this->filtros = $filtros ?: [
            'id_empresa' => null,
            'anio' => null,
            'estatus' => null,
            'mes' => null,
        ];
    }

    public function collection()
    {
        $query = SolicitudesModel::with('empresa', 'tipo_solicitud', 'instalaciones', 'predios');

        // Aplicar filtros según lo que se haya enviado
        if (isset($this->filtros['id_empresa']) && $this->filtros['id_empresa']) {
            $query->where('id_empresa', $this->filtros['id_empresa']);
        }

        if (isset($this->filtros['anio']) && $this->filtros['anio']) {
            $query->whereYear('fecha_solicitud', $this->filtros['anio']);
        }

        if (isset($this->filtros['estatus']) && $this->filtros['estatus'] && $this->filtros['estatus'] != 'todos') {
            $query->where('estatus', $this->filtros['estatus']);
        }

        if (isset($this->filtros['mes']) && $this->filtros['mes']) {
            $query->whereMonth('fecha_solicitud', $this->filtros['mes']);
        }

        return $query->get([
            'id_solicitud',
            'id_empresa',
            'id_tipo',
            'folio',
            'estatus',
            'fecha_solicitud',
            'fecha_visita',
            'id_instalacion',
            'id_predio',
            'info_adicional',
            'caracteristicas'
        ]);
    }

    /**
     * Definir los encabezados de la tabla.
     */
    public function headings(): array
    {
        return [
            ['Reporte de Solicitudes'],
            ['ID Solicitud', 'Empresa', 'Tipo de solicitud', 'Folio', 'Estatus', 'Fecha de Solicitud', 'Fecha de Visita', 'Domicilio de Inspeccion o Predio', 'Información Adicional'],
        ];
    }
    /**
     * Aplicar estilos usando eventos.
     */
    // Mapear los datos para la exportación
    public function map($solicitud): array
    {
        return [
            $solicitud->id_solicitud,
            $solicitud->empresa ? $solicitud->empresa->razon_social : 'N/A',
            $solicitud->tipo_solicitud->tipo,
            $solicitud->folio,
            $solicitud->estatus,
            Carbon::parse($solicitud->fecha_solicitud)->translatedFormat('d \d\e F \d\e Y h:i A'),
            Carbon::parse($solicitud->fecha_visita)->translatedFormat('d \d\e F \d\e Y h:i A'),
            $solicitud->instalacion->direccion_completa ?? ($solicitud->predios->ubicacion_predio ?? '-----------------'),
            $solicitud->info_adicional,
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:I1');
                $sheet->getStyle('A1:I1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(14)
                    ->getColor()->setARGB('FFFFFF');
                $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:I1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A1:I1')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('008000');

                $sheet->getStyle('A2:I2')
                    ->getFont()
                    ->setBold(true)
                    ->getColor()->setARGB('FFFFFF');
                $sheet->getStyle('A2:I2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A2:I2')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('4a608f');

                $lastRow = $event->sheet->getHighestRow();
                $sheet->getStyle('A3:I' . $lastRow)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('f2f2f2');

                foreach (range('A', 'I') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                $sheet->getStyle('A2:I'.($event->sheet->getHighestRow()))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }


}
