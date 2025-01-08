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
    public function collection()
    {
      return solicitudesModel::with('empresa', 'tipo_solicitud', 'instalaciones','predios')->get([
        'id_solicitud',
        'id_empresa', //esta deberia ser razon social de la tbala empresas
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
            ['Reporte de Solicitudes'], // Título del reporte
            ['ID Solicitud', 'ID Empresa', 'ID Tipo', 'Folio', 'Estatus', 'Fecha Solicitud', 'Fecha Visita', 'ID Instalación' /* domicilio de inspeccion */, 'ID Predio' /* domicilio predio */, 'Información Adicional', 'Características'], // Encabezados de las columnas
        ];
    }
    /**
     * Aplicar estilos usando eventos.
     */    public function map($solicitud): array
    {

      return [
          $solicitud->id_solicitud, // ID de la solicitud
          $solicitud->empresa ? $solicitud->empresa->razon_social : 'N/A',
          $solicitud->tipo_solicitud->tipo, // Tipo de solicitud
          $solicitud->folio, // Folio de la solicitud
          $solicitud->estatus, // Estatus de la solicitud
          Carbon::parse($solicitud->fecha_solicitud)->translatedFormat('d \d\e F \d\e Y h:i A'), // Fecha de la solicitud con formato traducido
          Carbon::parse($solicitud->fecha_visita)->translatedFormat('d \d\e F \d\e Y h:i A'), // Fecha de la visita (formato: dd/mm/yyyy)
          $solicitud->instalacion->direccion_completa ?? ($solicitud->predios->ubicacion_predio ?? '-----------------'), // ID de la instalación
          $solicitud->id_predio, // ID del predio
          $solicitud->info_adicional, // Información adicional
          $solicitud->caracteristicas, // Características
      ];
  }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // 1. Título principal (A1:K1)
                $sheet->mergeCells('A1:K1'); // Asegúrate de que el rango cubra todas las columnas
                $sheet->getStyle('A1:K1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(14)
                    ->getColor()->setARGB('000000'); // Color de texto black (código ARGB)
                $sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:K1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A1:K1')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('4a608f'); // Color de fondo azul

                // 2. Encabezados (A2:K2)
                $sheet->getStyle('A2:K2')
                    ->getFont()
                    ->setBold(true)
                    ->getColor()->setARGB('FFFFFF'); // Color de texto blanco (código ARGB)
                $sheet->getStyle('A2:K2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A2:K2')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('4a608f'); // Color de fondo azul

                // 3. Aplicar color de fondo gris claro a las celdas de datos (A3:K{lastRow})
                $lastRow = $event->sheet->getHighestRow(); // Obtiene la última fila
                $sheet->getStyle('A3:K' . $lastRow)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('f2f2f2'); // Gris claro para todas las filas de datos

                // 4. Aplicar bordes y ancho de columnas automáticos
                foreach (range('A', 'K') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // 5. Ajuste adicional de bordes (si lo necesitas)
                $sheet->getStyle('A2:K'.($event->sheet->getHighestRow()))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }


}
