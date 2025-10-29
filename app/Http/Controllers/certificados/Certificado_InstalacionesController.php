<?php

namespace App\Http\Controllers\certificados;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificados;
use App\Models\Dictamen_instalaciones;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Revisor;
use App\Models\Documentacion_url;
use App\Models\instalaciones;
use App\Models\empresa;
use App\Models\maquiladores_model;
//Notificacion
use App\Notifications\GeneralNotification;
//Enviar Correo
use App\Mail\CorreoCertificado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DirectorioInstalacion;


class Certificado_InstalacionesController extends Controller
{

    public function UserManagement()
    {
        $certificados = Certificados::where('estatus', '!=', 1)
            ->orderBy('id_certificado', 'desc')
            ->get();
        $dictamenes = Dictamen_instalaciones::where('estatus', '!=', 1)
            ->whereDoesntHave('certificado') // Solo los dictámenes sin certificado
            //->where('fecha_emision','>','2024-12-31')
            ->orderBy('id_dictamen', 'desc')
            ->get();
        $users = User::where('tipo', 1)
            ->where('id', '!=', 1)
            ->where('estatus', '!=', 'Inactivo')
            ->get();
        $revisores = Revisor::all();

        $empresa = empresa::where('tipo', 2)->get();

        return view('certificados.find_certificados_instalaciones', compact('certificados','dictamenes', 'users', 'revisores', 'empresa'));
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


    $query = Certificados::query()
        ->leftJoin('dictamenes_instalaciones', 'dictamenes_instalaciones.id_dictamen', '=', 'certificados.id_dictamen')
        ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_instalaciones.id_inspeccion')
        ->leftJoin('solicitudes', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
        ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa')
        ->leftJoin('instalaciones', 'instalaciones.id_instalacion', '=', 'dictamenes_instalaciones.id_instalacion')
        ->select('certificados.*', 'empresa.razon_social');

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


    // Mapeo de nombres a valores numéricos de tipo certificado
    $tiposCertificados = [
        'productor' => 1,
        'envasador' => 2,
        'comercializador' => 3,
        'almacén y bodega' => 4,
        'área de maduración' => 5,
    ];

    // Búsqueda Global
    if (!empty($search)) {
        // Convertir a minúsculas sin tildes para comparar
        $searchNormalized = mb_strtolower(trim($search), 'UTF-8');
        // También elimina tildes para mejor comparación
        $searchNormalized = strtr($searchNormalized, [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u'
        ]);
        // Buscar coincidencia de nombre
        $tipoCertificadoValor = null;
        foreach ($tiposCertificados as $nombre => $valor) {
            $nombreNormalizado = strtr(mb_strtolower($nombre, 'UTF-8'), [
                'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u'
            ]);
            if (strpos($searchNormalized, $nombreNormalizado) !== false) {
                $tipoCertificadoValor = $valor;
                break;
            }
        }

        $query->where(function ($q) use ($search, $tipoCertificadoValor){
            $q->where('certificados.num_certificado', 'LIKE', "%{$search}%")
            ->orWhere('dictamenes_instalaciones.num_dictamen', 'LIKE', "%{$search}%")
            ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
            ->orWhere('empresa.razon_social', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(certificados.fecha_emision, '%d de %M del %Y') LIKE ?", ["%$search%"])
            ->orWhere('instalaciones.direccion_completa', 'LIKE', "%{$search}%");

            // Si se encontró un valor válido para el tipo_dictamen, agregarlo
            if (!is_null($tipoCertificadoValor)) {
                $q->orWhere('dictamenes_instalaciones.tipo_dictamen', $tipoCertificadoValor);
            }

        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }


    // Ordenamiento especial para num_certificado con formato 'CIDAM C-INS25-###'
    if ($orderColumn === 'num_certificado') {
        $query->orderByRaw("
            CASE
                WHEN num_certificado LIKE 'CIDAM C-INS25-%' THEN 0
                ELSE 1
            END ASC,
            CAST(
                SUBSTRING_INDEX(
                    SUBSTRING(num_certificado, LOCATE('CIDAM C-INS25-', num_certificado) + 14),
                    '-', 1
                ) AS UNSIGNED
            ) $orderDirection
        ");
    } else{
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
            $nestedData['tipo_dictamen'] = $certificado->dictamen->tipo_dictamen ?? 'No encontrado';
            $nestedData['direccion_completa'] = $certificado->dictamen->inspeccione->solicitud->instalacion->direccion_completa ?? 'No encontrado';
            $nestedData['estatus'] = $certificado->estatus ?? 'No encontrado';
            $id_sustituye = json_decode($certificado->observaciones, true)['id_sustituye'] ?? null;
            $nestedData['sustituye'] = $id_sustituye ? Certificados::find($id_sustituye)->num_certificado ?? 'No encontrado' : null;
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
            //Certificado Firmado
            switch ($certificado?->dictamen?->tipo_dictamen) {// Determinar el tipo de dictamen
                case 1:
                    $id_documento = 127; // Productor
                    break;
                case 2:
                    $id_documento = 128; // Envasador
                    break;
                case 3:
                    $id_documento = 129; // Comercializador
                    break;
                default:
                    $id_documento = null;
            }
            $documentacion = Documentacion_url::where('id_relacion', $certificado?->dictamen?->id_instalacion)
                ->where('id_documento', $id_documento)->where('id_doc', $certificado->id_certificado) ->first();
            $nestedData['pdf_firmado'] = $documentacion?->url
                ? asset("files/{$numero_cliente}/certificados_instalaciones/{$documentacion->url}") : null;


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
    return Excel::download(new DirectorioInstalacion($filtros), '.xlsx');
}



    ///FUNCION REGISTRAR
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string|max:25',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'maestro_mezcalero' => 'nullable|string|max:60',
            //'num_autorizacion' => 'nullable|integer',
            'id_firmante' => 'required|integer',
        ]);

        //Busca el dictamen y carga la relacion con modelo dictamen->solicitud
        $dictamen = Dictamen_instalaciones::find($validatedData['id_dictamen']);
        $id_instalacion = $dictamen->inspeccione->solicitud->instalaciones->id_instalacion ?? null;
        if (!$id_instalacion) {
            return response()->json(['error' => 'No se encontró la instalacion asociada a la solicitud'], 404);
        }

        //$certificado =
        Certificados::create([
            'id_dictamen' => $validatedData['id_dictamen'],
            'num_certificado' => $validatedData['num_certificado'],
            'fecha_emision' => $validatedData['fecha_emision'],
            'fecha_vigencia' => $validatedData['fecha_vigencia'],
            'maestro_mezcalero' => $validatedData['maestro_mezcalero'] ?: null,
            //'num_autorizacion' => $validatedData['num_autorizacion'] ?: null,
            'id_firmante' => $validatedData['id_firmante']
        ]);

        $instalacion = instalaciones::find($id_instalacion);
        $instalacion->folio = $validatedData['num_certificado'];
        $instalacion->fecha_emision = $validatedData['fecha_emision'];
        $instalacion->fecha_vigencia = $validatedData['fecha_vigencia'];
        $instalacion->update();

        /*
        $id_instalacion = $certificado->dictamen->inspeccione->solicitud->id_instalacion;
        $instalaciones = instalaciones::find($id_instalacion);
        $instalaciones->folio = $certificado->num_certificado;
        $instalaciones->fecha_emision = $certificado->fecha_emision;
        $instalaciones->fecha_vigencia = $certificado->fecha_vigencia;
        $instalaciones->save();

            // Obtener información de la empresa
            $numeroCliente = $certificado->dictamen->instalaciones->empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                return !empty($numero);
            });

            // Manejo de archivos si se suben
                $directory = 'uploads/' . $numeroCliente;
                $path = storage_path('app/public/' . $directory);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                    $nombreDocumento =  'Certificado '.str_replace('/', '-', $certificado->num_certificado);

                    $filename = $nombreDocumento .  '.pdf' ;
                    $filePath = storage_path('app/public/' . $directory . '/' . $filename);
                    if($certificado->dictamen->tipo_dictamen==1){
                    $id_documento =127;
                    $this->pdf_certificado_productor($certificado->id_certificado,true,$filePath);
                    }
                    if($certificado->dictamen->tipo_dictamen==2){
                    $id_documento =128;
                    $this->pdf_certificado_envasador($certificado->id_certificado,true,$filePath);
                    }
                    if($certificado->dictamen->tipo_dictamen==3){
                    $id_documento =128;
                    $this->pdf_certificado_comercializador($certificado->id_certificado,true,$filePath);
                    }

                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion =  $certificado->dictamen->id_instalacion;
                    $documentacion_url->id_documento = $id_documento ?? null;
                    $documentacion_url->nombre_documento = $nombreDocumento;
                    $documentacion_url->url = $filename;
                    $documentacion_url->id_empresa =  $certificado->dictamen->instalaciones->id_empresa;
                    $documentacion_url->save();

        */
        return response()->json(['message' => 'Registrado correctamente.']);
    }



    ///FUNCION ELIMINAR
    public function destroy($id_certificado)
    {
        try {
            $certificado = Certificados::findOrFail($id_certificado);
            // Eliminar todos los revisores asociados al certificado en la tabla certificados_revision
            Revisor::where('id_certificado', $id_certificado)->delete();
            // Luego, eliminar el certificado
            $certificado->delete();

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
        try {
            //$certificado = Certificados::find($id);
            $certificado = Certificados::with('dictamen.inspeccione.solicitud')->findOrFail($id);


            if ($certificado) {
                //return response()->json($certificado);
                return response()->json([
                    'id_certificado' => $certificado->id_certificado,
                    'id_dictamen' => $certificado->id_dictamen,
                    'tipo_dictamen' => $certificado->dictamen->tipo_dictamen ?? null,
                    'num_certificado' => $certificado->num_certificado,
                    'fecha_emision' => $certificado->fecha_emision,
                    'fecha_vigencia' => $certificado->fecha_vigencia,
                    'id_firmante' => $certificado->id_firmante,
                    'maestro_mezcalero' => $certificado->maestro_mezcalero,
                    //'num_autorizacion' => $certificado->num_autorizacion,

                    'folio' => $certificado->dictamen->inspeccione->solicitud->folio ?? '',
                    'num_dictamen' => $certificado->dictamen->num_dictamen ?? ''
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error al obtener', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al obtener los datos.'], 500);
        }
    }

    ///FUNCION ACTUALIZAR
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string|max:25',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'nullable|date',
            'maestro_mezcalero' => 'nullable|string|max:60',
            //'num_autorizacion' => 'nullable|integer',
            'id_firmante' => 'required|integer',
        ]);

        try {
            $certificado = Certificados::findOrFail($id);

        //Busca el dictamen y carga la relacion con modelo dictamen->solicitud
        $dictamen = Dictamen_instalaciones::find($validated['id_dictamen']);
        $id_instalacion = $dictamen->inspeccione->solicitud->instalaciones->id_instalacion ?? null;
        if (!$id_instalacion) {
            return response()->json(['error' => 'No se encontró la instalacion asociada a la solicitud'], 404);
        }

            /*
            // Obtener información de la empresa
            $numeroCliente = $certificado->dictamen->instalaciones->empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                    return !empty($numero);
                });

            $directory = 'uploads/' . $numeroCliente;
                $path = storage_path('app/public/' . $directory);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

            $nombreDocumento =  'Certificado '.str_replace('/', '-', $certificado->num_certificado);
            $certificado_actual = Documentacion_url::where('nombre_documento', $nombreDocumento)->first();
            // dd($certificado_actual);

            if ($certificado_actual) {
                // Elimina el archivo físico si existe

                if (Storage::exists('public/' . $directory . '/' . $certificado_actual->url)) {
                    Storage::delete('public/' . $directory . '/' . $certificado_actual->url);
                }

                // Elimina el registro de la base de datos
                $certificado_actual->delete();
            }
            */

            $certificado->id_dictamen = $validated['id_dictamen'];
            $certificado->num_certificado = $validated['num_certificado'];
            $certificado->fecha_emision = $validated['fecha_emision'];
            $certificado->fecha_vigencia = $validated['fecha_vigencia'];
            $certificado->maestro_mezcalero = $validated['maestro_mezcalero'] ?: null;
            //$certificado->num_autorizacion = $validated['num_autorizacion'] ?: null;
            $certificado->id_firmante = $validated['id_firmante'];
            $certificado->save();


            $instalacion = instalaciones::find($id_instalacion);
            $instalacion->folio = $validated['num_certificado'];
            $instalacion->fecha_emision = $validated['fecha_emision'];
            $instalacion->fecha_vigencia = $validated['fecha_vigencia'];
            $instalacion->update();


            /*
            $id_instalacion = $certificado->dictamen->id_instalacion;
            $instalaciones = instalaciones::find($id_instalacion);
            $instalaciones->folio = $certificado->num_certificado;
            $instalaciones->fecha_emision = $certificado->fecha_emision;
            $instalaciones->fecha_vigencia = $certificado->fecha_vigencia;
            $instalaciones->save();


                $nombreDocumento =  'Certificado '.str_replace('/', '-', $certificado->num_certificado);
                $filename = $nombreDocumento.'.pdf' ;
                $filePath = storage_path('app/public/' . $directory . '/' . $filename);
                if($certificado->dictamen->tipo_dictamen==1){
                $id_documento =127;
                $this->pdf_certificado_productor($certificado->id_certificado,true,$filePath);
                }
                if($certificado->dictamen->tipo_dictamen==2){
                $id_documento =128;
                $this->pdf_certificado_envasador($certificado->id_certificado,true,$filePath);
                }
                if($certificado->dictamen->tipo_dictamen==3){
                $id_documento =128;
                $this->pdf_certificado_comercializador($certificado->id_certificado,true,$filePath);
                }


                $documentacion_url = new Documentacion_url();
                $documentacion_url->id_relacion =  $certificado->dictamen->id_instalacion;
                $documentacion_url->id_documento = $id_documento ?? null;
                $documentacion_url->nombre_documento = $nombreDocumento;
                $documentacion_url->url = $filename;
                $documentacion_url->id_empresa =  $certificado->dictamen->instalaciones->id_empresa;
                $documentacion_url->save();
            */

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
                    'id_certificado' => 'required|exists:certificados,id_certificado',
                    'id_dictamen' => 'required|integer',
                    'num_certificado' => 'required|string|min:8',
                    'fecha_emision' => 'required|date',
                    'fecha_vigencia' => 'required|date',
                    'maestro_mezcalero' => 'nullable|string|max:60',
                    //'num_autorizacion' => 'nullable|integer',
                    'id_firmante' => 'required|integer',
                ]);
            }

            $reexpedir = Certificados::findOrFail($request->id_certificado);

            if ($request->accion_reexpedir == '1') {
                $reexpedir->estatus = 1;
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones; //Actualiza solo 'observaciones'
                $reexpedir->observaciones = json_encode($observacionesActuales);
                $reexpedir->save();
                return response()->json(['message' => 'Cancelado correctamente.']);
                
            } else if ($request->accion_reexpedir == '2') {
                $reexpedir->estatus = 1;
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
                $reexpedir->observaciones = json_encode($observacionesActuales);
                $reexpedir->save();

                // Crear un nuevo registro de reexpedición
                $new = new Certificados();
                $new->id_dictamen = $request->id_dictamen;
                $new->num_certificado = $request->num_certificado;
                $new->fecha_emision = $request->fecha_emision;
                $new->fecha_vigencia = $request->fecha_vigencia;
                $new->id_firmante = $request->id_firmante;
                $new->estatus = 2;
                $new->observaciones = json_encode(['id_sustituye' => $request->id_certificado]);
                $new->maestro_mezcalero = $request->maestro_mezcalero ?: null;
                //$new->num_autorizacion = $request->num_autorizacion ?: null;
                $new->save();

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




// FUNCION LLENAR SELECT REVISORES
public function obtenerRevisores(Request $request)
{
    $tipo = $request->get('tipo');
    $revisores = User::where('tipo', $tipo)
        ->where('id', '!=', 1)
        ->where('estatus', '!=', 'Inactivo')
        ->get(['id', 'name']);

    return response()->json($revisores);
}

///OBTENER REVISION ASIGNADA
public function obtenerRevision($id_certificado)
{
    // Obtener la primera revisión (tipo_revision = 1)
    $revision = Revisor::where('id_certificado', $id_certificado)
        ->where('tipo_certificado', 1)
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
    // Buscar el revisor con tipo_certificado 1 (puedes limitar más si quieres)
    $revisor = Revisor::where('id_certificado', $id_certificado)
        ->where('tipo_certificado', 1)
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
        'id_certificado' => 'required|integer|exists:certificados,id_certificado',
        'url' => 'nullable|file|mimes:pdf|max:3072',
        'nombre_documento' => 'nullable|string|max:255',

        'certificados' => 'nullable|array',
        'certificados.*' => 'integer|exists:certificados,id_certificado',
    ]);

    $certificado = Certificados::find($validated['id_certificado']);
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
            'tipo_certificado' => 1,
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
                'tipo_certificado' => 'Certificado de instalaciones',
                'observaciones' => $revisor->observaciones,
            ]));
        }


        // Siempre sincronizar si existen AMBOS tipos (1 y 2) para el certificado principal
        $revisiones = Revisor::where('id_certificado', $certificado->id_certificado)
            ->where('tipo_certificado', 1)
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
                $certRelacionado = Certificados::find($idRelacionado);
                if (!$certRelacionado) continue;

                foreach ([1, 2] as $tipoRev) {
                    $revis = Revisor::where('id_certificado', $idRelacionado)
                        ->where('tipo_certificado', 1)
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
                        $revis->tipo_certificado = 1;
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






    ///PDF CERTIFICADOS
    public function pdf_certificado_productor($id_certificado, $conMarca = true, $rutaGuardado = null)
    {
        $datos = Certificados::with([
            'dictamen.inspeccione.solicitud.empresa',
            'dictamen.instalaciones',
            'dictamen.inspeccione.inspector',
            'firmante'
        ])->findOrFail($id_certificado);

        $empresa = $datos->dictamen->instalaciones->empresa ?? null;
        $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
            ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
        $id_sustituye = json_decode($datos->observaciones, true)['id_sustituye'] ?? null; //obtiene el valor del JSON/sino existe es null
        $nombre_id_sustituye = $id_sustituye ? Certificados::find($id_sustituye)->num_certificado ?? 'No encontrado' : '';

        $watermarkText = $datos->estatus == 1;



        // Preparar los datos para el PDF
        $pdfData = [
            'datos' => $datos,
            'num_certificado' => $datos->num_certificado ?? 'No encontrado',
            'num_dictamen' => $datos->dictamen->num_dictamen ?? 'No encontrado',
            'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),
            'domicilio_fiscal' => $empresa->domicilio_fiscal ?? 'No encontrado',
            'rfc' => $empresa->rfc ?? 'No encontrado',
            'telefono' => $empresa->telefono ?? 'No encontrado',
            'correo' => $empresa->correo ?? 'No encontrado',
            'watermarkText' => $watermarkText,
            'id_sustituye' => $nombre_id_sustituye,
            ///
            'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa ?? 'No encontrado',
            'razon_social' => $empresa->razon_social ?? 'No encontrado',
            'cp' => $empresa->cp ?? '',
            'maestro_mezcalero' => is_null($datos->maestro_mezcalero)
                ? '---------------------------------------------------------------------------------------------------------------------'
                : (trim($datos->maestro_mezcalero) === ''
                ? '---------------------------------------------------------------------------------------------------------------------'
                : $datos->maestro_mezcalero),
            'num_autorizacion' => $empresa->registro_productor ?? 'N/A',
            'numero_cliente' => $numero_cliente,
            'representante_legal' => $empresa->representante ?? 'No encontrado',
            'nombre_firmante' => $datos->firmante->name ?? 'No encontrado',
            'puesto_firmante' => $datos->firmante->puesto ?? 'No encontrado',
            'firma_firmante' => $datos->firmante->firma ?? 'No encontrado',
            'categorias' => $datos->dictamen?->inspeccione?->solicitud?->categorias_mezcal()?->pluck('categoria')->implode(', ') ?? 'No encontrado',
            'clases' => $datos->dictamen?->inspeccione?->solicitud?->clases_agave()?->pluck('clase')->implode(', ') ?? 'No encontrado',
        ];

        /*if ($guardar && $rutaGuardado) {
            $pdf = Pdf::loadView('pdfs.certificado_productor_mezcal', $pdfData);
            $pdf->save($rutaGuardado);
            return $rutaGuardado;
        }*/

      $edicion = '';

      if ($datos->fecha_emision >= '2025-04-01') {
          $edicion = $conMarca ? 'pdfs.certificado_productor_ed6' : 'pdfs.certificado_productor_ed6_sin_marca';
      } else {
          $edicion = $conMarca ? 'pdfs.certificado_productor_ed5' : 'pdfs.certificado_productor_ed5_sin_marca';
      }

      return Pdf::loadView($edicion, $pdfData)
          ->stream('Certificado como Productor de Mezcal NOM-070-SCFI-2016 F7.1-01-35.pdf');


    }


    public function pdf_certificado_envasador($id_certificado, $conMarca = true, $rutaGuardado = null)
    {
        $datos = Certificados::with([
            'dictamen.inspeccione.solicitud.instalaciones.empresa',
            'dictamen.inspeccione.solicitud.empresa',
            'dictamen.instalaciones',
            'dictamen.inspeccione.inspector',
            'firmante'
        ])->findOrFail($id_certificado);


        $empresa = $datos->dictamen->instalaciones->empresa ?? null;
        $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
            ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
        $id_sustituye = json_decode($datos->observaciones, true)['id_sustituye'] ?? null; //obtiene el valor del JSON/sino existe es null
        $nombre_id_sustituye = $id_sustituye ? Certificados::find($id_sustituye)->num_certificado ?? 'No encontrado' : '';

        $watermarkText = $datos->estatus == 1;

        // Preparar los datos para el PDF
        $pdfData = [
            'datos' => $datos,
            'num_certificado' => $datos->num_certificado ?? 'No encontrado',
            'num_autorizacion' => $datos->num_autorizacion ?? 'No encontrado',
            'num_dictamen' => $datos->dictamen->num_dictamen ?? 'No encontrado',
            'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),
            'domicilio_fiscal' => $empresa->domicilio_fiscal ?? 'No encontrado',
            'rfc' => $empresa->rfc ?? 'No encontrado',
            'telefono' => $empresa->telefono ?? 'No encontrado',
            'correo' => $empresa->correo ?? 'No encontrado',
            'watermarkText' => $watermarkText,
            'id_sustituye' => $nombre_id_sustituye,
            //
            'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa ?? 'No encontrado',
            'razon_social' => $empresa->razon_social ?? 'No encontrado',
            'cp' => $empresa->cp ?? ' ',
            'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------',
            'numero_cliente' => $numero_cliente,
            'representante_legal' => $empresa->representante ?? 'No encontrado',
            'nombre_firmante' => $datos->firmante->name ?? 'No encontrado',
            'puesto_firmante' => $datos->firmante->puesto ?? 'No encontrado',
            'firma_firmante' => $datos->firmante->firma ?? 'No encontrado',
            'categorias' => $datos->dictamen?->inspeccione?->solicitud?->categorias_mezcal()?->pluck('categoria')->implode(', ') ?? 'No encontrado',
            'clases' => $datos->dictamen?->inspeccione?->solicitud?->clases_agave()?->pluck('clase')->implode(', ') ?? 'No encontrado',
        ];


        /*if ($guardar && $rutaGuardado) {
            $pdf = Pdf::loadView('pdfs.certificado_envasador', $pdfData);
            $pdf->save($rutaGuardado);
            return $rutaGuardado;
        }*/
         if ($datos->fecha_emision >= "2025-04-01") {
              $edicion = $conMarca ? 'pdfs.certificado_envasador_ed5' : 'pdfs.certificado_envasador_ed5_sin_marca';
        } else {
              $edicion = $conMarca ? 'pdfs.certificado_envasador_ed4' : 'pdfs.certificado_envasador_ed4_sin_marca';
        }
        return Pdf::loadView($edicion, $pdfData)
            ->stream('Certificado como Envasador de Mezcal NOM-070-SCFI-2016 F7.1-01-36.pdf');
}


    public function pdf_certificado_comercializador($id_certificado, $conMarca = true, $rutaGuardado = null)
    {
        $datos = Certificados::with([
            'dictamen.inspeccione.solicitud.empresa',
            'dictamen.instalaciones',
            'dictamen.inspeccione.inspector',
            'firmante'
        ])->findOrFail($id_certificado);

        $empresa = $datos->dictamen->instalaciones->empresa ?? null;
        $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
            ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
        $id_sustituye = json_decode($datos->observaciones, true)['id_sustituye'] ?? null; //obtiene el valor del JSON/sino existe es null
        $nombre_id_sustituye = $id_sustituye ? Certificados::find($id_sustituye)->num_certificado ?? 'No encontrado' : '';

        $watermarkText = $datos->estatus == 1;

        // Preparar los datos para el PDF
        $pdfData = [
            'datos' => $datos,
            'num_certificado' => $datos->num_certificado ?? 'No encontrado',
            'num_autorizacion' => $datos->num_autorizacion ?? 'No encontrado',
            'num_dictamen' => $datos->dictamen->num_dictamen ?? 'No encontrado',
            'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),
            'domicilio_fiscal' => $empresa->domicilio_fiscal ?? 'No encontrado',
            'rfc' => $empresa->rfc ?? 'No encontrado',
            'telefono' => $empresa->telefono ?? 'No encontrado',
            'correo' => $empresa->correo ?? 'No encontrado',
            'watermarkText' => $watermarkText,
            'id_sustituye' => $nombre_id_sustituye,
            //
            'razon_social' => $empresa->razon_social ?? 'No encontrado',
            'cp' => $empresa->cp ?? '',
            'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------',
            'numero_cliente' => $numero_cliente,
            'representante_legal' => $empresa->representante ?? 'No encontrado',
            'nombre_firmante' => $datos->firmante->name ?? 'No encontrado',
            'puesto_firmante' => $datos->firmante->puesto ?? 'No encontrado',
            'firma_firmante' => $datos->firmante->firma ?? 'No encontrado',
            'categorias' => $datos->dictamen?->inspeccione?->solicitud?->categorias_mezcal()?->pluck('categoria')->implode(', ') ?? 'No encontrado',
            'clases' => $datos->dictamen?->inspeccione?->solicitud?->clases_agave()?->pluck('clase')->implode(', ') ?? 'No encontrado',
            // Nuevos campos
            'marcas' => $datos->dictamen?->inspeccione?->solicitud?->marcas()?->pluck('marca')->implode(', ') ?? 'No encontrado',
            'domicilio_unidad' => $datos->dictamen->instalaciones->direccion_completa ?? 'No encontrado',
            'convenio_corresponsabilidad' => $empresa->convenio_empresas ?? 'NA',
        ];

        /*if ($guardar && $rutaGuardado) {
            $pdf = Pdf::loadView('pdfs.certificado_comercializador', $pdfData);
            $pdf->save($rutaGuardado);
            return $rutaGuardado;
        }*/

    if ($datos->fecha_emision >= "2025-04-01") {
        $edicion = $conMarca ? 'pdfs.certificado_comercializador_ed6' : 'pdfs.certificado_comercializador_ed6_sin_marca';
    } else {
        $edicion = $conMarca ? 'pdfs.certificado_comercializador_ed5' : 'pdfs.certificado_comercializador_ed5_sin_marca';
    }

    return Pdf::loadView($edicion, $pdfData)
        ->stream('Certificado como Comercializador de Mezcal NOM-070-SCFI-2016 F7.1-01-37.pdf');
    }





    ///SUBIR CERTIFICADO FIRMADO
    public function subirCertificado(Request $request)
    {
        $request->validate([
            'id_certificado' => 'required|exists:certificados,id_certificado',
            'documento' => 'required|mimes:pdf|max:3072',
        ]);

        $certificado = Certificados::findOrFail($request->id_certificado);

        // Limpiar num_certificado para evitar crear carpetas por error
        $nombreCertificado = preg_replace('/[^A-Za-z0-9_\-]/', '_', $certificado->num_certificado ?? 'No encontrado');
        // Generar nombre de archivo con num_certificado + cadena aleatoria
        $nombreArchivo = $nombreCertificado.'_'. uniqid() .'.pdf'; //uniqid() para asegurar nombre único


        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $certificado->dictamen->instalaciones->empresa->id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });
        // Ruta de carpeta física donde se guardará
        $rutaCarpeta = "public/uploads/{$numeroCliente}/certificados_instalaciones";

        // Guardar nuevo archivo
        $upload = Storage::putFileAs($rutaCarpeta, $request->file('documento'), $nombreArchivo);
        if (!$upload) {
            return response()->json(['message' => 'Error al subir el archivo.'], 500);
        }

        // Eliminar archivo y registro anterior si existe
        $id_instalacion = $certificado->dictamen?->id_instalacion;
        // Validar que el id_instalacion exista
        if (is_null($id_instalacion)) {
            return response()->json([
                'message' => 'No se encontró el ID de instalacion relacionado. No se puede continuar.'
            ], 422);
        }

        // Determinar id_documento y nombre_documento según tipo_dictamen
        $tipoDictamen = $certificado->dictamen->tipo_dictamen;
        switch ($tipoDictamen) {
            case 1:
                $id_documento = 127;
                $nombre_documento = "Certificado como productor";
                break;
            case 2:
                $id_documento = 128;
                $nombre_documento = "Certificado como envasador";
                break;
            case 3:
                $id_documento = 129;
                $nombre_documento = "Certificado como comercializador";
                break;
            default:
                return response()->json(['message' => 'Tipo de instalacion desconocido.'], 422);
        }

        // Buscar si ya existe un registro para esa isntalacion y tipo de documento
        $documentacion = Documentacion_url::where('id_relacion', $id_instalacion)
            ->where('id_documento', $id_documento)
            ->where('id_doc', $certificado->id_certificado)//id del certificado
            ->first();

        if ($documentacion) {
            $ArchivoAnterior = "public/uploads/{$numeroCliente}/certificados_instalaciones/{$documentacion->url}";
            if (Storage::exists($ArchivoAnterior)) {
                Storage::delete($ArchivoAnterior);
            }
        }

        // Crear o actualizar registro
        Documentacion_url::updateOrCreate(
            [
                'id_relacion' => $id_instalacion,
                'id_documento' => $id_documento,
                'id_doc' => $certificado->id_certificado,//id del certificado
            ],
            [
                'nombre_documento' => $nombre_documento,
                'url' => "{$nombreArchivo}",
                'id_empresa' => $certificado->dictamen->instalaciones->empresa->id_empresa,
            ]
        );

        return response()->json(['message' => 'Documento actualizado correctamente.']);
    }


    ///OBTENER CERTIFICADO FIRMADO
    public function CertificadoFirmado($id)
    {
        $certificado = Certificados::findOrFail($id);

        // Obtener la instalacion
        $id_instalacion = $certificado->dictamen?->id_instalacion;

        if (is_null($id_instalacion)) {
            return response()->json([
                'documento_url' => null,
                'nombre_archivo' => null,
                'message' => 'No se encontró el ID de instalacion relacionado.',
            ], 404);
        }

        // Determinar tipo_dictamen y su correspondiente id_documento
        $tipoDictamen = $certificado->dictamen->tipo_dictamen;
        switch ($tipoDictamen) {
            case 1:
                $id_documento = 127; // Productor
                break;
            case 2:
                $id_documento = 128; // Envasador
                break;
            case 3:
                $id_documento = 129; // Comercializador
                break;
            default:
                return response()->json([
                    'documento_url' => null,
                    'nombre_archivo' => null,
                    'message' => 'Tipo de instalacion desconocido.',
                ], 422);
        }

        // Buscar documento asociado a instalacion
        $documentacion = Documentacion_url::where('id_relacion', $id_instalacion)
            ->where('id_documento', $id_documento)
            ->where('id_doc', $certificado->id_certificado)
            ->first();

        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $certificado->dictamen->instalaciones->empresa->id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

        if ($documentacion) {
            $rutaArchivo = "{$numeroCliente}/certificados_instalaciones/{$documentacion->url}";

            if (Storage::exists("public/uploads/{$rutaArchivo}")) {
                return response()->json([
                    'documento_url' => asset("files/".$rutaArchivo), // genera URL pública
                    'nombre_archivo' => basename($documentacion->url),
                ]);
            }else {
                return response()->json([
                    'documento_url' => null,
                    'nombre_archivo' => null,
                    'message' => 'Archivo físico no encontrado.',
                ], 404);
            }
        }

        return response()->json([
            'documento_url' => null,
            'nombre_archivo' => null,
            'message' => 'Ningun registro en la BD.',
        ]);
    }
