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
        ['Usuario', 'Instalaciones', 'Correo', 'Teléfono', 'Cliente', 'Rol', 'Estatus', 'Contraseña']
    ];
}

public function map($usuario): array
{
    if (is_array($usuario->id_instalacion)) {
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
        $usuario->roles->pluck('name')->implode(', '),
        $usuario->estatus ?? 'N/A',
        $usuario->password_original ?? 'N/A', // mejor mostrar password_original si la guardas en texto
    ];
}

public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet->getDelegate();

            // Encabezado grande
            $sheet->mergeCells('A1:H1');
            $sheet->getStyle('A1:H1')->getFont()->setBold(true)->setSize(14)->getColor()->setARGB('FFFFFF');
            $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1:H1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('003366');

            // Subtítulo
            $sheet->mergeCells('A2:H2');
            $sheet->getStyle('A2:H2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Encabezados
            $sheet->getStyle('A3:H3')->getFont()->setBold(true);
            $sheet->getStyle('A3:H3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A3:H3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('8eaadc');

            // Bordes
            $sheet->getStyle('A3:H' . $event->sheet->getHighestRow())
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Auto ancho columnas
            foreach (range('A', 'H') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        },
    ];
}

}
