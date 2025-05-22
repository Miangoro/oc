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
        ['ESTATUS', 'FECHA DE EXPEDICIÓN', 'No. DE CERTIFICADO', 'CONTACTO', 'EMPRESA', 'LOTE GRANEL', 'LOTE ENVASADO', 'MARCA', 'PAÍS DESTINO', 'No. DE BOTELLAS', 'CONTENIDO', 'TOTAL DE LITROS', '% ALC. VOL']
    ];
}


    public function map($certificado): array
{
    return [
        match ($certificado->estatus) {
            0 => 'Emitido',
            1 => 'Cancelado',
            2 => 'Reexpedido',
            default => 'No encontrado',
        },
        Carbon::parse($certificado->fecha_expedicion)->translatedFormat('d \d\e F \d\e Y h:i A'),
        $certificado->num_certificado ?? 'No encontrado',
        $certificado->contacto ?? 'No encontrado',
        $certificado->empresa ?? 'No encontrado',
        $certificado->lote_granel ?? 'No encontrado',
        $certificado->lote_envasado ?? 'No encontrado',
        $certificado->marca ?? 'No encontrado',
        $certificado->pais_destino ?? 'No encontrado',
        $certificado->num_botellas ?? 'No encontrado',
        $certificado->contenido ?? 'No encontrado',
        $certificado->total_litros ?? 'No encontrado',
        $certificado->porcentaje_alcohol_vol ?? 'No encontrado',
    ];
}

    public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet->getDelegate();

            // **Título**
            $sheet->mergeCells('A1:M1');
            $sheet->getStyle('A1:M1')
                ->getFont()->setBold(true)->setSize(14)->getColor()->setARGB('000000');
            $sheet->getStyle('A1:M1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // **Encabezados**
            $sheet->getStyle('A2:M2')
                ->getFont()->setBold(true)->getColor()->setARGB('000000');
            $sheet->getStyle('A2:M2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2:M2')
                ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('8eaadc');

            // **Color Verde para "No. DE CERTIFICADO"**
            $sheet->getStyle('C2')->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet->getStyle('C2')->getFill()->getStartColor()->setARGB('00FF00'); // Verde
            $sheet->getStyle('C2')->getFont()->setBold(true)->setSize(12);

            // **Color Naranja para "EMPRESA"**
            $sheet->getStyle('E2')->getFill()->setFillType(Fill::FILL_SOLID);
            $sheet->getStyle('E2')->getFill()->getStartColor()->setARGB('FFA500'); // Naranja
            $sheet->getStyle('E2')->getFont()->setBold(true)->setSize(12);

            // **Formato general para las columnas**
            foreach (range('A', 'M') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            $sheet->getStyle('A2:M' . ($event->sheet->getHighestRow()))
                ->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
        }
    ];
}
}