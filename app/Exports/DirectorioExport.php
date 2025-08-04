<?php

namespace App\Exports;
use App\Models\Certificado_Exportacion;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;


class DirectorioExport implements FromCollection, WithMapping, WithHeadings, WithEvents, WithCustomStartCell
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


    public function startCell(): string
    {
        return 'A2'; // encabezados comienzan en fila 2
    }
    public function headings(): array
    {
        return [
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
        $marca = $lotes_env?->first()?->marca->marca ?? 'No encontrado';

        return [
            $fechas,
            'Mezcal',
            'NOM-070-SCFI-2016',
            $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado',
            $marca,
            'Consejo para la  decisión de la Certificacion',
            $certificado->num_certificado ?? 'Sin folio',
            '90 días naturales',
            '',
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                /*
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
                */

                // Logo en columnas A
                $drawing = new Drawing();
                $drawing->setName('Logo OC');
                $drawing->setDescription('Logo Organismo Certificador');
                $drawing->setPath(public_path('img_pdf/logo_oc_3d.png'));
                $drawing->setHeight(85);
                //$drawing->setWidth(60);
                $drawing->setOffsetX(15);
                //$drawing->setOffsetY(0);
                $drawing->setCoordinates('A1');
                $drawing->setWorksheet($sheet);

                // 2. Título centrado (columnas B a F)
                $sheet->mergeCells('B1:F1');
                $sheet->setCellValue('B1', 'Directorio de Certificados de Exportación NOM-070-SCFI-2016');
                $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // 3. Vigencia (columnas H e I)
                $sheet->mergeCells('G1:I1');
                $sheet->setCellValue('G1', "Directorio de Certificados de Exportación NOM-070-SCFI-2016 F7.1-01-20\nEdición 2 Entrada en vigor: 02/09/2022");
                $sheet->getStyle('G1')->getFont()->setSize(10);
                $sheet->getStyle('G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('G1')->getAlignment()->setWrapText(true);

                // 4. Ajustes de altura y alineación
                $sheet->getRowDimension(1)->setRowHeight(60);
                $sheet->getStyle('A1:I1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


                // El resto de columnas para encabezados, bordes, autoajuste...
                $sheet->getStyle('A2:I2')->getFont()->setBold(true)->getColor()->setARGB('000000');
                $sheet->getStyle('A2:I2')->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('8eaadc');

                foreach (range('A', 'I') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                $sheet->getStyle('A2:I2' . $sheet->getHighestRow())
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
            }
        ];
    }




}
