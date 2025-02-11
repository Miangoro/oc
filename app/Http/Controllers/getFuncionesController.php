<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Destinos;
use App\Models\Documentacion_url;
use App\Models\empresa;
use App\Models\Instalaciones;
use App\Models\LotesGranel;
use App\Models\tipos;
use App\Models\lotes_envasado;
use App\Models\normas;
use App\Models\solicitudesModel;
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
        //$marcas = $empresa->marcas()->get();  // Llamamos a `get()` para obtener los datos reales
        $marcas = $empresa->todasLasMarcas()->get(); 

        // Depurar las marcas


        return response()->json([
            'instalaciones' => $empresa->obtenerInstalaciones(),
            'lotes_granel' => $empresa->todos_lotes_granel(),
            'marcas' => $marcas,
            'guias' => $empresa->guias(),
            'predios' => $empresa->predios(),
            'predio_plantacion' => $empresa->predio_plantacion(),
            'direcciones' => $empresa->direcciones(),
            'lotes_envasado' => $empresa->lotes_envasado(),
            'direcciones_destino' => Destinos::where("id_empresa", $empresa->id_empresa)->where('tipo_direccion', 1)->get(),
            'instalaciones_produccion' => Instalaciones::where('tipo', 'like', '%Productora%')->where("id_empresa", $empresa->id_empresa)->get(),
            'instalaciones_comercializadora' => Instalaciones::where('tipo', 'like', '%Comercializadora%')->where("id_empresa", $empresa->id_empresa)->get(),
            'instalaciones_envasadora' => Instalaciones::where('tipo', 'like', '%Envasadora%')->where("id_empresa", $empresa->id_empresa)->get(),
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
    public function getDatosLoteEnvasado($idLoteEnvasado)
    {
        // Obtener el lote envasado específico por ID, con las relaciones necesarias
        $loteEnvasado = lotes_envasado::with([
            'marca',
            'lotesGranel.categoria',
            'lotesGranel.clase'
        ])->find($idLoteEnvasado);

        // Si no se encuentra el lote envasado, devolver un error
        if (!$loteEnvasado) {
            return response()->json(['error' => 'Lote envasado no encontrado'], 404);
        }

        // Obtener el primer lote granel (si hay más de uno)
        $primerLoteGranel = $loteEnvasado->lotesGranel->first(); // Obtén el primer elemento si hay varios

        // Si no hay ningún lote granel, devolver un error
        if (!$primerLoteGranel) {
            return response()->json(['error' => 'Lote granel no encontrado'], 404);
        }

        $idTipos = json_decode($primerLoteGranel->id_tipo, true);

        // Validar si se pudo decodificar correctamente y si es un arreglo
        if (!$idTipos || !is_array($idTipos)) {
            $idTipos = []; // Si no hay tipos, asignar un arreglo vacío
        }

        // Buscar los datos de los tipos en la base de datos usando los IDs obtenidos
        $tipos = tipos::whereIn('id_tipo', $idTipos)
            ->get(['id_tipo', 'nombre', 'cientifico'])
            ->map(function ($tipo) {
                // Concatenar el nombre con el nombre científico en el formato requerido
                $tipo->nombre = $tipo->nombre . ' (' . $tipo->cientifico . ')';
                unset($tipo->cientifico); // Eliminar el campo 'cientifico', ya que está incluido en 'nombre'
                return $tipo;
            });

            return response()->json([
              'lotes_envasado' => $loteEnvasado,
              'marca' => $loteEnvasado->marca,
              'primer_lote_granel' => [
                  'id_categoria' => $primerLoteGranel->categoria ? $primerLoteGranel->categoria->id_categoria : '', // ID de la categoría
                  'nombre_categoria' => $primerLoteGranel->categoria ? $primerLoteGranel->categoria->categoria : '', // Nombre de la categoría
                  'id_clase' => $primerLoteGranel->clase ? $primerLoteGranel->clase->id_clase : '', // ID de la clase
                  'nombre_clase' => $primerLoteGranel->clase ? $primerLoteGranel->clase->clase : '', // Nombre de la clase
                  'folio_fq' => $primerLoteGranel->folio_fq,
                  'cont_alc' => $primerLoteGranel->cont_alc,
                  'folio_certificado' => $primerLoteGranel->folio_certificado,
                  'tipos' => $tipos,
                  'tipos_ids' => $idTipos, // Solo los IDs
                  'tipos_nombres' => $tipos->pluck('nombre'),
              ]
          ]);
    }




    public function getDatosSolicitud($id_solicitud)
{
   // Realizamos la consulta base sin las relaciones condicionales
$solicitudQuery = solicitudesModel::with([
    'empresa.empresaNumClientes',
    'instalacion.certificado_instalacion',
   
    'predios',
    'marcas',
     'lote_envasado.lotes_envasado_granel.lotes_granel.clase',
        'lote_envasado.lotes_envasado_granel.lotes_granel.categoria'

]);

// Cargamos la solicitud
$solicitud = $solicitudQuery->where("id_solicitud", $id_solicitud)->first();

if ($solicitud && $solicitud->id_tipo != 11 && $solicitud->id_tipo != 5) {
    // Si el id_tipo no es 11, agregamos las relaciones adicionales
    $solicitud->load([
        'lote_granel.categoria',
        'lote_granel.clase',

    ]);
}


    if (!$solicitud) {
        return response()->json([
            'success' => false,
            'message' => 'No se encontró la solicitud.',
        ]);
    }

    // Manejar tipos relacionados
    $tipos = "No hay tipos relacionados disponibles.";
    if (!empty($solicitud->lote_granel) && !empty($solicitud->lote_granel->tiposRelacionados)) {
        $tipos = collect($solicitud->lote_granel->tiposRelacionados)
            ->map(fn($tipo) => $tipo->nombre . " (" . $tipo->cientifico . ")")
            ->join(', ');
    }

    // Obtener documentos relacionados
    $documentos = Documentacion_url::where("id_empresa", $solicitud->empresa->id_empresa)->get();

    if ($solicitud && $solicitud->id_tipo == 11) {
        $caracteristicas = is_string($solicitud->caracteristicas) 
            ? json_decode($solicitud->caracteristicas, true) 
            : $solicitud->caracteristicas;
    
        $idEtiqueta = is_array($caracteristicas) 
            ? ($caracteristicas['id_etiqueta'] ?? null) 
            : ($caracteristicas->id_etiqueta ?? null);
    
        if ($idEtiqueta) {
            $url_etiqueta = Documentacion_url::where('id_relacion', $idEtiqueta)
            ->where('id_documento', 60)
            ->value('url'); // Obtiene directamente el valor del campo 'url'
        }
    }
    

    return response()->json([
        'success' => true,
        'data' => $solicitud,
        'documentos' => $documentos,
        'url_etiqueta' => $url_etiqueta ?? '',
        'fecha_visita_formateada' => Helpers::formatearFechaHora($solicitud->fecha_visita),
        'tipos_agave' => $tipos
    ]);
}



    //Este por ahora no se usa para nada, pero lo dejo para un futuro
    public function obtenerDocumentosClientes($id_cliente)
    {
    $documento = Documentacion_url::where("id_empresa", "=", $id_cliente)
                                  ->first(); // Devuelve el primer registro que coincida



        if ($documento) {
            return response()->json([
                'success' => true,
                'data' => $documento,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró documento.',
            ]);
        }
    }










}
