<?php

namespace App\Http\Controllers\gestionCalidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\documentos_calidad;
use App\Models\documentos_calidad_historial;


class DocumentosManualesController extends Controller
{
       //
      public function UserManagement()
    {
        $tipo_usuario =  Auth::user()->name;
        $usuarios = User::where('tipo', '!=', 3)->get();
        return view('gestion_calidad.find_documentos_manuales_view', compact('tipo_usuario', 'usuarios'));
    }

    public function index(Request $request)
    {
        $columns = [
            0 => 'id_doc_calidad',
            1 => 'tipo',
            2 => 'archivo',
            3 => 'archivo_editable',
            4 => 'identificacion',
            5 => 'nombre',
            6 => 'estatus',
            /*  */
            8 => 'area',
            9 => 'modifico',
            10 => 'reviso',
            11 => 'aprobo',
            12 => 'id_usuario_registro',
        ];

        $search = [];

        $totalData = documentos_calidad::where('tipo', 4)->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
              // 🔥 Solo traer tipo = 2
              $users = documentos_calidad::where('tipo', 4)
                  ->offset($start)
                  ->limit($limit)
                  ->orderBy($order, $dir)
                  ->get();
          } else {
              $search = $request->input('search.value');

              $users = documentos_calidad::where('tipo', 4)
                  ->where(function ($query) use ($search) {
                      $query->where('id_doc_calidad', 'LIKE', "%{$search}%")
                            ->orWhere('nombre', 'LIKE', "%{$search}%");
                  })
                  ->offset($start)
                  ->limit($limit)
                  ->orderBy($order, $dir)
                  ->get();

              $totalFiltered = documentos_calidad::where('tipo', 4)
                  ->where(function ($query) use ($search) {
                      $query->where('id_doc_calidad', 'LIKE', "%{$search}%")
                            ->orWhere('nombre', 'LIKE', "%{$search}%");
                  })
                  ->count();
          }

        $data = [];

        if (!empty($users)) {
            $ids = $start;

            foreach ($users as $user) {
                $nestedData['id_doc_calidad'] = $user->id_doc_calidad; // Ajusta el nombre de la columna según tu base de datos
                $nestedData['fake_id'] = ++$ids;
                $nestedData['nombre'] = $user->nombre; // Ajusta el nombre de la columna según tu base de datos
                $nestedData['identificacion'] = $user->identificacion;
                $nestedData['estatus'] = $user->estatus;
                $nestedData['archivo'] = $user->archivo;
                $nestedData['archivo_editable'] = $user->archivo_editable;
                $nestedData['edicion'] = $user->edicion;
                 $versiones = documentos_calidad_historial::where('id_doc_calidad', $user->id_doc_calidad)->count();
                $nestedData['versiones'] = $versiones;
                $data[] = $nestedData;
            }
        }

        if ($data) {
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'code' => 200,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
                'data' => [],
            ]);
        }
    }

// Función para eliminar un documento de referencia
public function destroy($id)
{
    try {
        $documento = documentos_calidad::with('historial')->findOrFail($id);

        // Eliminar historial primero
        $documento->historial()->delete();

        // Luego eliminar el documento
        $documento->delete();

        return response()->json(['success' => 'Documento y su historial eliminados correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al eliminar el documento'], 500);
    }
}



  public function store(Request $request)
  {
      $request->validate([
          'nombre'         => 'required|string|max:255',
          'identificacion' => 'required|string|max:100',
          'area'           => 'required|integer',
          'edicion'        => 'required|string|max:50',
          'fecha_edicion'  => 'required|date',
          'estatus'        => 'required|string|max:50',
          'modifico'       => 'required|string|max:255',
          'reviso'         => 'required|integer',
          'aprobo'         => 'required|integer',
          'archivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,png,jpg,jpeg|max:12288',
          'archivo_editable' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,png,jpg,jpeg|max:12288',

      ]);

      try {
          // Guardar archivo
          $archivoPath = null;
          if ($request->hasFile('archivo')) {
              $archivoPath = $request->file('archivo')->store('documentos_manuales', 'public');
          }

           $archivoPathEdit = null;
          if ($request->hasFile('archivo_editable')) {
              $archivoPathEdit = $request->file('archivo_editable')->store('documentos_manuales', 'public');
          }

          // Guardar en documentos_calidad
          $documento = new documentos_calidad();
          $documento->nombre         = $request->nombre;
          $documento->identificacion = $request->identificacion;
          $documento->area           = $request->area;
          $documento->tipo           = 4;
          $documento->edicion        = $request->edicion;
          $documento->fecha_edicion  = $request->fecha_edicion;
          $documento->estatus        = $request->estatus;
          $documento->modifico       = $request->modifico;
          $documento->reviso         = $request->reviso;
          $documento->aprobo         = $request->aprobo;
          $documento->archivo        = $archivoPath;
          $documento->archivo_editable        = $archivoPathEdit;
          $documento->id_usuario_registro = Auth::id();
          $documento->save();

          // Guardar en historial
          $historial = new documentos_calidad_historial();
          $historial->id_doc_calidad = $documento->id_doc_calidad;
          $historial->tipo        = 4;
          $historial->area           = $documento->area;
          $historial->nombre         = $documento->nombre;
          $historial->identificacion = $documento->identificacion;
          $historial->edicion        = $documento->edicion;
          $historial->fecha_edicion  = $documento->fecha_edicion;
          $historial->estatus        = $documento->estatus;
          $historial->archivo        = $documento->archivo;
          $historial->archivo_editable = $documento->archivo_editable;
          $historial->modifico       = $documento->modifico;
          $historial->reviso         = $documento->reviso;
          $historial->aprobo         = $documento->aprobo;
          $historial->id_usuario_registro = Auth::id();
          $historial->save();

          return response()->json(['success' => 'Documento registrado correctamente']);

      } catch (\Exception $e) {
          return response()->json([
              'error'   => 'Error al registrar el documento',
              'message' => $e->getMessage()
          ], 500);
      }
  }

