<?php

namespace App\Http\Controllers\carousel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\carousel;

use Illuminate\Support\Facades\File;

class ImagenController extends Controller
{
    public function UserManagement()
    {
        return view('carousel.find_imagen_carousel_view');
    }

    // 👉 Listar imágenes desde la BD
  public function index(Request $request)
{
    $images = Carousel::orderBy('orden')->get();

    $data = $images->map(function($item, $index) {
        return [
            'fake_id' => $index + 1,       // índice incremental
            'id_carousel' => $item->id_carousel,
            'nombre' => $item->nombre,
            'url' => asset('assets/img/carousel/' . $item->url),
            'orden' => $item->orden,
        ];
    });

    $draw = $request->input('draw', 1);
    $start = $request->input('start', 0);
    $length = $request->input('length', 10);

    $pagedData = $data->slice($start, $length)->values();

    return response()->json([
        'draw' => intval($draw),
        'recordsTotal' => $images->count(),
        'recordsFiltered' => $images->count(),
        'data' => $pagedData,
    ]);
}

    // 👉 Guardar imagen (subida + registro en BD)
    public function store(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|max:5120', // 5 MB
        ]);

        $file = $request->file('imagen');
        $nombreBase = $request->input('nombre_imagen');

        if ($nombreBase) {
            $nombreBase = preg_replace('/[^A-Za-z0-9_\-]/', '', $nombreBase);
            $filename = $nombreBase . '.' . $file->getClientOriginalExtension();
        } else {
            $filename = $file->getClientOriginalName();
        }

        $destination = public_path('assets/img/carousel');

        $i = 1;
        $nombreFinal = $filename;
        while (file_exists($destination . '/' . $nombreFinal)) {
            $nombreFinal = pathinfo($filename, PATHINFO_FILENAME) . "_$i." . $file->getClientOriginalExtension();
            $i++;
        }

        $file->move($destination, $nombreFinal);

        // Guardar en BD
        $carousel = carousel::create([
            'nombre' => pathinfo($nombreFinal, PATHINFO_FILENAME),
            'url'    => 'assets/img/carousel/' . $nombreFinal,
            'orden'  => carousel::max('orden') + 1, // siguiente orden
        ]);

        return response()->json(['success' => true, 'data' => $carousel]);
    }

    // 👉 Eliminar imagen (BD + archivo físico)
    public function destroy($id)
    {
        $carousel = carousel::findOrFail($id);

        $path = public_path($carousel->url);
        if (File::exists($path)) {
            File::delete($path);
        }

        $carousel->delete();

        return response()->json(['success' => true, 'message' => 'Imagen eliminada correctamente']);
    }

}
