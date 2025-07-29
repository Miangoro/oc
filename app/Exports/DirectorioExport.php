<?php

namespace App\Exports;
use App\Models\Certificado_Exportacion;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Models\Certificado;
use Maatwebsite\Excel\Concerns\FromCollection;

class DirectorioExport implements FromCollection, WithMapping, WithHeadings, WithEvents
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
            ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa');
        //->select('empresa.razon_social', 'certificados_exportacion.num_certificado', 'certificados_exportacion.fecha_emision', 'certificados_exportacion.fecha_vigencia', 'certificados_exportacion.estatus');

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
        return $query->orderBy('certificados_exportacion.fecha_emision', 'asc')->get();
    }
    public function headings(): array
    {
        return [
            ['Directorio de Certificados de Exportación'],
            ['Fecha expedición / vigencia', 'Indicación del producto', 'Documentos a certificar', 'Identificación del cliente', 'Marca', 'Evaluador', 'No. de Certificación', 'Vigencia de certificación', 'Vigencia modificada']
        ];
    }
    public function map($certificado): array
    {
        $fechaExpedicion = \Carbon\Carbon::parse($certificado->fecha_expedicion)->format('d/m/Y');
        $fechaVigencia = \Carbon\Carbon::parse($certificado->fecha_vigencia)->format('d/m/Y');
        $fecha = "{$fechaExpedicion} / {$fechaVigencia}";

        $documentos = implode(', ', array_filter([
            $certificado->solicitud_numero ?? null,
            $certificado->opinion_codigo ?? null,
            $certificado->servicio_codigo ?? null
        ]));

        return [
            $fecha,
            'Certificado de exportación',
            $documentos,
            $certificado->cliente ?? 'No encontrado',
            $certificado->marca ?? 'No encontrado',
            $certificado->evaluador ?? 'No asignado',
            $certificado->num_certificado ?? 'Sin folio',
            $fechaVigencia,
            $certificado->vigencia_modificada ?? ''
        ];
    }
    public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet->getDelegate();

            // Título
            $sheet->mergeCells('A1:I1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // Encabezados
            $sheet->getStyle('A2:I2')->getFont()->setBold(true)->getColor()->setARGB('000000');
            $sheet->getStyle('A2:I2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('8eaadc'); // color institucional

            // Autoajuste
            foreach (range('A', 'I') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Bordes
            $sheet->getStyle('A2:I' . $sheet->getHighestRow())
                ->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }
    ];
}


}
