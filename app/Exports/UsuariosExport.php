<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class UsuariosExport implements FromCollection, WithHeadings, WithEvents, WithMapping
{
    protected $filtros;

    public function __construct($filtros = [])
    {
        $this->filtros = $filtros;
    }

    public function collection()
    {
        $query = User::with(['roles', 'empresa']);

        if (isset($this->filtros['id_empresa']) && $this->filtros['id_empresa']) {
            $query->where('id_empresa', $this->filtros['id_empresa']);
        }

        if (isset($this->filtros['rol']) && $this->filtros['rol']) {
            $query->whereHas('roles', function ($q) {
                $q->where('name', $this->filtros['rol']);
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        $fechaGeneracion = Carbon::now()->translatedFormat('d \d\e F \d\e Y');

        return [
            ['Reporte de Usuarios'],
            ["Generado el $fechaGeneracion a través de la Plataforma OC CIDAM"],
            ['Usuario', 'Instalaciones', 'Correo', 'Teléfono', 'Cliente', 'Rol']
        ];
    }

    public function map($usuario): array
    {
        // Si es array (JSON casteado), concatenamos IDs y opcionalmente buscamos nombres
        if (is_array($usuario->id_instalacion)) {
            // Aquí puedes mapear IDs a nombres si tienes la tabla de instalaciones
            $instalaciones = \App\Models\instalaciones::whereIn('id_instalacion', $usuario->id_instalacion)
                ->pluck('direccion_completa')
                ->implode(', ');
        } else {
            $instalaciones = 'N/A';
        }

        return [
            $usuario->name ?? 'N/A',
            $instalaciones,
            $usuario->email ?? 'N/A',
            $usuario->telefono ?? 'N/A',
            $usuario->empresa->razon_social ?? 'N/A',
            $usuario->roles->pluck('name')->implode(', ')
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Encabezado grande
                $sheet->mergeCells('A1:F1');
                $sheet->getStyle('A1:F1')->getFont()->setBold(true)->setSize(14)->getColor()->setARGB('FFFFFF');
                $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('003366');

                // Subtítulo
                $sheet->mergeCells('A2:F2');
                $sheet->getStyle('A2:F2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Encabezados
                $sheet->getStyle('A3:F3')->getFont()->setBold(true);
                $sheet->getStyle('A3:F3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A3:F3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('8eaadc');

                // Bordes
                $sheet->getStyle('A3:F' . $event->sheet->getHighestRow())
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Auto ancho columnas
                foreach (range('A', 'F') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
