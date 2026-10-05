<?php

namespace App\Http\Controllers;

use App\Models\AgendaCapacidad;
use App\Models\AgendaEvento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AgendaCapacidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:editar-evento|editar-agenda-evento');
    }

    public function index(): View
    {
        $capacidades = AgendaCapacidad::orderBy('fecha_evento')->get();

        return view('panel-eventos.capacidades-agenda', compact('capacidades'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'fecha_evento' => ['required', 'date'],
            'max_eventos' => ['required', 'integer', 'min:1', 'max:23'],
            'horarios' => ['required', 'array', 'min:1', 'max:23'],
            'horarios.*' => ['required', 'date_format:H:i'],
        ], [
            'horarios.*.date_format' => 'Cada horario debe tener el formato HH:MM.',
        ]);

        $horarios = collect($data['horarios'])
            ->map(fn (string $hora) => substr($hora, 0, 5))
            ->sort()
            ->values()
            ->all();

        if (count($horarios) !== (int) $data['max_eventos']) {
            throw ValidationException::withMessages([
                'max_eventos' => 'El máximo de eventos debe coincidir con la cantidad de horarios configurados.',
            ]);
        }

        $this->validarEventosExistentes($data['fecha_evento'], $data['max_eventos'], $horarios);

        AgendaCapacidad::updateOrCreate(
            ['fecha_evento' => $data['fecha_evento']],
            [
                'max_eventos' => $data['max_eventos'],
                'horarios' => $horarios,
            ]
        );

        return redirect()
            ->route('panel-eventos.capacidades-agenda.index')
            ->with('success', 'La capacidad de agenda para la fecha seleccionada fue guardada.');
    }

    public function destroy(AgendaCapacidad $agendaCapacidad): RedirectResponse
    {
        $this->validarEventosExistentes(
            $agendaCapacidad->fecha_evento->format('Y-m-d'),
            AgendaEvento::CAPACIDAD_PREDETERMINADA,
            AgendaEvento::HORARIOS_PREDETERMINADOS
        );

        $agendaCapacidad->delete();

        return redirect()
            ->route('panel-eventos.capacidades-agenda.index')
            ->with('success', 'La fecha volvió a usar la capacidad predeterminada de 2 eventos.');
    }

    private function validarEventosExistentes(string $fecha, int $maxEventos, array $horarios): void
    {
        $eventosActivos = AgendaEvento::activos()
            ->whereDate('fecha_evento', $fecha)
            ->get(['hora_inicio']);

        if ($eventosActivos->count() > $maxEventos) {
            throw ValidationException::withMessages([
                'max_eventos' => 'No puedes establecer un máximo menor a los eventos activos que ya existen en esta fecha.',
            ]);
        }

        $horariosActivos = $eventosActivos
            ->map(fn (AgendaEvento $evento) => substr((string) $evento->hora_inicio, 0, 5))
            ->unique()
            ->values()
            ->all();

        if (array_diff($horariosActivos, $horarios) !== []) {
            throw ValidationException::withMessages([
                'horarios' => 'Debes conservar los horarios de los eventos activos que ya existen en esta fecha.',
            ]);
        }
    }
}
