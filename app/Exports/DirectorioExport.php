<?php

namespace App\Exports;
use App\Models\Certificado_Exportacion;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;


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
        $fechaEmision = Carbon::parse($certificado->fecha_emision)->translatedFormat('d/m/Y');
        $fechaVigencia = Carbon::parse($certificado->fecha_vigencia)->translatedFormat('d/m/Y');
        $fechas = "{$fechaEmision} al {$fechaVigencia}";
        //Lote envasado
        $lotes_env = $certificado->dictamen?->inspeccione?->solicitud?->lotesEnvasadoDesdeJson();//obtener todos los lotes
        $marca = $lotes_env?->first()?->marca->marca ?? 'No encontrado';
        /*$documentos = implode(', ', array_filter([
            $certificado->solicitud_numero ?? null,
            $certificado->opinion_codigo ?? null,
            $certificado->servicio_codigo ?? null
        ]));*/

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
            // Insertar imagen a la izquierda (en la celda A1)
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Logo CIDAM');
            $drawing->setDescription('Logo CIDAM');
            $drawing->setPath(public_path('img_pdf/logo_oc_3d.png')); // ruta absoluta a la imagen
            $drawing->setHeight(50); // altura en píxeles, ajusta a tu gusto
            $drawing->setCoordinates('A1');
            $drawing->setOffsetX(10); // desplazamiento horizontal en px
            $drawing->setWorksheet($sheet);

            // Escribir título principal centrado
            $sheet->mergeCells('B1:H1'); // celdas centrales, ajusta columnas si quieres
            $sheet->setCellValue('B1', 'Directorio de Certificados de Exportación');
            $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('B1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // Escribir texto de vigencia a la derecha (por ejemplo en I1)
            $textoVigencia = "Directorio de Certificados de Exportación NOM-070-SCFI-2016 F7.1-01-20\nEdición 2 Entrada en vigor: 02/09/2022";
            $sheet->setCellValue('I1', $textoVigencia);
            $sheet->getStyle('I1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('I1')->getFont()->setSize(10);
            $sheet->getStyle('I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->getRowDimension(1)->setRowHeight(50); // para que alcance la altura de la imagen

            // Opcional: estilos para toda la fila 1
            $sheet->getStyle('A1:I1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

            // El resto de tu código para encabezados, bordes, autoajuste...
            $sheet->getStyle('A2:I2')->getFont()->setBold(true)->getColor()->setARGB('000000');
            $sheet->getStyle('A2:I2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('8eaadc');

            foreach (range('A', 'I') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $sheet->getStyle('A2:I' . $sheet->getHighestRow())
                ->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }
    ];
}



}
