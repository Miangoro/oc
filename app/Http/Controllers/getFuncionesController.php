<?php

namespace App\Http\Controllers;

use App\Models\Destinos;
use App\Models\empresa;
use App\Models\LotesGranel;
use App\Models\tipos;

use App\Models\normas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class getFuncionesController extends Controller
{
    public function datosComunes($id_empresa)
    {
       /* $normas = DB::table('empresa_norma_certificar AS n')
        ->join('catalogo_norma_certificar AS c', 'n.id_norma', '=', 'c.id_norma')
        ->select('c.norma', 'c.id_norma') // Selecciona las columnas necesarias
        ->where('c.id_norma', '!=' ,2)
        ->where('n.id_empresa', $id_empresa)
        ->get();*/


        // Lógica común que se necesita en diferentes vistas
        return [
            'empresas' => empresa::all(),
            //'normas' => $normas,
            'direcciones_destino' => Destinos::where("id_empresa",$id_empresa),

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

    public function usuariosInspectores()
    {
        $inspectores = User::all();
        return $this->renderVista('_partials._modals.modal-add-asignar-inspector',$inspectores);
    }


    public function getDatos(empresa $empresa)
    {
        // Obtener las marcas de la empresa
        $marcas = $empresa->marcas()->get();  // Llamamos a `get()` para obtener los datos reales

        // Depurar las marcas


        return response()->json([
            'instalaciones' => $empresa->obtenerInstalaciones(),
            'lotes_granel' => $empresa->lotes_granel(),
            'marcas' => $marcas,
            'guias' => $empresa->guias(),
            'predios' => $empresa->predios(),
            'predio_plantacion' => $empresa->predio_plantacion(),
            'direcciones' => $empresa->direcciones(),
            'lotes_envasado' => $empresa->lotes_envasado(),
            'direcciones_destino' => Destinos::where("id_empresa", $empresa->id_empresa)->where('tipo_direccion', 1)->get(),
        ]);
    }

    public function getDatos2($id_lote_granel)
    {
        $loteGranel = LotesGranel::find($id_lote_granel);
    
        if (!$loteGranel) {
            return response()->json(['error' => 'Lote Granel no encontrado'], 404);
        }
    
        // Obtener la marca asociada a la empresa relacionada con el lote_granel
        $marca = $loteGranel->empresa ? $loteGranel->empresa->marcas()->pluck('marca')->first() : null;
        
        // Obtener ids de tipos desde el JSON (id_tipo)
        $idTipos = json_decode($loteGranel->id_tipo, true);
    
        // Si no hay tipos, devolvemos un valor vacío
        if (!$idTipos || !is_array($idTipos)) {
            return response()->json([
                'categoria' => $loteGranel->categoria,
                'clase' => $loteGranel->clase,
                'tipo' => [],
                'marca' => $marca, // Incluir la marca aquí
                'lotes_granel' => $loteGranel
            ]);
        }
    
        // Buscar los datos de cada tipo relacionado
        $tipos = tipos::whereIn('id_tipo', $idTipos)
        ->get(['id_tipo', 'nombre', 'cientifico']); // Incluye 'id_tipo' en la consulta
    
    return response()->json([
        'categoria' => $loteGranel->categoria,
        'clase' => $loteGranel->clase,
        'tipo' => $tipos, // Enviar la lista de tipos encontrados
        'marca' => $marca, // Incluir la marca aquí
        'lotes_granel' => $loteGranel
    ]);
    
    }
    
    
    
    
    







}