///BORRAR CERTIFICADO FIRMADO
public function borrarCertificadofirmado($id)
{
    $certificado = Certificados::findOrFail($id);

    // Obtener la instalacion
    $id_instalacion = $certificado->dictamen?->id_instalacion;

    if (is_null($id_instalacion)) {
        return response()->json([
            'documento_url' => null,
            'nombre_archivo' => null,
            'message' => 'No se encontró el ID de instalacion relacionado.',
        ], 404);
    }

    // Determinar tipo_dictamen y su correspondiente id_documento
    $tipoDictamen = $certificado->dictamen->tipo_dictamen;
    switch ($tipoDictamen) {
        case 1:
            $id_documento = 127; // Productor
            break;
        case 2:
            $id_documento = 128; // Envasador
            break;
        case 3:
            $id_documento = 129; // Comercializador
            break;
        default:
            return response()->json([
                'documento_url' => null,
                'nombre_archivo' => null,
                'message' => 'Tipo de instalacion desconocido.',
            ], 422);
    }

    // Buscar documento asociado a instalacion
    $documentacion = Documentacion_url::where('id_relacion', $id_instalacion)
        ->where('id_documento', $id_documento)
        ->where('id_doc', $certificado->id_certificado)
        ->first();

    if (!$documentacion) {
        return response()->json(['message' => 'Documento no encontrado.'], 404);
    }

    $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $certificado->dictamen->instalaciones->empresa->id_empresa)->first();
    $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });


    $rutaArchivo = "public/uploads/{$numeroCliente}/certificados_instalaciones/{$documentacion->url}";

    // Eliminar archivo físico
    if (Storage::exists($rutaArchivo)) {
        Storage::delete($rutaArchivo);
    }

    // Eliminar registro en la base de datos
    $documentacion->delete();

    return response()->json(['message' => 'Documento eliminado correctamente.']);
}


    public function api()
    {
        $certificados = Certificados::with([
            'dictamen.inspeccione.solicitud.empresa',
            'dictamen.inspeccione',
            'dictamen.inspeccione.solicitud.direccion_destino'
        ])
    // ->where('fecha_emision', '>=', '2025-07-01')
        ->orderByDesc('fecha_emision')
        ->get();


        return response()->json([
            'success' => true,
            'data' => $certificados
        ]);
    }






}//end-classController
