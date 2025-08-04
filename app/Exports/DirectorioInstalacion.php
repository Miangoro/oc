<?php

namespace App\Exports;
use App\Models\Certificados;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;


class DirectorioInstalacion implements FromCollection, WithMapping, WithHeadings, WithEvents
{
    protected $filtros;

    
    public function __construct($filtros)
    {
        $this->filtros = $filtros;
    }


    public function collection()
    {
        $query = Certificados::query()
            ->leftJoin('dictamenes_instalaciones', 'dictamenes_instalaciones.id_dictamen', '=', 'certificados.id_dictamen')
            ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_instalaciones.id_inspeccion')
            ->leftJoin('solicitudes', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
            ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa');
        //->select('empresa.razon_social', 'certificados_exportacion.num_certificado', 'certificados_exportacion.fecha_emision', 'certificados_exportacion.fecha_vigencia', 'certificados_exportacion.estatus');

        // Aplicar filtros
        if (!empty($this->filtros['id_empresa'])) {
            $query->where('empresa.id_empresa', $this->filtros['id_empresa']);
        }

        if (!empty($this->filtros['anio'])) {
            $query->whereYear('certificados.fecha_emision', $this->filtros['anio']);
        }

        if (!empty($this->filtros['mes'])) {
            $query->whereMonth('certificados.fecha_emision', $this->filtros['mes']);
        }

        if (!empty($this->filtros['estatus'])) {
            $query->where('certificados.estatus', $this->filtros['estatus']);
        }

        // Ordenar por empresa
        return $query->orderBy('certificados.fecha_emision', 'asc')->get();
    }


    public function headings(): array
    {
        return [
            ['Directorio de Certificados de Instalaciones'],
            ['Fecha expedición / vigencia', 'Indicación del producto', 'Documentos a certificar', 'Identificación del cliente', 'Marca', 'Evaluador', 'No. de Certificación', 'Vigencia de certificación', 'Vigencia modificada']
        ];
    }


    public function map($certificado): array
    {
        $fechaEmision = Carbon::parse($certificado->fecha_emision)->translatedFormat('d/m/Y');
        $fechaVigencia = Carbon::parse($certificado->fecha_vigencia)->translatedFormat('d/m/Y');
        $fechas = "{$fechaEmision} al {$fechaVigencia}";
        //Lote envasado
        $lotes_env = $certificado->dictamen?->inspeccione?->solicitud?->lotesEnvasadoDesdeJson();//obtener todos los lotes
        $marca = $lotes_env?->first()?->marca->marca ?? ' ';
        /*$documentos = implode(', ', array_filter([
            $certificado->solicitud_numero ?? null,
            $certificado->opinion_codigo ?? null,
            $certificado->servicio_codigo ?? null
        ]));*/

        return [
            $fechas,
            'Instalacion',
            'NOM-070-SCFI-2016',
            $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado',
            $marca,
            'Consejo para la  decisión de la Certificacion',
            $certificado->num_certificado ?? 'Sin folio',
            '365 días naturales',
            '',
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
