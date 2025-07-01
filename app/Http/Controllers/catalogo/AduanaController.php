<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use App\Models\catalogo_aduanas;
use Illuminate\Http\Request;

class AduanaController extends Controller
{
    public function index()
    {
        $aduana = catalogo_aduanas::all();
        return view('catalogo.find_catalogo_aduana', compact('aduana'));
    }

    public function getData()
{
   $aduana = catalogo_aduanas::select('id', 'aduana')->orderBy('id')->get();
    return response()->json(['data' => $aduana]);
}
public function edit($id)
{
    $aduana = catalogo_aduanas::findOrFail($id);
    return response()->json($aduana);
}

public function update(Request $request, $id)
{
    $request->validate([
        'aduana' => 'required|string|max:255',
    ]);

    $aduana = catalogo_aduanas::findOrFail($id);
    $aduana->aduana = $request->aduana;
    $aduana->save();

    return response()->json(['success' => '¡Aduana actualizada correctamente!']);
}
public function destroy($id)
{
    $aduana = catalogo_aduanas::findOrFail($id);
    $aduana->delete();

    return response()->json(['success' => 'Registro eliminado correctamente.']);
}
public function store(Request $request)
{
    $request->validate([
        'aduana' => 'required|string|max:255'
    ]);

    catalogo_aduanas::create([
        'aduana' => $request->aduana
    ]);

    return response()->json(['success' => '¡Aduana registrada correctamente!']);
}

}
