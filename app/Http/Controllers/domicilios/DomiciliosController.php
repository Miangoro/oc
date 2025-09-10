<?php

namespace App\Http\Controllers\domicilios;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Documentacion_url;
use App\Models\instalaciones;
use App\Models\Certificados;
use App\Models\empresa;
use App\Models\estados;
use App\Models\organismos;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;//Permiso empresa

use App\Models\maquiladores_model;


class DomiciliosController extends Controller
{
    public function UserManagement()
    {
        $instalaciones = instalaciones::all(); // Obtener todas las instalaciones
        $empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $estados = estados::all(); // Obtener todos los estados
        $organismos = organismos::all(); // Obtener todos los organismos

        return view('domicilios.find_domicilio_instalaciones_view', compact('instalaciones', 'empresas', 'estados', 'organismos'));
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
    // Permiso de empresa
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

    $columns = [
        1 => 'id_instalacion',
        2 => 'direccion_completa',
        3 => 'estado',
        4 => 'folio',
        5 => 'tipo',
        6 => 'certificacion',
        7 => 'url',
        8 => 'fecha_emision',
        9 => 'fecha_vigencia',
        10 => 'responsable',
        11 => 'nombre_documento',
    ];

    $totalData = instalaciones::with('empresa', 'estados', 'organismos', 'documentos_certificados_instalaciones')
          ->whereHas('empresa', function ($q) {
              $q->where('tipo', 2);
          })->count();
    $totalFiltered = $totalData;
    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')] ?? 'id_instalacion';
    $dir = $request->input('order.0.dir') ?? 'asc';

    $search = $request->input('search.value');

    $query = instalaciones::with('empresa', 'estados', 'organismos', 'documentos_certificados_instalaciones')
        ->whereHas('empresa', function ($q) {
            $q->where('tipo', 2);
        });

    // Filtro por empresa (propia + maquiladores)
    if ($empresaId) {
        $empresasVisibles = $this->obtenerEmpresasVisibles($empresaId);
        $query->whereIn('id_empresa', $empresasVisibles);
    }
    // Filtro por instalaciones asignadas al usuario tipo 3
    if (!empty($instalacionAuth)) {
        $query->whereIn('id_instalacion', $instalacionAuth);
    }

    $filteredQuery = clone $query;
   /*  $totalData = $filteredQuery->count(); */// totalData (sin búsqueda)


        // Búsqueda Global
        if (!empty($search)) { ///BUSCADOR ACTIVO
            $filteredQuery->where(function ($q) use ($search) {
                    $q->where('responsable', 'LIKE', "%{$search}%")
                    ->orWhereHas('empresa', function ($subQuery) use ($search) {
                        $subQuery->where('razon_social', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('empresa.empresaNumClientes', function ($subQuery) use ($search) {
                        $subQuery->where('numero_cliente', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('estados', function ($subQuery) use ($search) {
                        $subQuery->where('nombre', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('organismos', function ($subQuery) use ($search) {
                        $subQuery->where('organismo', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('direccion_completa', 'LIKE', "%{$search}%")
                    ->orWhere('folio', 'LIKE', "%{$search}%")
                    ->orWhere('tipo', 'LIKE', "%{$search}%");
                });

            $totalFiltered = $filteredQuery->count();

        } else {
            $totalFiltered = $filteredQuery->count();
        }


        $instalaciones = $filteredQuery
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        //$totalFiltered = $query->count();


        $data = [];
        if (!empty($instalaciones)) {
            $ids = $start;
            foreach ($instalaciones as $instalacion) {
                $nestedData['id_instalacion'] = $instalacion->id_instalacion ?? 'N/A';
                $nestedData['fake_id'] = ++$ids  ?? 'N/A';
                $razonSocial = $instalacion->empresa ? $instalacion->empresa->razon_social : '';
                $numeroCliente =
                $instalacion->empresa->empresaNumClientes[0]->numero_cliente ??
                $instalacion->empresa->empresaNumClientes[1]->numero_cliente ??
                $instalacion->empresa->empresaNumClientes[2]->numero_cliente;

                $nestedData['razon_social'] = '<b>'.$numeroCliente . '</b><br>' . $razonSocial;
                $tipo = json_decode($instalacion->tipo, true); if (!is_array($tipo)) { $tipo = [];}
                $nestedData['tipo'] = !empty($tipo) ? implode(', ', array_map('htmlspecialchars', $tipo)) : 'N/A';
                $nestedData['responsable'] = $instalacion->responsable ?? 'N/A';
                $nestedData['estado'] = $instalacion->estados->nombre  ?? 'N/A';
                $nestedData['direccion_completa'] = $instalacion->direccion_completa  ?? 'N/A';
                $nestedData['organismo'] = $instalacion->organismos->organismo ?? 'OC CIDAM';

                $nestedData['url'] = !empty($instalacion->documentos_certificados_instalaciones->pluck('url')->toArray()) ? $instalacion->empresa->empresaNumClientes->pluck('numero_cliente')->first() . '/' . implode(',', $instalacion->documentos_certificados_instalaciones->pluck('url')->toArray()) : '';
                $nestedData['nombre_documento'] = !empty($instalacion->documentos_certificados_instalaciones->pluck('nombre_documento')->toArray()) ? implode(',', $instalacion->documentos_certificados_instalaciones->pluck('nombre_documento')->toArray()) : 'Documento sin nombre';

                $nestedData['fecha_emision'] = Helpers::formatearFecha($instalacion->fecha_emision);
                $nestedData['fecha_vigencia'] = Helpers::formatearFecha($instalacion->fecha_vigencia);
                $nestedData['actions'] = '<button class="btn btn-danger btn-sm delete-record" data-id="' . $instalacion->id_instalacion . '">Eliminar</button>';


$nestedData['certificadora'] = $instalacion->organismos->organismo ?? 'OC CIDAM';
$folio = $instalacion->folio ?? null;

/* $documentos = Documentacion_url::where('id_relacion', $instalacion->id_instalacion)
    ->whereIn('id_documento', [127, 128, 129])
    ->get()
    ->map(function ($doc) use ($numeroCliente) {
        return [
            'url' => '/files/' . $numeroCliente . '/certificados_instalaciones/' . rawurlencode($doc->url),
            'nombre' => $doc->nombre_documento,
        ];
    })
    ->toArray(); */
    $certificadoReciente = Certificados::whereHas('dictamen', function ($q) use ($instalacion) {
        $q->where('id_instalacion', $instalacion->id_instalacion);
    })
    ->orderByDesc('fecha_emision')
    ->first();

    $nestedData['certificadora'] = $instalacion->organismos->organismo ?? 'OC CIDAM';
    $folio = $instalacion->folio ?? null;

    $certificadoReciente = Certificados::whereHas('dictamen', function ($q) use ($instalacion) {
        $q->where('id_instalacion', $instalacion->id_instalacion);
    })
    ->orderByDesc('fecha_emision')
    ->first();

    $documentos = [];

    if ($certificadoReciente && $nestedData['certificadora'] === 'OC CIDAM') {
        // Solo para OC CIDAM usamos el certificado reciente
        $documentos = Documentacion_url::where('id_relacion', $instalacion->id_instalacion)
            ->whereIn('id_documento', [127, 128, 129])
            ->get()
            ->map(function ($doc) use ($numeroCliente) {
                return [
                    'url' => '/files/' . $numeroCliente . '/certificados_instalaciones/' . rawurlencode($doc->url),
                    'nombre' => $doc->nombre_documento,
                ];
            })
            ->toArray();

        $nestedData['fecha_emision_c']  = Helpers::formatearFecha($certificadoReciente->fecha_emision);
        $nestedData['fecha_vigencia_c'] = Helpers::formatearFecha($certificadoReciente->fecha_vigencia);
        $nestedData['num_certificado'] = $certificadoReciente->num_certificado;
    } else {
        // Para otros organismos usamos la info de la instalación/documentos
        $nestedData['fecha_emision_c']  = Helpers::formatearFecha($instalacion->fecha_emision ?? null);
        $nestedData['fecha_vigencia_c'] = Helpers::formatearFecha($instalacion->fecha_vigencia ?? null);
        $nestedData['num_certificado']  = $folio;
    }

    $nestedData['folio'] = $folio;
    $nestedData['documentos'] = $documentos;

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



///FUNCION ELIMINAR
public function destroy($id_instalacion)
{
    try {
        $instalacion = instalaciones::findOrFail($id_instalacion);
        $documentos = Documentacion_url::where('id_relacion', $id_instalacion)->get();

        if ($documentos->isNotEmpty()) {
            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $instalacion->id_empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                return !empty($numero);
            });

            foreach ($documentos as $documento) {
                $filePath = 'uploads/' . $numeroCliente . '/' . $documento->url;
                    if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
            Documentacion_url::where('id_relacion', $id_instalacion)->delete();
        }
        $instalacion->delete();

        return response()->json(['success' => 'Instalación y documentos eliminados correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Ocurrió un error al eliminar la instalación y los registros: ' . $e->getMessage()], 500);
    }
}



///FUNCION AGREGAR
public function store(Request $request)
{
    $request->validate([
        'id_empresa' => 'required|exists:empresa,id_empresa',
        'tipo' => 'required|array',
        'estado' => 'required|exists:estados,id',
        'direccion_completa' => 'required|string',
        'responsable' => 'required|string',
        'eslabon' => 'nullable|string|in:Productora,Envasadora,Comercializadora', // Validación del campo eslabon
        'certificacion' => 'nullable|string',

        //'folio' => 'nullable|string',
        //'id_organismo' => 'nullable|exists:catalogo_organismos,id_organismo',
        'url.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        'nombre_documento.*' => 'nullable|string',
        'id_documento.*' => 'nullable|integer',
        //'fecha_emision' => 'nullable|date',
        //'fecha_vigencia' => 'nullable|date',

        'folio' => $request->certificacion === 'otro_organismo' ? 'required|string' : 'nullable|string',
        'id_organismo' => $request->certificacion === 'otro_organismo' ? 'required|exists:catalogo_organismos,id_organismo' : 'nullable|exists:catalogo_organismos,id_organismo',
        'fecha_emision' => $request->certificacion === 'otro_organismo' ? 'required|date' : 'nullable|date',
        'fecha_vigencia' => $request->certificacion === 'otro_organismo' ? 'required|date' : 'nullable|date',
    ]);

    try {
        // Crear la instalación
        $instalacion = instalaciones::create([
            'id_empresa' => $request->input('id_empresa'),
            'tipo' => json_encode($request->input('tipo')),
            'estado' => $request->input('estado'),
            'direccion_completa' => $request->input('direccion_completa'),
            'responsable' => $request->input('responsable'),
            'certificacion' => $request->input('certificacion', null),
            'eslabon' => $request->input('eslabon', null),  // Guardar el campo eslabon

            'folio' => $request->input('folio', null),
            'id_organismo' => $request->input('id_organismo', null),
            'fecha_emision' => $request->input('fecha_emision', null),
            'fecha_vigencia' => $request->input('fecha_vigencia', null),
        ]);

        // Obtener información de la empresa
        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

        // Manejo de archivos si se suben
        if ($request->hasFile('url')) {
            $directory = 'uploads/' . $numeroCliente. '/certificados_instalaciones';
            $path = storage_path('app/public/' . $directory);
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            foreach ($request->file('url') as $index => $file) {
                $nombreDocumento = $request->nombre_documento[$index] ?? 'documento';
                $nombreDocumento = pathinfo($nombreDocumento, PATHINFO_FILENAME);

                $filename = $nombreDocumento . '_' . $instalacion->id_instalacion . '_' . $index . '.' . $file->getClientOriginalExtension();

                $filePath = $file->storeAs($directory, $filename, 'public');

                $documentacion_url = new Documentacion_url();
                $documentacion_url->id_relacion = $instalacion->id_instalacion;
                $documentacion_url->id_documento = $request->id_documento[$index] ?? null;
                $documentacion_url->nombre_documento = $nombreDocumento;
                $documentacion_url->url = $filename;
                $documentacion_url->id_empresa = $request->input('id_empresa');
                $documentacion_url->save();
            }
        }

        return response()->json(['code' => 200, 'message' => 'Instalación registrada correctamente.']);
    } catch (\Exception $e) {
        return response()->json(['code' => 500, 'message' => 'Error al registrar la instalación.', 'error' => $e->getMessage()]);
    }
}



///FUNCION OBTENER REGISTRO
public function edit($id_instalacion)
{
    try {
        $instalacion = instalaciones::findOrFail($id_instalacion);

        // Obtener todos los archivos relacionados con la instalación
        $documentacion_urls = Documentacion_url::where('id_relacion', $id_instalacion)->get();
        $archivos_urls = $documentacion_urls->pluck('url'); // Obtener todos los URLs de los archivos

        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $instalacion->id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

        return response()->json([
            'success' => true,
            'instalacion' => $instalacion,
            'archivo_urls' => $archivos_urls, // Enviar todos los archivos
            'numeroCliente' => $numeroCliente
        ]);
    } catch (ModelNotFoundException $e) {
        return response()->json(['success' => false], 404);
    }
}

///FUNCION ACTUALIZAR
public function update(Request $request, $id)
{
    $request->validate([
        'edit_id_empresa' => 'required|exists:empresa,id_empresa',
        'edit_tipo' => 'required|array',
        'edit_estado' => 'required|exists:estados,id',
        'edit_direccion' => 'required|string',
        'edit_responsable' => 'required|string',
        'edit_folio' => 'nullable|string',
        'edit_id_organismo' => 'nullable|exists:catalogo_organismos,id_organismo',
        'edit_fecha_emision' => 'nullable|date',
        'edit_fecha_vigencia' => 'nullable|date',
        'edit_eslabon' => 'nullable|string|in:Productora,Envasadora,Comercializadora',
        'edit_certificacion' => 'nullable|string',
        'edit_url' => 'nullable|array',
        'edit_url.*' => 'file|mimes:jpg,jpeg,png,pdf',
        'edit_nombre_documento' => 'nullable|array',
        'edit_nombre_documento.*' => 'string',
        'edit_id_documento' => 'nullable|array',
        'edit_id_documento.*' => 'integer',
    ]);

    try {
        $instalacion = instalaciones::findOrFail($id);

        // Actualizar instalación
        $instalacion->update([
            'id_empresa' => $request->input('edit_id_empresa'),
            'tipo' => $request->input('edit_tipo'),
            'estado' => $request->input('edit_estado'),
            'direccion_completa' => $request->input('edit_direccion'),
            'responsable' => $request->input('edit_responsable'),
            'folio' => $request->input('edit_folio', null),
            'id_organismo' => $request->input('edit_id_organismo', null),
            'fecha_emision' => $request->input('edit_fecha_emision', null),
            'fecha_vigencia' => $request->input('edit_fecha_vigencia', null),
            'certificacion' => $request->input('edit_certificacion'),
            'eslabon' => $request->input('edit_eslabon'),
        ]);

        // Obtener número de cliente de la empresa
        $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $request->input('edit_id_empresa'))->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

        // Eliminar documentos antiguos antes de actualizar
        $documentacionUrls = Documentacion_url::where('id_relacion', $id)->get();

        if ($request->hasFile('edit_url')) {
            $rutaBase = 'uploads/' . $numeroCliente . '/certificados_instalaciones';

            foreach ($documentacionUrls as $documentacionUrl) {
                $filePath = $rutaBase . '/' . $documentacionUrl->url;
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $documentacionUrl->delete();
            }

            // Subir nuevos archivos
            $files = $request->file('edit_url');
            $documentoIds = $request->input('edit_id_documento');
            $documentoNombres = $request->input('edit_nombre_documento');

            foreach ($files as $index => $file) {
                $documentoNombre = $documentoNombres[$index] ?? 'Documento sin nombre';
                $documentoId = $documentoIds[$index] ?? null;
                $filename = $documentoNombre . '_' . $instalacion->id_instalacion . '_' . ($index + 1) . '.' . $file->getClientOriginalExtension();
                //$directoryPath = 'uploads/' . $numeroCliente;
                $filePath = $file->storeAs($rutaBase, $filename, 'public');

                // Guardar la nueva entrada en la base de datos
                Documentacion_url::create([
                    'id_relacion' => $id,
                    'id_documento' => $documentoId,
                    'nombre_documento' => $documentoNombre,
                    'url' => $filename,
                    'id_empresa' => $request->input('edit_id_empresa'),
                ]);
            }
        }

        return response()->json(['code' => 200, 'message' => 'Instalación actualizada correctamente.']);
    } catch (\Exception $e) {
        return response()->json(['code' => 500, 'message' => 'Error al actualizar la instalación.', 'error' => $e->getMessage()]);
    }
}





/*     public function getDocumentosPorInstalacion(Request $request)
    {
        $request->validate([
            'id_instalacion' => 'required|exists:instalaciones,id_instalacion',
        ]);

        try {
            // Carga la instalación y sus relaciones necesarias
            $instalacion = instalaciones::with('empresa.empresaNumClientes', 'documentos')->findOrFail($request->id_instalacion);

            // Definir el filtro de tipos y los documentos válidos
            $tiposPermitidos = [
                'Productora' => 'Certificado de productora',
                'Envasadora' => 'Certificado de envasadora',
                'Comercializadora' => 'Certificado de comercializadora',
                'Almacen y bodega' => 'Certificado de almacén y bodega',
                'Area de maduracion' => 'Certificado de área de maduración'
            ];

            // Filtrar los documentos solo si coinciden con los tipos permitidos
            $documentosFiltrados = $instalacion->documentos_certificados_instalaciones;

            // Obtener el número de cliente

            $numeroCliente = $instalacion->empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                return !empty($numero);
            });

            return response()->json([
                'success' => true,
                'documentos' => $documentosFiltrados,
                'numero_cliente' => $numeroCliente,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los documentos: ' . $e->getMessage(),
            ], 500);
        }
    } */
public function getDocumentosPorInstalacion(Request $request)
{
    $request->validate([
        'id_instalacion' => 'required|exists:instalaciones,id_instalacion',
    ]);

    try {
        // Carga la instalación con sus documentos y certificados
        $instalacion = instalaciones::with(['documentos_certificados_instalaciones', 'certificados', 'empresa.empresaNumClientes'])
            ->find($request->id_instalacion);

        if (!$instalacion) {
            return response()->json([
                'success' => false,
                'message' => 'Instalación no encontrada.'
            ], 404);
        }
        // Obtener número de cliente
        $numeroCliente = $instalacion->empresa->empresaNumClientes
            ->pluck('numero_cliente')
            ->first(function ($numero) {
                return !empty($numero);
            });
        // Recorremos los documentos filtrados
        $resultado = [];
          $documentos = $instalacion->documentos_certificados_instalaciones;
          $certificados = $instalacion->certificados;

          $resultado = [];

          foreach ($documentos as $index => $documento) {
              $certificado = $certificados[$index] ?? null; // toma el certificado correspondiente si existe
                  $estatus = null;
                  $estatusClase = null;
                  if ($certificado && $certificado->fecha_vigencia) {
                      $hoy = Carbon::today();
                      $fechaVigencia = Carbon::parse($certificado->fecha_vigencia);

                      if ($fechaVigencia->lt($hoy)) {
                          $estatus = 'Vencido';
                          $estatusClase = 'rounded-pill bg-danger text-white';
                      } else {
                          $estatus = 'Vigente';
                          $estatusClase = 'rounded-pill bg-success text-white';
                      }
                  }

              $resultado[] = [
                  'tipo_certificado' => $documento->nombre_documento,
                  'fecha_inicio' => $certificado->fecha_emision ?? null,
                  'fecha_vigencia' => $certificado->fecha_vigencia ?? null,
                  'estatus' => $estatus,
                  'estatus_clase' => $estatusClase,
                  'certificado' => $documento->url,
                  'num_certificado' => $certificado->num_certificado ?? null,
              ];
          }
        return response()->json([
            'success' => true,
            'documentos' => $resultado,
            'numero_cliente' => $numeroCliente ?? 'N/A',
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al obtener los documentos: ' . $e->getMessage(),
        ], 500);
    }
}



//end
}
