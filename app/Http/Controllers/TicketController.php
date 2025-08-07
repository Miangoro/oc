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
        'prioridad' => 'required|string',
        'descripcion' => 'required|string',
        'evidencias.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $ticket = Ticket::create([
        'id_usuario' => Auth::id(),
        'asunto' => $request->asunto,
        'prioridad' => $request->prioridad,
        'descripcion' => $request->descripcion,
    ]);

    if ($request->hasFile('evidencias')) {
        foreach ($request->file('evidencias') as $archivo) {
            $path = $archivo->store('evidencias', 'public');
            TicketEvidencia::create([
                'ticket_id' => $ticket->id,
                'archivo' => $path,
            ]);
        }
    }

    return redirect()->route('tickets.index')->with('success', 'Ticket creado correctamente.');


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



}