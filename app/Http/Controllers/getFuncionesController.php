<?php

namespace App\Http\Controllers;

use App\Models\empresa;
use App\Models\normas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class getFuncionesController extends Controller
{
    private function datosComunes($id_empresa)
    {   
        $normas = DB::table('empresa_norma_certificar AS n')
        ->join('catalogo_norma_certificar AS c', 'n.id_norma', '=', 'c.id_norma')
        ->select('c.norma', 'c.id_norma') // Selecciona las columnas necesarias
        ->where('c.id_norma', '!=' ,2)
        ->where('n.id_empresa', $id_empresa)
        ->get();


        // Lógica común que se necesita en diferentes vistas
        return [
            'empresas' => empresa::all(),
            'normas' => $normas,

           
        ];
    }

    private function renderVista($vista,$id_empresa)
    {
        $data = $this->datosComunes($id_empresa);
        //return view($vista, $data);
        return response()->json($data);
    }

    public function find_clientes_prospecto($id)
    {   
        $id_empresa = $id;
        return $this->renderVista('_partials._modals.modal-add-aceptar-cliente',$id_empresa);
    }


    public function getDatos(empresa $empresa){
        return response()->json([
            'instalaciones' => $empresa->obtenerInstalaciones(),
            'lotes_granel' => $empresa->lotes_granel(),
            'marcas' => $empresa->marcas(),
            'guias' => $empresa->guias(),
            'predios' => $empresa->predios(),
            'predio_plantacion' => $empresa->predio_plantacion(),



        ]);
    }



    
}
