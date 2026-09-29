<?php

namespace App\Http\Controllers;

use App\Models\AgendaFechaBloqueada;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgendaFechaBloqueadaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:editar-agenda-evento');
    }

    public function index(): View
    {
        $fechasBloqueadas = AgendaFechaBloqueada::orderBy('fecha_evento')->get();

        return view('panel-eventos.fechas-bloqueadas-agenda', compact('fechasBloqueadas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'fecha_evento' => ['required', 'date', 'after_or_equal:today'],
            'motivo' => ['nullable', 'string', 'max:500'],
        ]);

        AgendaFechaBloqueada::updateOrCreate(
            ['fecha_evento' => $data['fecha_evento']],
            ['motivo' => $data['motivo'] ?? null]
        );

        return redirect()
            ->route('panel-eventos.fechas-bloqueadas-agenda.index')
            ->with('success', 'La fecha quedó bloqueada para solicitudes públicas.');
    }

    public function destroy(AgendaFechaBloqueada $agendaFechaBloqueada): RedirectResponse
    {
        $agendaFechaBloqueada->delete();

        return redirect()
            ->route('panel-eventos.fechas-bloqueadas-agenda.index')
            ->with('success', 'La fecha volvió a estar disponible para solicitudes públicas.');
    }
}
