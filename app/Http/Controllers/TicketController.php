<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketMensaje;
use App\Models\TicketEvidencia;
use Illuminate\Support\Facades\Auth;



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
            'prioridad' => 'required|in:alta,media,baja',
            'mensaje' => 'required|string',
        ]);

        $ticket = Ticket::create([
            'asunto' => $request->asunto,
            'prioridad' => $request->prioridad,
            'mensaje' => $request->mensaje,
            'id_usuario' => Auth::id(),
            'estatus' => 'pendiente',
        ]);

        // Guardar evidencias si hay
        if ($request->hasFile('evidencias')) {
            foreach ($request->file('evidencias') as $file) {
                $path = $file->store('tickets_evidencias', 'public');
                TicketEvidencia::create([
                    'ticket_id' => $ticket->id_ticket,
                    'evidencia_url' => $path,
                ]);
            }
        }

        return redirect()->route('tickets.tickets_index')->with('success', 'Ticket creado correctamente.');
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
}