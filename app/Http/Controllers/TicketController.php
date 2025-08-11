<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketMensaje;
use App\Models\TicketEvidencia;
use Illuminate\Support\Facades\Auth;
use App\Notifications\GeneralNotification;
use App\Models\User;




class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('id_usuario', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('tickets.tickets_index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.crear_ticket');
    }

    public function store(Request $request)
{
    $request->validate([
        'asunto' => 'required|string|max:255',
        'prioridad' => 'required|string',
        'descripcion' => 'required|string',
        'evidencias.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
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
    ]);

    // Guardar evidencias
    if ($request->hasFile('evidencias')) {
        foreach ($request->file('evidencias') as $archivo) {
            $path = $archivo->store('evidencias', 'public');
            TicketEvidencia::create([
                'ticket_id' => $ticket->id,
                'archivo' => $path,
            ]);
        }
    }

    // 🔔 Notificar a administradores
    $admins = User::whereIn('id', [1, 3, 4, 7])->get(); // ajusta los IDs según tu sistema
    $data = [
        'title' => 'Nuevo ticket registrado',
        'message' => "Folio: {$ticket->folio} — Asunto: {$ticket->asunto}",
        'url' => route('tickets.show', $ticket->id),
    ];

    foreach ($admins as $admin) {
        $admin->notify(new GeneralNotification($data));
    }

    return redirect()->route('tickets.index')->with('success', 'Ticket creado correctamente con folio ' . $folio);
}



    public function detalle($id)
    {
        $ticket = Ticket::with(['usuario', 'mensajes', 'evidencias'])->findOrFail($id);

        // Puedes agregar lógica adicional si el ticket debe ser visible solo por el dueño o por admins
        if ($ticket->id_usuario !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este ticket.');
        }

        return view('tickets.detalle_ticket', compact('ticket'));
    }
    public function filtrar(Request $request)
    {
        $query = Ticket::query()->where('id_usuario', Auth::id());

        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        if ($request->prioridad) {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->responsable) {
            $query->where('responsable_id', $request->responsable);
        }

        $tickets = $query->orderBy('created_at', 'desc')->get();

        $html = '';

        if ($tickets->isEmpty()) {
            $html = '<tr><td colspan="6" class="text-center text-muted">No se encontraron tickets con los filtros seleccionados.</td></tr>';
        } else {
            foreach ($tickets as $ticket) {
                $html .= '
            <tr>
              <td>' . $ticket->id . '</td>
              <td>' . e($ticket->asunto) . '</td>
              <td>' . ucfirst($ticket->prioridad) . '</td>
              <td>' . ucfirst($ticket->estado) . '</td>
              <td>' . $ticket->created_at->format('d/m/Y') . '</td>
              <td>
                <a href="' . route('tickets.show', $ticket->id) . '" class="btn btn-sm btn-info">Ver</a>
              </td>
            </tr>';
            }
        }

        return response()->json(['html' => $html]);
    }

    public function crearTicket()
    {
        $usuario = Auth::user(); // Esto accede a la tabla users automáticamente
        return view('tickets.crear', compact('usuario'));
    }
    public function actualizar(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);

    // Solo admins pueden actualizar
    if (auth()->user()->tipo !== 2) {
        abort(403);
    }

    $ticket->estatus = $request->estatus;
    $ticket->comentario = $request->comentario;
    $ticket->save();

    return redirect()->back()->with('success', 'Ticket actualizado correctamente.');
}


}