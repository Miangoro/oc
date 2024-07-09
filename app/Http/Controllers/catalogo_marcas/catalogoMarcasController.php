<?php

namespace App\Http\Controllers\catalogo_marcas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\empresa;
use App\Models\catalogoMarca;

class catalogoMarcasController extends Controller
{
    public function catalogoMarcas()
    {
        $clientes = empresa::where('tipo', 2)->get();
        $opciones = catalogoMarca::all();
        return view('catalogo.catalogo_marcas_view', compact('opciones', 'clientes'));
    }

    public function destroy($id)
    {
        $marca = catalogoMarca::findOrFail($id);
        $marca->delete();
        return redirect()->route('catalogoMarcas')->with('success', 'Marca eliminada exitosamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente' => 'required|exists:empresa,id_empresa',
            'company' => 'required|string|max:60',
            'folio' => 'required|string|max:1',
        ]);

        if ($request->id) {
            $marca = catalogoMarca::findOrFail($request->id);
            $marca->id_empresa = $request->cliente;
            $marca->marca = $request->company;
            $marca->folio = $request->folio;
            $marca->save();
            return redirect()->route('catalogoMarcas')->with('success', 'Marca actualizada exitosamente.');
        } else {
            $marca = new catalogoMarca();
            $marca->id_empresa = $request->cliente;
            $marca->marca = $request->company;
            $marca->folio = $request->folio;
            $marca->save();
            return redirect()->route('catalogoMarcas')->with('success', 'Marca registrada exitosamente.');
        }
    }

    public function edit($id)
    {
        $marca = catalogoMarca::findOrFail($id);
        return response()->json($marca);
    }
}
