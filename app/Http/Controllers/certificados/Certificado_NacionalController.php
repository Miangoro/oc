<?php

namespace App\Http\Controllers\certificados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\Certificado_Nacional;
use App\Models\solicitudesModel;
use App\Models\User;
use App\Models\empresa;
use App\Models\Revisor;
use App\Models\lotes_envasado;
use App\Models\activarHologramasModelo;
use App\Models\Dictamen_Envasado;
///Extensiones
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Certificado_NacionalController extends Controller
{

    public function UserManagement()
    {
        $solicitud = solicitudesModel::where('id_tipo',13)
            ->orderBy('id_solicitud', 'desc')
            ->get();
        $users = User::where('tipo',1)->get(); //Solo Personal OC
        $empresa = empresa::where('tipo', 2)->get();
        //$revisores = Revisor::all();
        $hologramas = activarHologramasModelo::all();

        return view('certificados.find_certificados_nacional', compact('solicitud', 'users', 'empresa', 'hologramas'));
    }

public function index(Request $request)
{
    //Permiso de empresa
    $empresaId = null;
    if (Auth::check() && Auth::user()->tipo == 3) {
        $empresaId = Auth::user()->empresa?->id_empresa;
    }

    DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para nombres meses

    // Mapear las columnas según el orden DataTables (índice JS)
    $columns = [
        0 => '',
        1 => 'num_certificado',
        2 => 'dictamenes_envasado.num_dictamen', //nombre de mi tabla y atributo
        3 => 'razon_social',
        4 => '', //caracteristicas
        5 => 'certificados_nacional.fecha_emision',
        6 => 'estatus',
        7 => '',// acciones
    ];
      
    /*$totalData = Certificado_Exportacion::count();
    $totalFiltered = $totalData; */
    $limit = $request->input('length');
    $start = $request->input('start');

    // Columnas ordenadas desde DataTables
    $orderColumnIndex = $request->input('order.0.column');// Indice de columna en DataTables
    $orderDirection = $request->input('order.0.dir') ?? 'asc';// Dirección de ordenamiento
    $orderColumn = $columns[$orderColumnIndex] ?? 'num_certificado'; // Por defecto

    $search = $request->input('search.value');//Define la búsqueda global.


    $query = Certificado_Nacional::query()
        ->leftJoin('dictamenes_envasado', 'dictamenes_envasado.id_dictamen_envasado', '=', 'certificados_nacional.id_dictamen')
        ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_envasado.id_inspeccion')
        ->leftJoin('solicitudes', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
        ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa')
        ->select('certificados_nacional.*', 'empresa.razon_social');
    if ($empresaId) {
        $query->where('solicitudes.id_empresa', $empresaId);
    }
    $baseQuery = clone $query;// Clonamos el query antes de aplicar búsqueda, paginación u ordenamiento
    $totalData = $baseQuery->count();// totalData (sin búsqueda)


    // Búsqueda Global
    if (!empty($search)) {//solo se aplica si hay búsqueda global
        $query->where(function ($q) use ($search) {
            $q->where('certificados_nacional.num_certificado', 'LIKE', "%{$search}%")
            ->orWhere('dictamenes_envasado.num_dictamen', 'LIKE', "%{$search}%")
            ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
            ->orWhere('empresa.razon_social', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(certificados_nacional.fecha_emision, '%d de %M del %Y') LIKE ?", ["%$search%"]);
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }


    // Ordenamiento especial para num_certificado con formato 'CIDAM C-EXP25-###'
    if ($orderColumn === 'num_certificado') {
        $query->orderByRaw("
            CASE
                WHEN num_certificado LIKE 'CIDAM C-EXP25-%' THEN 0
                ELSE 1
            END ASC,
            CAST(
                SUBSTRING_INDEX(
                    SUBSTRING(num_certificado, LOCATE('CIDAM C-EXP25-', num_certificado) + 14),
                    '-', 1
                ) AS UNSIGNED
            ) $orderDirection
        ");
    } elseif (!empty($orderColumn)) {
        $query->orderBy($orderColumn, $orderDirection);
    }

    
    // Paginación
    $certificados = $query
        ->with([// 1 consulta por cada tabla relacionada en conjunto (menos busqueda de query adicionales en BD)
            'dictamen',// Relación directa
            'dictamen.inspeccion',// Relación anidada: dictamen > inspeccion
            'dictamen.inspeccion.solicitud',// dictamen > inspeccion > solicitud
            // solicitud > empresa > empresaNumClientes
            'dictamen.inspeccion.solicitud.empresa',
            'dictamen.inspeccion.solicitud.empresa.empresaNumClientes',
        ])->offset($start)->limit($limit)->get();



    //MANDA LOS DATOS AL JS
    $data = [];
    if (!empty($certificados)) {
        foreach ($certificados as $certificado) {
            $nestedData['id_certificado'] = $certificado->id_certificado ?? 'No encontrado';
            $nestedData['num_certificado'] = $certificado->num_certificado ?? 'No encontrado';
            $nestedData['id_dictamen'] = $certificado->dictamen->id_dictamen_envasado ?? 'No encontrado';
            $nestedData['num_dictamen'] = $certificado->dictamen->num_dictamen ?? 'No encontrado';
            $nestedData['estatus'] = $certificado->estatus ?? 'No encontrado';
            $id_sustituye = json_decode($certificado->observaciones, true) ['id_sustituye'] ?? null;
            $nestedData['sustituye'] = $id_sustituye ? Certificado_Nacional::find($id_sustituye)->num_certificado ?? 'No encontrado' : null;
            $nestedData['fecha_emision'] = Helpers::formatearFecha($certificado->fecha_emision);
            $nestedData['fecha_vigencia'] = Helpers::formatearFecha($certificado->fecha_vigencia);
            ///Folio y no. servicio
            $nestedData['num_servicio'] = $certificado->dictamen->inspeccion->num_servicio ?? 'No encontrado';
            $nestedData['folio_solicitud'] = $certificado->dictamen->inspeccion->solicitud->folio ?? 'No encontrado';
            //Nombre y Numero empresa
            $empresa = $certificado->dictamen->inspeccion->solicitud->empresa ?? null;
            $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
            $nestedData['numero_cliente'] = $numero_cliente;
            $nestedData['razon_social'] = $certificado->dictamen->inspeccion->solicitud->empresa->razon_social ?? 'No encontrado';
            //Revisiones
            /*$nestedData['revisor_personal'] = $certificado->revisorPersonal->user->name ?? null;
            $nestedData['numero_revision_personal'] = $certificado->revisorPersonal->numero_revision ?? null;
            $nestedData['decision_personal'] = $certificado->revisorPersonal->decision?? null;
            $nestedData['respuestas_personal'] = $certificado->revisorPersonal->respuestas ?? null;
            $nestedData['revisor_consejo'] = $certificado->revisorConsejo->user->name ?? null;
            $nestedData['numero_revision_consejo'] = $certificado->revisorConsejo->numero_revision ?? null;
            $nestedData['decision_consejo'] = $certificado->revisorConsejo->decision ?? null;
            $nestedData['respuestas_consejo'] = $certificado->revisorConsejo->respuestas ?? null;
            */
            ///dias vigencia
            $fechaActual = Carbon::now()->startOfDay();//Obtener la fecha actual sin horas
            $fechaVigencia = Carbon::parse($certificado->fecha_vigencia)->startOfDay();
                if ($fechaActual->isSameDay($fechaVigencia)) {
                    $nestedData['diasRestantes'] = "<span class='badge bg-danger'>Hoy se vence este certificado</span>";
                } else {
                    $diasRestantes = $fechaActual->diffInDays($fechaVigencia, false);//diferencia de "dias" actual a vigencia
                    if ($diasRestantes > 0) {
                        if ($diasRestantes > 15) {
                            $res = "<span class='badge bg-success'>$diasRestantes días de vigencia.</span>";
                        } else {
                            $res = "<span class='badge bg-warning'>$diasRestantes días de vigencia.</span>";
                        }
                        $nestedData['diasRestantes'] = $res;
                    } else {
                        $nestedData['diasRestantes'] = "<span class='badge bg-danger'>Vencido hace " . abs($diasRestantes) . " días.</span>";
                    }
                }
            ///solicitud y acta
            $nestedData['id_solicitud'] = $certificado->dictamen->inspeccion->solicitud->id_solicitud ?? 'No encontrado';
            $urls = $certificado->dictamen?->inspeccion?->solicitud?->documentacion(69)?->pluck('url')?->toArray();
            $nestedData['url_acta'] = (!empty($urls)) ? $urls : 'Sin subir';
            //caracteristicas
            $nestedData['nombre_lote_envasado'] = $certificado->dictamen->lote_envasado->nombre ?? 'No encontrado';
            $nestedData['nombre_lote_granel'] = $certificado->dictamen->lote_envasado->lotesGranel->first()->nombre_lote ?? 'No encontrado';
            //caracteristicas
            $nestedData['marca'] = $certificado->dictamen->lote_envasado->marca->marca ?? 'No encontrado';

            $caracteristicas = json_decode($certificado->solicitud->caracteristicas ?? '', true);
            $nestedData['cajas'] = $caracteristicas['cajas'] ?? 'No encontrado';
            $nestedData['botellas'] = $caracteristicas['botellas'] ?? 'No encontrado';


            $data[] = $nestedData;
        }
    }

    return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => intval($totalData),
        'recordsFiltered' => intval($totalFiltered),
        'code' => 200,
        'data' => $data,
    ]);
}



///FUNCION REGISTRAR
public function store(Request $request)
{
    try {
    
    $validated = $request->validate([
        'id_solicitud' => 'required|exists:solicitudes,id_solicitud',
        'num_certificado' => 'required|string|max:40',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'nullable|date',
        'id_firmante' => 'required|exists:users,id',
    ]);

    // Cargar solicitud con relaciones encadenadas
    $solicitud = solicitudesModel::with('lote_envasado.dictamenEnvasado')->findOrFail($validated['id_solicitud']);

    // Obtener el dictamen directamente
    $dictamen = $solicitud->lote_envasado->dictamenEnvasado;
    if (!$dictamen) {
        return response()->json(['error' => 'No se encontró dictamen para el lote envasado.'], 404);
    }

    // Crear un registro
    $new = new Certificado_Nacional();
    $new->id_solicitud = $validated['id_solicitud'];
    $new->id_dictamen = $dictamen->id_dictamen_envasado;
    //$new->id_dictamen = $validated['id_dictamen'];
    $new->num_certificado = $validated['num_certificado'];
    $new->fecha_emision = $validated['fecha_emision'];
    $new->fecha_vigencia = $validated['fecha_vigencia'];
    $new->id_firmante = $validated['id_firmante'];
    $new->save();

        return response()->json(['message' => 'Registrado correctamente.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al registrar.'. $e], 500);
    }
}


///FUNCION ELIMINAR
public function destroy($id_certificado)
{
    try {
        $eliminar = Certificado_Nacional::findOrFail($id_certificado);
        $eliminar->delete();

        return response()->json(['message' => 'Eliminado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al eliminar', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al eliminar.'], 500);
    }
}


///FUNCION PARA OBTENER LOS REGISTROS
public function edit($id_certificado)
{
    try {
        $editar = Certificado_Nacional::findOrFail($id_certificado);

        return response()->json([
            'id_certificado' => $editar->id_certificado,
            'id_solicitud' => $editar->id_solicitud,
            'id_dictamen' => $editar->id_dictamen,
            'num_certificado' => $editar->num_certificado,
            'fecha_emision' => $editar->fecha_emision,
            'fecha_vigencia' => $editar->fecha_vigencia,
            'id_firmante' => $editar->id_firmante,
        ]);
    } catch (\Exception $e) {
        Log::error('Error al obtener', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al obtener los datos.'], 500);
    }
}

///FUNCION ACTUALIZAR
public function update(Request $request, $id_certificado)
{
    $request->validate([
        'id_solicitud' => 'required|exists:solicitudes,id_solicitud',
        'num_certificado' => 'required|string|max:40',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'nullable|date',
        'id_firmante' => 'required|integer',
    ]);

    try {
        $actualizar = Certificado_Nacional::findOrFail($id_certificado);

        // Obtener dictamen a partir de id_solicitud
        $solicitud = solicitudesModel::with('lote_envasado.dictamenEnvasado')->findOrFail($request['id_solicitud']);
        $dictamen = $solicitud->lote_envasado->dictamenEnvasado;

        if (!$dictamen) {
            return response()->json(['error' => 'No se encontró dictamen para el lote envasado.'], 404);
        }

        $actualizar->id_solicitud = $request->id_solicitud;
        $actualizar->id_dictamen = $dictamen->id_dictamen_envasado;
        $actualizar->num_certificado = $request->num_certificado;
        $actualizar->fecha_emision = $request->fecha_emision;
        $actualizar->fecha_vigencia = $request->fecha_vigencia;
        $actualizar->id_firmante = $request->id_firmante;
        $actualizar->save();

        return response()->json(['message' => 'Actualizado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al actualizar', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al actualizar.'], 500);
    }
}


///PDF CERTIFICADO
public function certificado($id_certificado)
{
    $data = Certificado_Nacional::find($id_certificado);//Obtener datos del certificado

    if (!$data) {
        return abort(404, 'Registro no encontrado.');
        //return response()->json(['message' => 'Registro no encontrado.', $data], 404);
    }

    $fecha_emision = date('d/m/Y', strtotime($data->fecha_emision));
    $fecha_vigencia = $data->fecha_vigencia ? date('d/m/Y', strtotime($data->fecha_vigencia)) : null;
    $empresa = $data->solicitud->empresa ?? null;
    $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
        ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
        ->id && !empty($item->numero_cliente)) ?->numero_cliente ?? 'No encontrado' : 'N/A';
    $id_sustituye = json_decode($data->observaciones, true) ['id_sustituye'] ?? null;
    $nombre_id_sustituye = $id_sustituye ? Certificado_Nacional::find($id_sustituye)->num_certificado ?? 'No encontrado' : '';
    //caracteristicas
    $caracteristicas = json_decode($data->solicitud->caracteristicas ?? '', true);
    $cajas = $caracteristicas['cajas'] ?? 'No encontrado';
    $botellas = $caracteristicas['botellas'] ?? 'No encontrado';

    $pdf =  [
        'data' => $data,
        'expedicion' => $fecha_emision ?? 'No encontrado',
        'vigencia' => $fecha_vigencia ?? 'Indefinido',
        'empresa' => $empresa->razon_social ?? 'No encontrado',
        'n_cliente' => $numero_cliente,
        'domicilio' => $empresa->domicilio_fiscal ?? 'No encontrado',
        'estado' => $empresa->estados->nombre ?? 'No encontrado',
        'rfc' => $empresa->rfc ?? 'No encontrado',
        'cp' => $empresa->cp ?? 'No encontrado',
        'convenio' =>  $empresa->convenio_corresp ?? 'NA',
        'DOM' => $empresa->registro_productor ?? 'NA',
        'envasado_en' =>$data->dictamen->inspeccion->solicitud->instalacion->direccion_completa ?? 'No encontrado',
        'watermarkText' => $data->estatus == 1,
        'id_sustituye' => $nombre_id_sustituye,

        //lote
        'dictamen_envasado' =>$data->dictamen->num_dictamen ?? 'No encontrado',
        'certificado_granel' => $data->dictamen->inspeccion->solicitud->lote_envasado->lotesGranel->first()->folio_certificado ?? 'No encontrado',
        'lote_envasado' =>$data->dictamen->inspeccion->solicitud->lote_envasado->nombre ?? 'No encontrado',
        'lote_granel' =>$data->dictamen->inspeccion->solicitud->lote_envasado->lotesGranel->first()->nombre_lote ?? 'No encontrado',
        'categoria' =>$data->dictamen->inspeccion->solicitud->lote_envasado->lotesGranel->first()->categoria->categoria ?? 'No encontrado',
        'clase' =>$data->dictamen->inspeccion->solicitud->lote_envasado->lotesGranel->first()->clase->clase ?? 'No encontrado',
        'cont_alc' =>$data->dictamen->inspeccion->solicitud->lote_envasado->lotesGranel->first()->cont_alc ?? 'No encontrado',
        'marca' =>$data->dictamen->inspeccion->solicitud->lote_envasado->marca->marca ?? 'No encontrado',
        'presentacion' =>$data->dictamen->inspeccion->solicitud->lote_envasado->presentacion ?? 'No encontrado',
        'unidad' =>$data->dictamen->inspeccion->solicitud->lote_envasado->unidad ?? 'No encontrado',
        'analisis_fq' =>$data->dictamen->inspeccion->solicitud->lote_envasado->lotesGranel->first()->folio_fq ?? 'No encontrado',
        'sku' =>json_decode($data->dictamen->inspeccion->solicitud->lote_envasado->sku ?? '{}', true)['inicial'] ?? 'Sin sku',

        'botellas' =>$botellas,
        'cajas' =>$cajas,
        'hologramas' =>'Falta',
    ];

    return Pdf::loadView('pdfs.certificado_nacional_ed1', $pdf)->stream('F7.1-01-23 Ver 1. Certificado de nacionalidad.pdf');
}








}//end-classController
