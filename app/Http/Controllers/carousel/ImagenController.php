<?php

namespace App\Http\Controllers\carousel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImagenController extends Controller
{
    public function UserManagement()
    {
        return view('carousel.find_imagen_carousel_view');
    }

    public function index(Request $request)
    {
        $path = public_path('assets/img/carousel');
        $images = [];

        if (File::exists($path)) {
            $files = File::files($path);
            $counter = 1; // contador para fake_id

            foreach ($files as $file) {
                $images[] = [
                    'fake_id' => $counter++, // agregamos el fake_id
                    'nombre' => $file->getFilename(),
                    'url' => asset('assets/img/carousel/' . $file->getFilename()),
                ];
            }
        }

        // DataTables expects these fields
        $draw = $request->input('draw', 1);
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $data = array_slice($images, $start, $length);

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => count($images),
            'recordsFiltered' => count($images),
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|max:5120', // 5 MB
        ]);

        $file = $request->file('imagen');

        // Nombre base opcional
        $nombreBase = $request->input('nombre_imagen');

        if ($nombreBase) {
            // Limpiar caracteres
            $nombreBase = preg_replace('/[^A-Za-z0-9_\-]/', '', $nombreBase);
            $filename = $nombreBase . '.' . $file->getClientOriginalExtension();
        } else {
            // Si no hay nombre, usar el original
            $filename = $file->getClientOriginalName();
        }

        $destination = public_path('assets/img/carousel');

        // Evitar sobreescritura
        $i = 1;
        $nombreFinal = $filename;
        while (file_exists($destination . '/' . $nombreFinal)) {
            $nombreFinal = pathinfo($filename, PATHINFO_FILENAME) . "_$i." . $file->getClientOriginalExtension();
            $i++;
        }

        $file->move($destination, $nombreFinal);

        return response()->json(['success' => true, 'nombre' => $nombreFinal]);
    }



    public function destroy($filename)
    {
        $path = public_path('assets/img/carousel/' . $filename);

        if (File::exists($path)) {
            File::delete($path);
            return response()->json(['success' => true, 'message' => 'Imagen eliminada correctamente']);
        }

        return response()->json(['success' => false, 'message' => 'Imagen no encontrada'], 404);
    }


}
