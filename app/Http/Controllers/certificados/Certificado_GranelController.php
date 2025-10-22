<?php

namespace App\Http\Controllers\certificados;

use App\Helpers\Helpers;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CertificadosGranel;
use App\Models\Dictamen_Granel;
use App\Models\User;
use App\Models\solicitudesModel;
use App\Models\Revisor;
use App\Models\LotesGranel;
use App\Models\maquiladores_model;
//Notificacion
use App\Notifications\GeneralNotification;
//Enviar Correo
use App\Mail\CorreoCertificado;
use App\Models\Documentacion_url;
use App\Models\empresa;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DirectorioGranel;


class Certificado_GranelController extends Controller
{
    public function UserManagement()
    {
        $certificados = CertificadosGranel::where('estatus', '!=', 1)
            ->orderBy('id_certificado', 'desc')
            ->get();
        /*$dictamenes = Dictamen_Granel::with('inspeccione.solicitud')
            ->whereHas('inspeccione.solicitud', function ($query) {
            $query->where('id_tipo', '!=', 2);
            })
            ->where('estatus','!=',1)
            ->orderBy('id_dictamen', 'desc')
            ->get();*/
        $dictamenes = Dictamen_Granel::with('inspeccione.solicitud')
            ->whereHas('inspeccione.solicitud', function ($query) {
            $query->where('id_tipo', '!=', 2);
            })
            ->where('estatus','!=',1)
            ->whereDoesntHave('certificado') // Solo los dictámenes sin certificado
            ->where('fecha_emision','>','2021-12-31')
            ->orderBy('id_dictamen', 'desc')
            ->get();
        $users = User::where('tipo', 1)
            ->where('id', '!=', 1)
            ->where('estatus', '!=', 'Inactivo')
            ->get();
        $revisores = Revisor::all();

        $empresa = empresa::where('tipo', 2)->get();

        return view('certificados.find_certificados_granel', compact('certificados' , 'dictamenes' , 'users', 'revisores', 'empresa'));
    }


private function obtenerEmpresasVisibles($empresaId)
{
      $idsEmpresas = [];
      if ($empresaId) {
          $idsEmpresas[] = $empresaId;
          $idsEmpresas = array_merge(
              $idsEmpresas,
              maquiladores_model::where('id_maquiladora', $empresaId)->pluck('id_maquilador')->toArray()
          );
      }

      return array_unique($idsEmpresas);
}

public function index(Request $request)
{
    //Permiso de empresa
    $empresaId = null;
    $instalacionAuth = [];
    if (Auth::check() && Auth::user()->tipo == 3) {
        $empresaId = Auth::user()->empresa?->id_empresa;
        $instalacionAuth = (array) Auth::user()->id_instalacion;
        $instalacionAuth = array_filter(array_map('intval', $instalacionAuth), fn($id) => $id > 0);

        // Si no tiene instalaciones, no ve nada
        if (empty($instalacionAuth)) {
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'code' => 200,
                'data' => []
            ]);
        }
    }


    DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para meses
    // Mapear las columnas según el orden DataTables (índice JS)
    $columns = [
        1 => 'num_certificado',
        2 => 'folio',
        3 => 'razon_social',
        4 => '',
        5 => 'fecha_emision',
        6 => 'estatus',
    ];

    $limit = $request->input('length');
    $start = $request->input('start');
    $orderColumnIndex = $request->input('order.0.column');
    $orderDirection = $request->input('order.0.dir') ?? 'asc';
    $orderColumn = $columns[$orderColumnIndex] ?? 'num_certificado';// Por defecto

    $search = $request->input('search.value');


    $query = CertificadosGranel::query()
        ->leftJoin('dictamenes_granel', 'dictamenes_granel.id_dictamen', '=', 'certificados_granel.id_dictamen')
        ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_granel.id_inspeccion')
        ->leftJoin('solicitudes', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
        ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa')
        ->leftJoin('lotes_granel', 'lotes_granel.id_lote_granel', '=', 'certificados_granel.id_lote_granel')
        ->select('certificados_granel.*', 'empresa.razon_social');

    // Filtro por empresa
    if ($empresaId) {
        $empresasVisibles = $this->obtenerEmpresasVisibles($empresaId);
        $query->whereIn('solicitudes.id_empresa', $empresasVisibles);
    }
    // Filtro por instalaciones del usuario
    if (!empty($instalacionAuth)) {
        $query->whereIn('solicitudes.id_instalacion', $instalacionAuth);
    }

    $baseQuery = clone $query;
    $totalData = $baseQuery->count();


    // Búsqueda Global
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('certificados_granel.num_certificado', 'LIKE', "%{$search}%")
            ->orWhere('dictamenes_granel.num_dictamen', 'LIKE', "%{$search}%")
            ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
            ->orWhere('empresa.razon_social', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(certificados_granel.fecha_emision, '%d de %M del %Y') LIKE ?", ["%$search%"])
            ->orWhere('lotes_granel.nombre_lote', 'LIKE', "%{$search}%")
            ->orWhere('lotes_granel.folio_fq', 'LIKE', "%{$search}%");
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }


    // Ordenamiento especial para num_certificado con formato 'CIDAM C-GRA25-###'
    if ($orderColumn === 'num_certificado') {
        $query->orderByRaw("
            CASE
                WHEN num_certificado LIKE 'CIDAM C-GRA25-%' THEN 0
                ELSE 1
            END ASC,
            CAST(
                SUBSTRING_INDEX(
                    SUBSTRING(num_certificado, LOCATE('CIDAM C-GRA25-', num_certificado) + 14),
                    '-', 1
                ) AS UNSIGNED
            ) $orderDirection
        ");
    } else {
        $query->orderBy($orderColumn, $orderDirection);
    }


    // Paginación
    $certificados = $query
        ->with([// 1 consulta por cada tabla relacionada en conjunto (menos busqueda adicionales de query en BD)
            'dictamen',// Relación directa
            'dictamen.inspeccione',// Relación anidada: dictamen > inspeccione
            'dictamen.inspeccione.solicitud',
            'dictamen.inspeccione.solicitud.empresa',
            'dictamen.inspeccione.solicitud.empresa.empresaNumClientes',
            'revisorPersonal.user',
            'revisorConsejo.user',
        ])->offset($start)->limit($limit)->get();



    //MANDA LOS DATOS AL JS
    $data = [];
    if (!empty($certificados)) {
        foreach ($certificados as $certificado) {
            $nestedData['id_certificado'] = $certificado->id_certificado ?? 'No encontrado';
            $nestedData['num_certificado'] = $certificado->num_certificado ?? 'No encontrado';
            $nestedData['id_dictamen'] = $certificado->dictamen->id_dictamen ?? 'No encontrado';
            $nestedData['num_dictamen'] = $certificado->dictamen->num_dictamen ?? 'No encontrado';
            //obtener solicitud de emision
            $solicitud_emision = $certificado
                ->hasOne(solicitudesModel::class, 'id_predio', 'id_certificado')
                ->where('id_tipo', 12)
                ->first();
            $nestedData['id_solicitud_emision'] = $solicitud_emision->id_solicitud ?? 'No encontrado';
            $nestedData['folio_solicitud_emision'] = $solicitud_emision->folio ?? 'No encontrado';
            $nestedData['estatus'] = $certificado->estatus ?? 'No encontrado';
            $id_sustituye = json_decode($certificado->observaciones, true) ['id_sustituye'] ?? null;
            $nestedData['sustituye'] = $id_sustituye ? CertificadosGranel::find($id_sustituye)->num_certificado ?? 'No encontrado' : null;
            $nestedData['motivo']  = json_decode($certificado->observaciones, true) ['observaciones'] ?? null;
            $nestedData['fecha_emision'] = Helpers::formatearFecha($certificado->fecha_emision);
            $nestedData['fecha_vigencia'] = Helpers::formatearFecha($certificado->fecha_vigencia);
            ///Folio y no. servicio
            $nestedData['num_servicio'] = $certificado->dictamen->inspeccione->num_servicio ?? 'No encontrado';
            $nestedData['folio_solicitud'] = $certificado->dictamen->inspeccione->solicitud->folio ?? 'No encontrado';
            //Nombre y Numero empresa
            $empresa = $certificado->dictamen->inspeccione->solicitud->empresa ?? null;
            $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
            $nestedData['numero_cliente'] = $numero_cliente;
            $nestedData['razon_social'] = $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';
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
            $fechaActual = Carbon::now()->startOfDay(); //Asegúrate de trabajar solo con fechas, sin horas
            $fechaVigencia = Carbon::parse($certificado->fecha_vigencia)->startOfDay();
                if ($fechaActual->isSameDay($fechaVigencia)) {
                    $nestedData['diasRestantes'] = "<span class='badge bg-danger'>Hoy se vence este certificado</span>";
                } else {
                    $diasRestantes = $fechaActual->diffInDays($fechaVigencia, false);
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
            $nestedData['id_solicitud'] = $certificado->dictamen->inspeccione->solicitud->id_solicitud ?? 'No encontrado';
            $urls = $certificado->dictamen?->inspeccione?->solicitud?->documentacion(69)?->pluck('url')?->toArray();
            $nestedData['url_acta'] = (!empty($urls)) ? $urls : 'Sin subir';
            //Lote granel
            $caracteristicas = json_decode($certificado->dictamen?->inspeccione?->solicitud?->caracteristicas, true);
                $idLote = $caracteristicas['id_lote_granel'] ?? null;
            $loteGranel = LotesGranel::find($idLote);
            $nestedData['nombre_lote'] = $loteGranel?->nombre_lote ?? 'No encontrado';
            //obtener folios FQ con URL
                $empresa_granel = $loteGranel->empresa ?? null;
                $num_cliente_granel = $empresa_granel && $empresa_granel->empresaNumClientes->isNotEmpty()
                    ? $empresa_granel->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa_granel
                    ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
            $folios = array_map('trim', explode(',', $loteGranel?->folio_fq ?? ''));//separo los folios
            $documentosFQ = $loteGranel?->fqs ?? collect(); // Relación ya filtrada por 58 y 134
            $urls = $documentosFQ->pluck('url')->toArray();//obtengo la url
            $fq_documentos = [];//inicializo
            foreach ($folios as $index => $folio) {
                $fq_documentos[] = [
                    'folio' => !empty($folio) ? $folio : null,
                    'url' => isset($urls[$index]) ? asset("files/{$num_cliente_granel}/fqs/{$urls[$index]}") : null
                ];
            }
            $fq_documentos = array_filter($fq_documentos, fn($item) => !empty($item['folio']));
            $nestedData['fq_documentos'] = array_values($fq_documentos);

            //Certificado Firmado
            $documentacion = Documentacion_url::where('id_relacion', $idLote)
                ->where('id_documento', 59)->where('id_doc', $certificado->id_certificado) ->first();
            $nestedData['pdf_firmado'] = $documentacion?->url
                ? asset("files/{$numero_cliente}/certificados_granel/{$documentacion->url}") : null;


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



///FUNCION EXPORTAR DIRECTORIO
public function exportarDirectorio(Request $request)
{
    $filtros = $request->only(['id_empresa', 'anio', 'mes', 'estatus']);
    return Excel::download(new DirectorioGranel($filtros), '.xlsx');
}



///FUNCION REGISTRAR
public function store(Request $request)
{
    try {
    $validated = $request->validate([
        'id_dictamen' => 'required|integer',
        'num_certificado' => 'required|string',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'required|date',
        'id_firmante' => 'required|integer',
    ]);

    $dictamen = Dictamen_Granel::with('inspeccione.solicitud')->find($validated['id_dictamen']);
    $idLoteGranel = $dictamen->inspeccione->solicitud->id_lote_granel ?? null;

    $new = CertificadosGranel::create([
        'id_dictamen' => $validated['id_dictamen'],
        'num_certificado' => $validated['num_certificado'],
        'fecha_emision' => $validated['fecha_emision'],
        'fecha_vigencia' => $validated['fecha_vigencia'],
        'id_firmante' => $validated['id_firmante'],
        'id_lote_granel' => $idLoteGranel
    ]);

        //Actualizar lote granel
        $lote = LotesGranel::find($idLoteGranel);
        $lote->folio_certificado = $validated['num_certificado'];
        $lote->fecha_emision = $validated['fecha_emision'];
        $lote->fecha_vigencia = $validated['fecha_vigencia'];
        $lote->update();

        // Crear solicitud de emision de certificado
        $newSoli = new solicitudesModel();
        $newSoli->id_tipo = 12;
        $newSoli->id_empresa = $dictamen->inspeccione->solicitud->id_empresa ?? '0';
        $newSoli->folio = Helpers::generarFolioSolicitud();
        $newSoli->estatus = 'Emitido';
        $newSoli->fecha_solicitud = $validated['fecha_emision'];
        $newSoli->fecha_visita = $validated['fecha_emision'];
        $newSoli->id_instalacion =  $dictamen->inspeccione->solicitud->id_instalacion ?? '0';
        $newSoli->id_predio = $new->id_certificado;
        // Guardar datos como JSON
        $newSoli->caracteristicas = json_encode([
            'id_lote_granel' => $idLoteGranel ?? '0',
            'id_dictamen' => $dictamen->id_dictamen ?? '0'
            ]);
        $newSoli->save();

        return response()->json(['message' => 'Registrado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al registrar', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al registrar.'], 500);
    }
}



///FUNCION ELIMINAR
public function destroy($id_certificado)
{
    try {
        // Buscar el certificado
        $eliminar = CertificadosGranel::findOrFail($id_certificado);

        // Eliminar todos los revisores asociados al certificado en la tabla certificados_revision
        Revisor::where('id_certificado', $id_certificado)->delete();

        // Eliminar la solicitud asociada (id_predio = id_certificado, id_tipo = 12)
        solicitudesModel::where('id_predio', $id_certificado)
            ->where('id_tipo', 12)
            ->delete();

        // Luego, eliminar el certificado
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
public function edit($id)
{
    //$certificado = CertificadosGranel::find($id);
    $certificado = CertificadosGranel::with('dictamen.inspeccione.solicitud')->findOrFail($id);


    if ($certificado) {
        return response()->json([
            'certificado' => $certificado,
            'folio' => $certificado->dictamen->inspeccione->solicitud->folio ?? '',
            'num_dictamen' => $certificado->dictamen->num_dictamen ?? ''
        ]);
    }

    return response()->json(['error' => 'Error al obtener los datos.'], 500);
}

///FUNCION ACTUALIZAR
public function update(Request $request, $id_certificado)
{
    $validated = $request->validate([
        'id_firmante' => 'required|integer',
        'id_dictamen' => 'required|integer',
        'num_certificado' => 'required|string',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'required|date',
    ]);

    try {
        $actualizar = CertificadosGranel::findOrFail($id_certificado);

        $dictamen = Dictamen_Granel::with('inspeccione.solicitud')->find($validated['id_dictamen']);
        $idLoteGranel = $dictamen->inspeccione->solicitud->id_lote_granel ?? null;


        $actualizar->update([
            'id_firmante' => $validated['id_firmante'],
            'id_dictamen' => $validated['id_dictamen'],
            'num_certificado' => $validated['num_certificado'],
            'fecha_emision' => $validated['fecha_emision'],
            'fecha_vigencia' => $validated['fecha_vigencia'],
            'id_lote_granel' => $idLoteGranel
        ]);

        $lote = LotesGranel::find($idLoteGranel);
        $lote->folio_certificado = $validated['num_certificado'];
        $lote->update();


        $soli = solicitudesModel::where('id_predio', $id_certificado)
            ->where('id_tipo', 12)
            ->first();
        $soli->id_empresa = $dictamen->inspeccione->solicitud->id_empresa ?? '0';
        $soli->fecha_solicitud = $validated['fecha_emision'];
        $soli->fecha_visita = $validated['fecha_emision'];
        $soli->id_instalacion =  $dictamen->inspeccione->solicitud->id_instalacion ?? '0';
        $soli->caracteristicas = json_encode([
            'id_lote_granel' => $idLoteGranel ?? '0',
            'id_dictamen' => $dictamen->id_dictamen ?? '0'
            ]);
        $soli->update();


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
    try {
        $request->validate([
            'accion_reexpedir' => 'required|in:1,2',
            'observaciones' => 'nullable|string',
        ]);

        if ($request->accion_reexpedir == '2') {
            $request->validate([
            'id_firmante' => 'required|integer',
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string|min:19',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'observaciones' => 'nullable|string',
            ]);
        }

        $reexpedir = CertificadosGranel::findOrFail($request->id_certificado);
        //obtener solicitud de emision
        $solicitud_emision = solicitudesModel::where('id_predio', $request->id_certificado)
            ->where('id_tipo', 12)
            ->first();
        $dictamen = Dictamen_Granel::with('inspeccione.solicitud')->find($request['id_dictamen']);
        $idLoteGranel = $dictamen->inspeccione->solicitud->id_lote_granel ?? null;


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

            // Crear un nuevo registro de certificado (reexpedición)
            $new = new CertificadosGranel();
            $new->id_dictamen = $request->id_dictamen;
            $new->num_certificado = $request->num_certificado;
            $new->fecha_emision = $request->fecha_emision;
            $new->fecha_vigencia = $request->fecha_vigencia;
            $new->id_firmante = $request->id_firmante;
            $new->estatus = 2;
            $new->observaciones = json_encode(['id_sustituye' => $request->id_certificado]);
            $new->id_lote_granel = $idLoteGranel;
            // Guarda el nuevo certificado
            $new->save();

            $solicitud_emision->update([
                'id_predio' => $new->id_certificado,
            ]);

            return response()->json(['message' => 'Registrado correctamente.']);
        }

        return response()->json(['message' => 'Procesado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al reexpedir', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al procesar.'], 500);
    }
}




///OBTENER REVISION ASIGNADA
public function obtenerRevision($id_certificado)
{
    // Obtener la primera revisión (tipo_revision = 1)
    $revision = Revisor::where('id_certificado', $id_certificado)
        ->where('tipo_certificado', 2)
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
    // Buscar el revisor con tipo_certificado 2 (puedes limitar más si quieres)
    $revisor = Revisor::where('id_certificado', $id_certificado)
        ->where('tipo_certificado', 2)
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
        'id_certificado' => 'required|integer|exists:certificados_granel,id_certificado',
        'url' => 'nullable|file|mimes:pdf|max:3072',
        'nombre_documento' => 'nullable|string|max:255',

        'certificados' => 'nullable|array',
        'certificados.*' => 'integer|exists:certificados_granel,id_certificado',
    ]);

    $certificado = CertificadosGranel::find($validated['id_certificado']);
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
            'tipo_certificado' => 2,
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
                'tipo_certificado' => 'Certificado granel',
                'observaciones' => $revisor->observaciones,
            ]));
        }


        // Siempre sincronizar si existen AMBOS tipos (1 y 2) para el certificado principal
        $revisiones = Revisor::where('id_certificado', $certificado->id_certificado)
            ->where('tipo_certificado', 2)
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
                $certRelacionado = CertificadosGranel::find($idRelacionado);
                if (!$certRelacionado) continue;

                foreach ([1, 2] as $tipoRev) {
                    $revis = Revisor::where('id_certificado', $idRelacionado)
                        ->where('tipo_certificado', 2)
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
                        $revis->tipo_certificado = 2;
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
public function CertificadoGranel($id_certificado, $conMarca = true)
{
    $certificado = CertificadosGranel::find($id_certificado);

    if (!$certificado) {
        return abort(404, 'Registro no encontrado.');
        //return response()->json(['message' => 'Registro no encontrado.', $data], 404);
    }

    setlocale(LC_TIME, 'es_ES.UTF-8'); // Asegúrate de tener el locale en español
    $fecha = Carbon::parse($certificado->fecha_emision);
    $fecha_emision = $fecha->format('d') . '/' . ucfirst($fecha->translatedFormat('F')) . '/' . $fecha->format('Y');
    $fecha2 = Carbon::parse($certificado->fecha_vigencia);
    $fecha_vigencia = $fecha2->format('d') . '/' . ucfirst($fecha2->translatedFormat('F')) . '/' . $fecha2->format('Y');

    $watermarkText = $certificado->estatus === 1;
    $id_sustituye = json_decode($certificado->observaciones, true)['id_sustituye'] ?? null; //obtiene el valor del JSON/sino existe es null
    $nombre_id_sustituye = $id_sustituye ? CertificadosGranel::find($id_sustituye)->num_certificado ?? 'No encontrado' : '';

    // Obtener el volumen según el estatus
    $volumen = ($certificado->estatus == 2) 
        ? $certificado->dictamen->inspeccione->solicitud->lote_granel->volumen_restante ?? null
        : $certificado->dictamen->inspeccione->solicitud->lote_granel->volumen ?? null;
    // Formatear según condiciones
    $volumen = ($volumen === null)
    ? 'No encontrado'
    : (fmod($volumen, 1) == 0 ? (int)$volumen : number_format($volumen, 2, '.', ''));// Tiene decimales, mostrar hasta dos

    // Datos para el PDF
    $pdfData = [
        'data' => $certificado,
        'num_certificado' => $certificado->num_certificado ?? 'No encontrado',
        'fecha_emision' => $fecha_emision,
        'fecha_vigencia' => $fecha_vigencia,
        'razon_social' => $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado',
        'representante' => $certificado->dictamen->inspeccione->solicitud->empresa->representante ?? 'No encontrado',
        'domicilio_fiscal' => $certificado->dictamen->inspeccione->solicitud->empresa->domicilio_fiscal ?? 'No encontrado',
        'cp' => $certificado->dictamen->inspeccione->solicitud->empresa->cp ?? ' ',
        'rfc' => $certificado->dictamen->inspeccione->solicitud->empresa->rfc ?? 'No encontrado',
        'direccion_completa' => $certificado->dictamen->inspeccione->solicitud->instalaciones->direccion_completa ?? 'No encontrado',
        'nombre_firmante' => $certificado->user->name ?? 'No encontrado',
        'puesto_firmante' => $certificado->user->puesto ?? 'No encontrado',
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,
        //lote
        'estado' => $certificado->loteGranel->estados->nombre ?? 'No encontrado',
        'categoria' => $certificado->dictamen->inspeccione->solicitud->lote_granel->categoria->categoria ?? 'No encontrado',
        'clase' => $certificado->dictamen->inspeccione->solicitud->lote_granel->clase->clase ?? 'No encontrado',
        'nombre_lote' => $certificado->dictamen->inspeccione->solicitud->lote_granel->nombre_lote?? 'No encontrado',
        'n_analisis' => $certificado->dictamen->inspeccione->solicitud->lote_granel->folio_fq ?? 'No encontrado',
        'volumen' => $volumen,
        'cont_alc' => $certificado->dictamen->inspeccione->solicitud->lote_granel->cont_alc?? 'No encontrado',
        'tipo_maguey' => $certificado->dictamen->inspeccione->solicitud->lote_granel ?? 'No encontrado',
        'edad' => $certificado->dictamen->inspeccione->solicitud->lote_granel->edad ?? '-----',
        'ingredientes' => $certificado->dictamen->inspeccione->solicitud->lote_granel->ingredientes ?? '-----',
        'num_dictamen' => $certificado->dictamen->num_dictamen ?? 'No encontrado',
    ];

    // Generar y mostrar el PDF
    //return Pdf::loadView('pdfs.certificado_granel_ed7', $pdfData)->stream("Certificado NOM de Mezcal a Granel NOM-070-SCFI-2016F7.1-01-07.pdf");
    // Seleccionar la vista según si lleva marca o no
    $documento = $conMarca
        ? 'pdfs.certificado_granel_ed7'
        : 'pdfs.certificado_granel_ed7_sin_marca'; // asegúrate de que el archivo se llame así

    return Pdf::loadView($documento, $pdfData)
        ->stream("Certificado NOM de Mezcal a Granel NOM-070-SCFI-2016F7.1-01-07.pdf");
}




///SUBIR CERTIFICADO FIRMADO
public function subirCertificado(Request $request)
{
    $request->validate([
        'id_certificado' => 'required|exists:certificados_granel,id_certificado',
        'documento' => 'required|mimes:pdf|max:3072',
    ]);

    $certificado = CertificadosGranel::findOrFail($request->id_certificado);

    // Limpiar num_certificado para evitar crear carpetas por error
    $nombreCertificado = preg_replace('/[^A-Za-z0-9_\-]/', '_', $certificado->num_certificado ?? 'No encontrado');
    // Generar nombre de archivo con num_certificado + cadena aleatoria
    $nombreArchivo = $nombreCertificado.'_'. uniqid() .'.pdf'; //uniqid() para asegurar nombre único


    $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $certificado->dictamen->inspeccione->solicitud->empresa->id_empresa)->first();
    $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
        return !empty($numero);
    });
    // Ruta de carpeta física donde se guardará
    $rutaCarpeta = "public/uploads/{$numeroCliente}/certificados_granel";

    // Guardar nuevo archivo
    $upload = Storage::putFileAs($rutaCarpeta, $request->file('documento'), $nombreArchivo);
    if (!$upload) {
        return response()->json(['message' => 'Error al subir el archivo.'], 500);
    }

     // Eliminar archivo y registro anterior si existe
    $caracteristicas = json_decode($certificado->dictamen?->inspeccione?->solicitud?->caracteristicas, true);
        $idLote = $caracteristicas['id_lote_granel'] ?? null;

    // Validar que el id_lote_granel exista
    if (is_null($idLote)) {
        return response()->json([
            'message' => 'No se encontró el ID de lote relacionado. No se puede continuar.'
        ], 422);
    }

    // Buscar si ya existe un registro para ese lote y tipo de documento
    $documentacion_url = Documentacion_url::where('id_relacion', $idLote)
        ->where('id_documento', 59)
        ->where('id_doc', $certificado->id_certificado)//id del certificado
        ->first();

    if ($documentacion_url) {
        $ArchivoAnterior = "public/uploads/{$numeroCliente}/certificados_granel/{$documentacion_url->url}";
        if (Storage::exists($ArchivoAnterior)) {
            Storage::delete($ArchivoAnterior);
        }
    }

    // Crear o actualizar registro
    Documentacion_url::updateOrCreate(
        [
            'id_relacion' => $idLote,
            'id_documento' => 59,
            'id_doc' => $certificado->id_certificado,//id del certificado
        ],
        [
            'nombre_documento' => "Certificado NOM a granel",
            'url' => "{$nombreArchivo}",
            'id_empresa' => $certificado->dictamen?->inspeccione?->solicitud?->id_empresa,
        ]
    );

    return response()->json(['message' => 'Documento actualizado correctamente.']);
}

///OBTENER CERTIFICADO FIRMADO
public function CertificadoFirmado($id)
{
    $certificado = CertificadosGranel::findOrFail($id);

    // Obtener id_lote_granel desde las características
    $caracteristicas = json_decode($certificado->dictamen?->inspeccione?->solicitud?->caracteristicas, true);
    $idLote = $caracteristicas['id_lote_granel'] ?? null;

    /*if (is_null($idLote)) {
        return response()->json([
            'documento_url' => null,
            'nombre_archivo' => null,
            'message' => 'No se encontró el ID de lote relacionado.',
        ], 404);
    }*/

    // Buscar documento asociado al lote
    $documentacion = Documentacion_url::where('id_relacion', $idLote)
        ->where('id_documento', 59)
        ->where('id_doc', $certificado->id_certificado)
        ->first();


    $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $certificado->dictamen->inspeccione->solicitud->empresa->id_empresa)->first();
      $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
        return !empty($numero);
    });

    if ($documentacion) {
        $rutaArchivo = "{$numeroCliente}/certificados_granel/{$documentacion->url}";

        if (Storage::exists("public/uploads/{$rutaArchivo}")) {
            return response()->json([
                //'documento_url' => Storage::url($rutaArchivo), // genera URL pública
                'documento_url' => asset("files/".$rutaArchivo),
                'nombre_archivo' => basename($documentacion->url),
            ]);
        }else {
            return response()->json([
                'documento_url' => null,
                'nombre_archivo' => null,
            ], 404);
        }
    }

    return response()->json([
        'documento_url' => null,
        'nombre_archivo' => null,
        //'message' => 'Documento no encontrado.',
    ]);
}
///BORRAR CERTIFICADO FIRMADO
public function borrarCertificadofirmado($id)
{
    $certificado = CertificadosGranel::findOrFail($id);

    // Obtener id_lote_granel desde las características
    $caracteristicas = json_decode($certificado->dictamen?->inspeccione?->solicitud?->caracteristicas, true);
    $idLote = $caracteristicas['id_lote_granel'] ?? null;

    $documentacion = Documentacion_url::where('id_relacion', $idLote)
        ->where('id_documento', 59)
        ->where('id_doc', $certificado->id_certificado)
        ->first();

    if (!$documentacion) {
        return response()->json(['message' => 'Documento no encontrado.'], 404);
    }

    $empresa = empresa::with("empresaNumClientes")
        ->where("id_empresa", $certificado->dictamen->inspeccione->solicitud->empresa->id_empresa)
        ->first();

    $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
        return !empty($numero);
    });

    $rutaArchivo = "public/uploads/{$numeroCliente}/certificados_granel/{$documentacion->url}";

    // Eliminar archivo físico
    if (Storage::exists($rutaArchivo)) {
        Storage::delete($rutaArchivo);
    }

    // Eliminar registro en la base de datos
    $documentacion->delete();

    return response()->json(['message' => 'Documento eliminado correctamente.']);
}





}//end-classController
