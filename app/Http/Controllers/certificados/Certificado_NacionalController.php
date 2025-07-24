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
use App\Models\activarHologramasModelo;
use App\Models\Documentacion_url;
use App\Models\Dictamen_Envasado;
///Extensiones
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\GeneralNotification;


class Certificado_NacionalController extends Controller
{

    public function UserManagement()
    {   
        $certificados = Certificado_Nacional::where('estatus', '!=', 1)
            ->orderBy('id_certificado', 'desc')
            ->get();
        $solicitud = solicitudesModel::where('id_tipo',13)
            ->orderBy('id_solicitud', 'desc')
            ->get();
        $users = User::where('tipo',1)->get(); //Solo Personal OC
        $empresa = empresa::where('tipo', 2)->get();
        //$revisores = Revisor::all();
        $hologramas = activarHologramasModelo::all();

        return view('certificados.find_certificados_nacional', compact('certificados','solicitud', 'users', 'empresa', 'hologramas'));
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
            $nestedData['id_solicitud_nacional'] = $certificado->solicitud->id_solicitud ?? 'No encontrado';
            $nestedData['folio_solicitud_nacional'] = $certificado->solicitud->folio ?? 'No encontrado';
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
            $nestedData['revisor_personal'] = $certificado->revisorPersonal->user->name ?? null;
            $nestedData['numero_revision_personal'] = $certificado->revisorPersonal->numero_revision ?? null;
            $nestedData['decision_personal'] = $certificado->revisorPersonal->decision?? null;
            $nestedData['respuestas_personal'] = $certificado->revisorPersonal->respuestas ?? null;
            $nestedData['revisor_consejo'] = $certificado->revisorConsejo->user->name ?? null;
            $nestedData['numero_revision_consejo'] = $certificado->revisorConsejo->numero_revision ?? null;
            $nestedData['decision_consejo'] = $certificado->revisorConsejo->decision ?? null;
            $nestedData['respuestas_consejo'] = $certificado->revisorConsejo->respuestas ?? null;
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


///FUNCION REEXPEDIR
public function reexpedir(Request $request)
{
    //try {
        $request->validate([
            'accion_reexpedir' => 'required|in:1,2',
            'observaciones' => 'nullable|string',
        ]);

        if ($request->accion_reexpedir == '2') {
            $request->validate([
                'id_solicitud' => 'required|exists:solicitudes,id_solicitud',
                //'id_dictamen' => 'required|integer',
                'num_certificado' => 'required|string|min:8',
                'fecha_emision' => 'required|date',
                'fecha_vigencia' => 'nullable|date',
                'id_firmante' => 'required|integer',
            ]);
        }

        $reexpedir = Certificado_Nacional::findOrFail($request->id_certificado);

        // Obtener dictamen a partir de id_solicitud
        $solicitud = solicitudesModel::with('lote_envasado.dictamenEnvasado')->findOrFail($request['id_solicitud']);
        $dictamen = $solicitud->lote_envasado->dictamenEnvasado;
        if (!$dictamen) {
            return response()->json(['error' => 'No se encontró dictamen para el lote envasado.'], 404);
        }


        if ($request->accion_reexpedir == '1') {
            $reexpedir->estatus = 1;
            
            $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
            $reexpedir->observaciones = json_encode($observacionesActuales);
            $reexpedir->save();
            return response()->json(['message' => 'Cancelado correctamente.']);

        } elseif ($request->accion_reexpedir == '2') {
            $reexpedir->estatus = 1;
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
            $reexpedir->observaciones = json_encode($observacionesActuales);
            $reexpedir->save();

            // Crear un nuevo registro de reexpedición
            $new = new Certificado_Nacional();
            $new->id_solicitud = $request->id_solicitud;
            $new->num_certificado = $request->num_certificado;
            $new->id_dictamen = $dictamen->id_dictamen_envasado;
            $new->fecha_emision = $request->fecha_emision;
            $new->fecha_vigencia = $request->fecha_vigencia;
            $new->id_firmante = $request->id_firmante;
            $new->estatus = 2;
            $new->observaciones = json_encode(['id_sustituye' => $request->id_certificado]);
            $new->save();

            return response()->json(['message' => 'Registrado correctamente.']);
        }

        return response()->json(['message' => 'Procesado correctamente.']);
    /*} catch (\Exception $e) {
        Log::error('Error al reexpedir', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al procesar.'], 500);
    }*/
}






///OBTENER REVISION ASIGNADA
public function obtenerRevision($id_certificado)
{
    // Obtener la primera revisión (tipo_revision = 1)
    $revision = Revisor::where('id_certificado', $id_certificado)
        ->where('tipo_certificado', 4)
        ->where('tipo_revision', 1) // fija
        ->first();

    if (!$revision) {
        return response()->json(['exists' => false]);
    }

    $documento = Documentacion_url::where('id_relacion', $revision->id_revision)
        ->where('id_documento', 133) 
        ->first();

    return response()->json([
        'exists' => true,
        'observaciones' => $revision->observaciones,
        'es_correccion' => $revision->es_correccion,
        'documento' => $documento ? [
            'nombre' => $documento->nombre_documento,
            'url' => asset('storage/revisiones/' . $documento->url),
        ] : null,
    ]);
}
///ELIMINAR DOCUMENTO REVISION
public function eliminarDocumentoRevision($id_certificado)
{
    // Buscar el revisor con tipo_certificado 4 (puedes limitar más si quieres)
    $revisor = Revisor::where('id_certificado', $id_certificado)
        ->where('tipo_certificado', 4)
        ->where('tipo_revision', 1)
        ->first();

    if (!$revisor) {
        return response()->json(['message' => 'Revisión no encontrada.'], 404);
    }

    $documento = Documentacion_url::where('id_relacion', $revisor->id_revision)
        ->where('id_documento', 133) // Asegúrate del ID correcto
        ->first();

    if (!$documento) {
        return response()->json(['message' => 'Documento no encontrado.'], 404);
    }

    // Eliminar archivo físico
    Storage::disk('public')->delete('revisiones/' . $documento->url);
    // Eliminar de BD
    $documento->delete();

    return response()->json(['message' => 'Documento eliminado correctamente.']);
}

///ASIGNAR REVISION
public function storeRevisor(Request $request)
{
    $validated = $request->validate([
        'numeroRevision' => 'required|string|max:50',
        'personalOC' => 'nullable|integer|exists:users,id',
        'miembroConsejo' => 'nullable|integer|exists:users,id',
        'esCorreccion' => 'nullable|in:si,no',
        'observaciones' => 'nullable|string|max:5000',
        'id_certificado' => 'required|integer|exists:certificados_nacional,id_certificado',
        'url' => 'nullable|file|mimes:pdf|max:3072',
        'nombre_documento' => 'nullable|string|max:255',

        'certificados' => 'nullable|array',
        'certificados.*' => 'integer|exists:certificados_nacional,id_certificado',
    ]);

    $certificado = Certificado_Nacional::find($validated['id_certificado']);
    $empresa = $certificado->dictamen->inspeccione->solicitud->empresa;
    $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();


    $nombreArchivo = null;
    // Subida de archivo solo 1 vez (para todos)
    if ($request->hasFile('url')) {
        $file = $request->file('url');
        $nombreArchivo = str_replace('/', '-', $validated['nombre_documento']) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('revisiones/', $nombreArchivo, 'public');
    }

     // --- Guardar revisiones del certificado principal ---
    $guardar = function ($idRevisor, $tipoRevisor, $conDocumento = false) use ($validated, $certificado, $empresa, $request, $numeroCliente, $nombreArchivo)
    {
        if (!$idRevisor) return;

        $revisor = Revisor::firstOrNew([
            'id_certificado' => $certificado->id_certificado,
            'tipo_certificado' => 4,
            'tipo_revision' => $tipoRevisor,
        ]);

        $revisor->id_revisor = $idRevisor;
        $revisor->numero_revision = $validated['numeroRevision'];
        $revisor->es_correccion = $validated['esCorreccion'] ?? 'no';
        $revisor->observaciones = $validated['observaciones'] ?? '';
        $revisor->decision = 'Pendiente';
        $revisor->save();

        // Documento (solo si tipo = 1 y subido)
        if ($conDocumento && $nombreArchivo) {
            // Eliminar documento anterior si existe
            $docAnterior = Documentacion_url::where('id_relacion', $revisor->id_revision)
                ->where('id_documento', 133)
                ->first();
            if ($docAnterior) {
                Storage::disk('public')->delete('revisiones/' . $docAnterior->url);
                $docAnterior->delete();
            }

            // Crear nuevo documento
            Documentacion_url::create([
                'id_relacion' => $revisor->id_revision,
                'id_documento' => 133,
                'id_empresa' => $empresa->id_empresa,
                'nombre_documento' => $validated['nombre_documento'],
                'url' => $nombreArchivo,
            ]);
        }


        // Notificación
        $user = User::find($idRevisor);
        if ($user) {
            $url_clic = $tipoRevisor == 1 ? "/add_revision/{$revisor->id_revision}" : "/add_revision_consejo/{$revisor->id_revision}";

            $user->notify(new GeneralNotification([
                'asunto' => 'Revisión de certificado ' . $certificado->num_certificado,
                'title' => 'Revisión de certificado',
                'message' => 'Se te ha asignado el certificado ' . $certificado->num_certificado,
                'url' => $url_clic,
                'nombreRevisor' => $user->name,
                'emailRevisor' => $user->email,
                'num_certificado' => $certificado->num_certificado,
                'fecha_emision' => Helpers::formatearFecha($certificado->fecha_emision),
                'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia),
                'razon_social' => $empresa->razon_social ?? 'Sin asignar',
                'numero_cliente' => $numeroCliente ?? 'Sin asignar',
                'tipo_certificado' => 'Certificado nacional',
                'observaciones' => $revisor->observaciones,
            ]));
        }


        // Siempre sincronizar si existen AMBOS tipos (1 y 2) para el certificado principal
        $revisiones = Revisor::where('id_certificado', $certificado->id_certificado)
            ->where('tipo_certificado', 4)
            ->whereIn('tipo_revision', [1, 2])
            ->get();

        if ($revisiones->count() === 2) {
            foreach ($revisiones as $rev) {
                $rev->observaciones = $validated['observaciones'] ?? '';
                $rev->es_correccion = $validated['esCorreccion'] ?? 'no';
                $rev->save();

                // Solo actualizar documento en tipo_revision = 1
                if ($rev->tipo_revision == 1 && $nombreArchivo) {
                    $docAnterior = Documentacion_url::where('id_relacion', $rev->id_revision)
                        ->where('id_documento', 133)
                        ->first();
                    if ($docAnterior) {
                        Storage::disk('public')->delete('revisiones/' . $docAnterior->url);
                        $docAnterior->delete();
                    }

                    Documentacion_url::create([
                        'id_relacion' => $rev->id_revision,
                        'id_documento' => 133,
                        'id_empresa' => $empresa->id_empresa,
                        'nombre_documento' => $validated['nombre_documento'],
                        'url' => $nombreArchivo,
                    ]);
                }
            }
        }

    };


    // Guardar revisores principales
    if ($request->filled('personalOC')) $guardar($validated['personalOC'], 1, true);
    if ($request->filled('miembroConsejo')) $guardar($validated['miembroConsejo'], 2, false);

        // --- Guardar revisiones de certificados seleccionados ---
        if (!empty($validated['certificados'])) {
            foreach ($validated['certificados'] as $idRelacionado) {
                $certRelacionado = Certificado_Nacional::find($idRelacionado);
                if (!$certRelacionado) continue;

                foreach ([1, 2] as $tipoRev) {
                    $revis = Revisor::where('id_certificado', $idRelacionado)
                        ->where('tipo_certificado', 4)
                        ->where('tipo_revision', $tipoRev)
                        ->first();

                    if ($revis) {
                        // Solo sincronizar observaciones
                        $revis->observaciones = $validated['observaciones'] ?? '';
                        $revis->save();
                    } else {
                        // Crear nueva revisión (solo observaciones)
                        $revis = new Revisor();
                        $revis->id_certificado = $idRelacionado;
                        $revis->tipo_revision = $tipoRev;
                        $revis->tipo_certificado = 4;
                        $revis->observaciones = $validated['observaciones'] ?? '';
                        $revis->save();
                    }

                    // Subir documento solo si es tipo 1 y hay archivo
                    if ($tipoRev === 1 && $nombreArchivo) {
                        // Eliminar anterior si existe
                        $docAnterior = Documentacion_url::where('id_relacion', $revis->id_revision)
                            ->where('id_documento', 133)
                            ->first();
                        if ($docAnterior) {
                            Storage::disk('public')->delete('revisiones/' . $docAnterior->url);
                            $docAnterior->delete();
                        }

                        Documentacion_url::create([
                            'id_relacion' => $revis->id_revision,
                            'id_documento' => 133,
                            'id_empresa' => $empresa->id_empresa,
                            'nombre_documento' => $validated['nombre_documento'],
                            'url' => $nombreArchivo,
                        ]);
                    }
                }
            }
        }


    return response()->json(['message' => 'Revisor asignado correctamente.']);
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
        'watermarkText' => $data->estatus == 1,
        'id_sustituye' => $nombre_id_sustituye,
        'botellas' =>$botellas,
        'cajas' =>$cajas,
        'hologramas' =>'Falta',
        //datos del dictamen (lote)
        'dictamen_envasado' =>$data->dictamen->num_dictamen ?? 'No encontrado',
        'certificado_granel' => $data->dictamen->inspeccion->solicitud->lote_envasado?->lotesGranel->first()->folio_certificado ?? 'No encontrado',
        'lote_envasado' =>$data->dictamen->inspeccion->solicitud->lote_envasado->nombre ?? 'No encontrado',
        'lote_granel' =>$data->dictamen->inspeccion->solicitud->lote_envasado?->lotesGranel->first()->nombre_lote ?? 'No encontrado',
        'categoria' =>$data->dictamen->inspeccion->solicitud->lote_envasado?->lotesGranel->first()->categoria->categoria ?? 'No encontrado',
        'clase' =>$data->dictamen->inspeccion->solicitud->lote_envasado?->lotesGranel->first()->clase->clase ?? 'No encontrado',
        'cont_alc' =>$data->dictamen->inspeccion->solicitud->lote_envasado?->lotesGranel->first()->cont_alc ?? 'No encontrado',
        'marca' =>$data->dictamen->inspeccion->solicitud->lote_envasado->marca->marca ?? 'No encontrado',
        'presentacion' =>$data->dictamen->inspeccion->solicitud->lote_envasado->presentacion ?? 'No encontrado',
        'unidad' =>$data->dictamen->inspeccion->solicitud->lote_envasado->unidad ?? 'No encontrado',
        'analisis_fq' =>$data->dictamen->inspeccion->solicitud->lote_envasado?->lotesGranel->first()->folio_fq ?? 'No encontrado',
        'sku' =>json_decode($data->dictamen->inspeccion->solicitud->lote_envasado->sku ?? '{}', true)['inicial'] ?? 'Sin sku',
        'envasado_en' =>$data->dictamen->inspeccion->solicitud->instalacion->direccion_completa ?? 'No encontrado',
    ];

    return Pdf::loadView('pdfs.certificado_nacional_ed1', $pdf)->stream('F7.1-01-23 Ver 1. Certificado de venta nacional.pdf');
}








}//end-classController
