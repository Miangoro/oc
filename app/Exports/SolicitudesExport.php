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
        $this->filtros = $filtros;
    }

    public function collection()
    {
        $query = SolicitudesModel::with('empresa', 'tipo_solicitud', 'instalaciones', 'predios', 'inspeccion', 'inspector');
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
            ['Folio', 'No. de Servicio', 'Empresa', 'Tipo de solicitud',  'Inspector','Estatus', 'Fecha de Solicitud', 'Fecha de Visita', 'Domicilio de Inspeccion o Predio', 'Información Adicional'],
        ];
    }
    /**
     * Aplicar estilos usando eventos.
     */
    // Mapear los datos para la exportación
    public function map($solicitud): array
    {
        return [
            $solicitud->folio,
            $solicitud->inspeccion->num_servicio ?? 'N/A',
            $solicitud->empresa ? ($solicitud->empresa->empresaNumClientes[0]->numero_cliente ?? $solicitud->empresa->empresaNumClientes[1]->numero_cliente) . ' | ' . $solicitud->empresa->razon_social : '',
            $solicitud->tipo_solicitud->tipo,
            $solicitud->inspector ? $solicitud->inspector->name : 'N/A',
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
                $sheet->getRowDimension(1)->setRowHeight(30); // Ajusta la altura de la fila 1
                $sheet->mergeCells('A1:J1');
                $sheet->getStyle('A1:J1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(14)
                    ->getColor()->setARGB('000000');
                $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:J1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A1:J1')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FFFFFF');

                $sheet->getStyle('A2:J2')
                    ->getFont()
                    ->setBold(true)
                    ->getColor()->setARGB('000000');
                $sheet->getStyle('A2:J2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A2:J2')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('8eaadc');

                $sheet->getStyle('C2')->getFill()->setFillType(Fill::FILL_SOLID);
                $sheet->getStyle('C2')->getFill()->getStartColor()->setARGB('ffc001'); // Cambia el color de fondo
                $sheet->getStyle('C2')->getFont()->setBold(true); // Hacerlo en negrita
                $sheet->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Establecer colores personalizados para el estatus
                $lastRow = $event->sheet->getHighestRow();
                $isOdd = true; // Variable para alternar colores de fila

                for ($row = 3; $row <= $lastRow; $row++) {
                    $estatus = $sheet->getCell("F{$row}")->getValue(); // Suponiendo que el estatus está en la columna F

                    // Alternar colores de fondo de las filas
                    if ($isOdd) {
                        // Color de fondo alterno (gris claro)
                        $sheet->getStyle("A{$row}:J{$row}")
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('f2f2f2'); // Gris claro
                    } else {
                        // Otro color de fondo alterno (blanco)
                        $sheet->getStyle("A{$row}:J{$row}")
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFFFF'); // Blanco
                    }

                    // Aplicar color según el valor de "Estatus" en la columna F
                    if ($estatus == 'Pendiente') {
                        $sheet->getStyle("F{$row}")
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('eddb94'); // Amarillo suave
                    } elseif ($estatus == 'Con acta') {
                        $sheet->getStyle("F{$row}")
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('d6edcb'); // Verde suave
                    } else {
                        $sheet->getStyle("F{$row}")
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('D3D3D3'); // Gris claro
                    }

                    // Alternar la variable $isOdd entre verdadero y falso
                    $isOdd = !$isOdd;
                }

                // Formato general para las celdas
                foreach (range('A', 'J') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Bordes finos para todas las celdas
                $sheet->getStyle('A2:J'.($event->sheet->getHighestRow()))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }




}
