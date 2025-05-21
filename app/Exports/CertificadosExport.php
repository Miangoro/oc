<?php

namespace App\Exports;

use App\Models\Certificado_Exportacion;
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

class CertificadosExport implements FromCollection, WithHeadings, WithEvents, WithMapping
{
    protected $filtros;

    public function __construct($filtros)
    {
        $this->filtros = $filtros;
    }

    public function collection()
    {
        $query = Certificado_Exportacion::query()
            ->leftJoin('dictamenes_exportacion', 'dictamenes_exportacion.id_dictamen', '=', 'certificados_exportacion.id_dictamen')
            ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_exportacion.id_inspeccion')
            ->leftJoin('solicitudes', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
            ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa')
            ->select('empresa.razon_social', 'certificados_exportacion.num_certificado', 'certificados_exportacion.fecha_emision', 'certificados_exportacion.fecha_vigencia', 'certificados_exportacion.estatus');

        // Aplicar filtros
        if (!empty($this->filtros['id_empresa'])) {
            $query->where('empresa.id_empresa', $this->filtros['id_empresa']);
        }

        if (!empty($this->filtros['anio'])) {
            $query->whereYear('certificados_exportacion.fecha_emision', $this->filtros['anio']);
        }

        if (!empty($this->filtros['mes'])) {
            $query->whereMonth('certificados_exportacion.fecha_emision', $this->filtros['mes']);
        }

        if (!empty($this->filtros['estatus'])) {
            $query->where('certificados_exportacion.estatus', $this->filtros['estatus']);
        }

        // Ordenar por empresa
        return $query->orderBy('empresa.razon_social', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            ['Reporte de Certificados de Exportación'],
            ['Empresa', 'Número Certificado', 'Fecha Emisión', 'Fecha Vigencia', 'Estatus']
        ];
    }

    public function map($certificado): array
    {
        return [
            $certificado->razon_social ?? 'NA',
            $certificado->num_certificado ?? 'NA',
            Carbon::parse($certificado->fecha_emision)->translatedFormat('d \d\e F \d\e Y h:i A'),
            Carbon::parse($certificado->fecha_vigencia)->translatedFormat('d \d\e F \d\e Y h:i A'),
            match ($certificado->estatus) {
                0 => 'Emitido',
                1 => 'Cancelado',
                2 => 'Reexpedido',
                default => 'NA',
            }
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Estilo para el título
                $sheet->mergeCells('A1:E1');
                $sheet->getStyle('A1:E1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(14)
                    ->getColor()->setARGB('000000');
                $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Estilo para los encabezados
                $sheet->getStyle('A2:E2')
                    ->getFont()
                    ->setBold(true)
                    ->getColor()->setARGB('000000');
                $sheet->getStyle('A2:E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A2:E2')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('8eaadc');

                // Formato general para las celdas
                foreach (range('A', 'E') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
                $sheet->getStyle('A2:E' . ($event->sheet->getHighestRow()))
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
            }
        ];
    }
}