<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\TicketMensaje;
use App\Models\TicketEvidencia;

use App\Models\LotesGranel;
use App\Models\BitacoraMezcal;
use App\Models\empresa;
use App\Models\maquiladores_model;
use App\Models\instalaciones;
use App\Notifications\GeneralNotification;
use App\Models\User;
use Carbon\Carbon;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\ValidationException;

class ticketsController extends Controller
{
    public function UserManagement()
    {
        $bitacora = BitacoraMezcal::all();
         $empresaIdAut = Auth::check() && Auth::user()->tipo == 3
        ? Auth::user()->empresa?->id_empresa
        : null;
          if ($empresaIdAut) {
                  // 👇 Usa la función que ya tienes
                  $idsEmpresas = $this->obtenerEmpresasVisibles($empresaIdAut, null);

                  $empresas = empresa::with('empresaNumClientes')
                      ->whereIn('id_empresa', $idsEmpresas)
                      ->get();
              } else {
                  $empresas = empresa::with('empresaNumClientes')
                      ->where('tipo', 2)
                      ->get();
              }
      $tipo_usuario =  Auth::user()->tipo;
        $instalacionesIds = Auth::user()->id_instalacion ?? [];
         $instalacionesUsuario = instalaciones::whereIn('id_instalacion', $instalacionesIds)->get();
         $tickets = Ticket::where('id_usuario', Auth::id())->orderBy('created_at', 'desc')->get();
          $usuario = Auth::user(); // Esto accede a la tabla users automáticamente
        return view('tickets.find_tickets', compact('bitacora', 'empresas', 'tipo_usuario', 'instalacionesIds','instalacionesUsuario','tickets','usuario'));
        /* return view('bitacoras.find_BitacoraMezcal_view', compact('bitacora', 'empresas', 'tipo_usuario', 'instalacionesIds','instalacionesUsuario')); */

    }

    private function obtenerEmpresasVisibles($empresaIdAut, $empresaId)
    {
          $idsEmpresas = [];
          if ($empresaIdAut) {
              $idsEmpresas[] = $empresaIdAut;
              $idsEmpresas = array_merge($idsEmpresas,
                  maquiladores_model::where('id_maquiladora', $empresaIdAut)->pluck('id_maquilador')->toArray()
              );
          }
          if ($empresaId) {
              $idsEmpresas[] = $empresaId;
              $idsEmpresas = array_merge($idsEmpresas,
                  maquiladores_model::where('id_maquiladora', $empresaId)->pluck('id_maquilador')->toArray()
              );
          }
          return array_unique($idsEmpresas);
    }


   public function index(Request $request)
{
    $estado = $request->input('estado');
    $prioridad = $request->input('prioridad');


    $search = $request->input('search.value');
    $limit = $request->input('length', 10);
    $start = $request->input('start', 0);
    $orderColumn = $request->input('order.0.column', 1);
    $orderDir = $request->input('order.0.dir', 'desc');

    $columns = [
        0 => 'id_ticket',
        1 => 'folio',
        2 => 'asunto',
        3 => 'prioridad',
        4 => 'estatus',
        5 => 'created_at',
    ];

    /* $query = Ticket::query(); */
   /*  $query = Ticket::where('id_usuario', auth()->id()); */
    if (auth()->id() == 1) {
        $query = Ticket::query(); // Admin ve todos los tickets
    } else {
        $query = Ticket::where('id_usuario', auth()->id()); // Usuario normal solo los suyos
    }
        // Filtros adicionales
        if (!empty($estado)) {
            $query->where('estatus', $estado);
        }

        if (!empty($prioridad)) {
            $query->where('prioridad', $prioridad);
        }
    $totalData = $query->count();
    $totalFiltered = $totalData;

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('folio', 'LIKE', "%{$search}%")
              ->orWhere('asunto', 'LIKE', "%{$search}%")
              ->orWhere('prioridad', 'LIKE', "%{$search}%")
              ->orWhere('estatus', 'LIKE', "%{$search}%")
              ->orWhere('descripcion', 'LIKE', "%{$search}%")
              ->orWhere('nombre', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
        });

        // Filtros adicionales
        if (!empty($estado)) {
            $query->where('estatus', $estado);
        }

