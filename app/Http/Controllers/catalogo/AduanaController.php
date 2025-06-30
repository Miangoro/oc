<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Models\catalogo_aduanas;
use Illuminate\Http\Request;

class AduanaController extends Controller
{
    public function index()
    {
        $aduanas = catalogo_aduanas::all();
        return view('catalogo.find_catalogo_aduana', compact('aduanas'));
    }

    public function getData()
{
    $aduanas = catalogo_aduanas::select('id', 'ubicacion')->get();
    return response()->json(['data' => $aduanas]);
}

}
