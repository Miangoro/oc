<?php

namespace App\Http\Controllers\documentacion;

use App\Http\Controllers\Controller;
use App\Models\Documentacion;
use Illuminate\Http\Request;

class documentacionController extends Controller
{
    public function index(){

        $documentos = Documentacion ::where('subtipo', '=', 'Todas')
            ->get();
        $productor_agave = Documentacion ::where('subtipo', '=', 'Generales Productor')
            ->get();

        return view("documentacion.documentacion_view", ["documentos"=>$documentos, "productor_agave"=>$productor_agave]);
    }
}