        if (!empty($prioridad)) {
            $query->where('prioridad', $prioridad);
        }
        $totalFiltered = $query->count();
    }

    $tickets = $query
        ->offset($start)
        ->limit($limit)
        ->orderBy($columns[$orderColumn], $orderDir)
        ->get();

    $data = [];
    $counter = $start + 1;
    foreach ($tickets as $ticket) {
        $data[] = [
            'fake_id' => $counter++,
            'id_ticket' => $ticket->id_ticket,
            'folio' => $ticket->folio,
            'asunto' => $ticket->asunto,
            'solicitante' => $ticket->usuario->name,
            'prioridad' => $ticket->prioridad,
            'estatus' => $ticket->estatus,
            'created_at' => $ticket->created_at->format('d/m/Y H:i'),
        ];
    }

    return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => $totalData,
        'recordsFiltered' => $totalFiltered,
        'code' => 200,
        'data' => $data,
    ]);
}



public function store(Request $request)
{
    try {
        $request->validate([
            'asunto' => 'required|string|max:255',
            'prioridad' => 'required|string',
            'descripcion' => 'required|string',
           'evidencias.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',

        ]);

        // Generar folio
        $fecha = now()->format('Ymd');
        $contador = Ticket::whereDate('created_at', now())->count() + 1;
        $numero = str_pad($contador, 4, '0', STR_PAD_LEFT);
        $folio = "TKT-{$fecha}-{$numero}";

        // Crear el ticket
        $ticket = Ticket::create([
            'id_usuario' => Auth::id(),
            'nombre' => $request->nombre,
            'email' => $request->email,
            'asunto' => $request->asunto,
            'prioridad' => $request->prioridad,
            'descripcion' => $request->descripcion,
            'folio' => $folio,
            'estatus' => 'pendiente',
        ]);

        // Guardar evidencias
        if ($request->hasFile('evidencias')) {
            foreach ($request->file('evidencias') as $archivo) {
                $path = $archivo->store('evidencias', 'public');
                TicketEvidencia::create([
                    'ticket_id' => $ticket->id_ticket,
                    'evidencia_url' => $path,
                ]);
            }
        }

        // Notificar a administradores
        $admins = User::whereIn('id', [1, 3, 4, 7])->get();
        $data = [
            'title' => 'Nuevo ticket registrado',
            'message' => "Folio: {$ticket->folio} — Asunto: {$ticket->asunto}",
            'url' => route('tickets.show', $ticket->id_ticket),
        ];
        foreach ($admins as $admin) {
            $admin->notify(new GeneralNotification($data));
        }

        // Respuesta JSON de éxito
        return response()->json(['success' => 'Ticket creado correctamente con folio ' . $folio]);

    } catch (\Illuminate\Validation\ValidationException $e) {
            // Retorna todos los mensajes de validación
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
}




  public function mensajes($ticketId)
  {
      $ticket = Ticket::with(['mensajes.usuario'])->findOrFail($ticketId);
      return view('tickets.partials.mensajes', compact('ticket'));
  }

// Enviar un mensaje
public function storeMensaje(Request $request, $ticketId)
{
    $request->validate([
        'mensaje' => 'required|string|max:1000'
    ]);

    $ticket = Ticket::findOrFail($ticketId);
    $user = auth()->user();
    $rol = ($user->puesto === 'Desarrollador') ? 'admin' : 'usuario';
    $mensaje = $ticket->mensajes()->create([
        'mensaje' => $request->mensaje,
        'id_usuario' => $user->id,
        'rol_emisor' => $rol,
    ]);

    // Devolver JSON para AJAX
    return response()->json([
        'success' => true,
        'mensaje' => $mensaje->load('usuario') // carga relación usuario para mostrar nombre
    ]);
}



  public function updateEstatus(Request $request, Ticket $ticket)
  {
      $request->validate([
          'estatus' => 'required|in:pendiente,abierto,cerrado'
      ]);

      $ticket->estatus = $request->estatus;
      $ticket->save();

      return response()->json(['success' => true]);
  }



public function destroy($id_ticket)
{
    $ticket = Ticket::with(['evidencias', 'mensajes'])->find($id_ticket);

    if (!$ticket) {
        return response()->json([
            'error' => 'Ticket no encontrado.'
        ], 404);
    }

    // Eliminar archivos físicos
    foreach ($ticket->evidencias as $evidencia) {
        if ($evidencia->ruta && \Storage::exists($evidencia->ruta)) {
            \Storage::delete($evidencia->ruta);
        }
    }

    // Eliminar relaciones
    $ticket->evidencias()->delete();
    $ticket->mensajes()->delete();

    // Eliminar ticket
    $ticket->delete();

    return response()->json([
        'success' => 'Ticket eliminado correctamente.'
    ]);
}



}