// DocumentosReferenciaController.php
public function historial($id)
{
    $historial = documentos_calidad_historial::where('id_doc_calidad', $id)->get();

    return response()->json([
        'data' => $historial
    ]);
}


//funcion para llenar el campo del formulario
    public function edit($id_doc)
    {
        try {
            $doc = documentos_calidad::findOrFail($id_doc);
            return response()->json($doc);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el documento'], 500);
        }
    }

    // Función para actualizar una clase existente
  public function update(Request $request, $id)
  {
      $request->validate([
          'nombre'         => 'required|string|max:255',
          'identificacion' => 'required|string|max:100',
          'area'           => 'required|integer',
          'edicion'        => 'required|string|max:50',
          'fecha_edicion'  => 'required|date',
          'estatus'        => 'required|string|max:50',
          'modifico'       => 'required|string|max:255',
          'reviso'         => 'required|integer',
          'aprobo'         => 'required|integer',
          'archivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,png,jpg,jpeg|max:12288',
          'archivo_editable' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,png,jpg,jpeg|max:12288',
      ]);

      try {
          // Buscar documento existente
          $documento = documentos_calidad::findOrFail($id);

          // Guardar archivo si se sube uno nuevo
          if ($request->hasFile('archivo')) {
              $archivoPath = $request->file('archivo')->store('documentos_manuales', 'public');
              $documento->archivo = $archivoPath;
          }
          if ($request->hasFile('archivo_editable')) {
              $archivoPathedita = $request->file('archivo_editable')->store('documentos_manuales', 'public');
              $documento->archivo_editable = $archivoPathedita;
          }

          // Actualizar campos del documento
          $documento->nombre         = $request->nombre;
          $documento->identificacion = $request->identificacion;
          $documento->tipo = 4;
          $documento->area           = $request->area;
          $documento->edicion        = $request->edicion;
          $documento->fecha_edicion  = $request->fecha_edicion;
          $documento->estatus        = $request->estatus;
          $documento->modifico       = $request->modifico;
          $documento->reviso         = $request->reviso;
          $documento->aprobo         = $request->aprobo;
          $documento->id_usuario_registro  = Auth::id();
          $documento->save();

          // Registrar nueva versión en historial
          $historial = new documentos_calidad_historial();
          $historial->id_doc_calidad       = $documento->id_doc_calidad;
          $historial->tipo                 = 4;
          $historial->nombre               = $documento->nombre;
          $historial->area           = $documento->area;
          $historial->identificacion       = $documento->identificacion;
          $historial->edicion              = $documento->edicion;
          $historial->fecha_edicion        = $documento->fecha_edicion;
          $historial->estatus              = $documento->estatus;
          $historial->archivo              = $documento->archivo;
          $historial->archivo_editable     = $documento->archivo_editable;
          $historial->modifico             = $documento->modifico;
          $historial->reviso               = $documento->reviso;
          $historial->aprobo               = $documento->aprobo;
          $historial->id_usuario_registro  = Auth::id();
          $historial->save();

          return response()->json(['success' => 'Nueva versión registrada correctamente']);

      } catch (\Exception $e) {
          return response()->json([
              'error'   => 'Error al actualizar el documento',
              'message' => $e->getMessage()
          ], 500);
      }
  }

  public function editHistorial($id)
  {
        try {
            $historial = documentos_calidad_historial::findOrFail($id);
            return response()->json($historial);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo obtener el historial',
                'message' => $e->getMessage()
            ], 404);
        }
  }

  public function updateHistorial(Request $request, $id)
  {
      $request->validate([
          'nombre' => 'required|string|max:255',
          'identificacion' => 'required|string|max:100',
          'area' => 'required|integer',
          'edicion' => 'required|string|max:50',
          'fecha_edicion' => 'required|date',
          'estatus' => 'required|string|max:50',
          'modifico' => 'required|string|max:255',
          'reviso' => 'required|integer',
          'aprobo' => 'required|integer',
          'archivo' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,png,jpg,jpeg|max:12288',
          'archivo_editable' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,png,jpg,jpeg|max:12288',
      ]);

      try {
          $historial = documentos_calidad_historial::findOrFail($id);

          // Actualizar campos
          $historial->nombre = $request->nombre;
          $historial->identificacion = $request->identificacion;
          $historial->area = $request->area;
          $historial->tipo = 4;
          $historial->edicion = $request->edicion;
          $historial->fecha_edicion = $request->fecha_edicion;
          $historial->estatus = $request->estatus;
          $historial->modifico = $request->modifico;
          $historial->reviso = $request->reviso;
          $historial->aprobo = $request->aprobo;

          // Si hay archivo nuevo
          if ($request->hasFile('archivo')) {
              $archivoPath = $request->file('archivo')->store('documentos_manuales', 'public');
              $historial->archivo = $archivoPath;
          }
          if ($request->hasFile('archivo')) {
              $archivoPathE = $request->file('archivo_editable')->store('documentos_manuales', 'public');
              $historial->archivo_editable = $archivoPathE;
          }

          $historial->save();

          return response()->json(['success' => 'Historial actualizado correctamente']);

      } catch (\Exception $e) {
          return response()->json([
              'error' => 'Error al actualizar el historial',
              'message' => $e->getMessage()
          ], 500);
      }
  }

}
