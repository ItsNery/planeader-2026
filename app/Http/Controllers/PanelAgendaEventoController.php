<?php

namespace App\Http\Controllers;

use App\Models\AgendaEvento;
use App\Models\Subcomite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon as SupportCarbon;

class PanelAgendaEventoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-agenda-evento|crear-agenda-evento|editar-agenda-evento|borrar-agenda-evento', ['only' => ['index']]);
        $this->middleware('permission:crear-agenda-evento', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-agenda-evento', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:borrar-agenda-evento', ['only' => ['destroy']]);
    }

    public function index()
    {
        $eventos = AgendaEvento::with('subcomite')
            ->orderByDesc('fecha_evento')
            ->orderByDesc('created_at')
            ->get();

        Carbon::setLocale('es');
        $mesSolicitado = request('mes', now()->format('Y-m'));
        try {
            $fechaBase = Carbon::createFromFormat('Y-m', $mesSolicitado)->startOfMonth();
        } catch (\Throwable $exception) {
            $fechaBase = now()->startOfMonth();
        }

        $eventosDelMes = AgendaEvento::with('subcomite')
            ->whereYear('fecha_evento', $fechaBase->year)
            ->whereMonth('fecha_evento', $fechaBase->month)
            ->orderBy('fecha_evento')
            ->orderBy('hora_inicio')
            ->get();

        $eventosPorDia = $eventosDelMes->groupBy(fn ($evento) => $evento->fecha_evento->day);
        $diasEnMes = $fechaBase->daysInMonth;
        $diaDeLaSemanaInicio = $fechaBase->dayOfWeek;
        $mesAnterior = $fechaBase->copy()->subMonth()->format('Y-m');
        $mesSiguiente = $fechaBase->copy()->addMonth()->format('Y-m');

        return view('panel-agenda-eventos.index', compact(
            'eventos',
            'eventosPorDia',
            'fechaBase',
            'diasEnMes',
            'diaDeLaSemanaInicio',
            'mesAnterior',
            'mesSiguiente'
        ));
    }

    public function export(): StreamedResponse
    {
        return $this->exportarEventos();
    }

    public function exportSesiones(): StreamedResponse
    {
        return $this->exportarEventos('sesion', 'agenda-sesiones');
    }

    public function exportMesasTecnicas(): StreamedResponse
    {
        return $this->exportarEventos('mesa_tecnica', 'agenda-mesas-tecnicas');
    }

    private function exportarEventos(?string $tipo = null, string $nombre = 'agenda-contactos'): StreamedResponse
    {
        $eventos = AgendaEvento::with('subcomite')
            ->when($tipo, fn ($query) => $query->where('tipo_evento', $tipo))
            ->orderBy('fecha_evento')
            ->get();

        return response()->streamDownload(function () use ($eventos) {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['Folio', 'Tipo', 'Subcomité', 'Fecha', 'Hora inicio', 'Modalidad', 'Institución', 'Responsable', 'Correo', 'Teléfono', 'Estado'], ';');
            foreach ($eventos as $evento) {
                fputcsv($output, [
                    $evento->folio,
                    $evento->descripcionTipo(),
                    $evento->subcomite?->nombre,
                    $evento->fecha_evento->format('Y-m-d'),
                    $evento->horaInicioFormateada(),
                    $evento->modalidad,
                    $evento->institucion_organizadora,
                    $evento->solicitante_nombre,
                    $evento->solicitante_email,
                    $evento->solicitante_telefono,
                    $evento->estado,
                ], ';');
            }
            fclose($output);
        }, $nombre . '-' . now()->format('Y-m-d') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function create()
    {
        $evento = new AgendaEvento();
        $subcomites = Subcomite::where('publicado', true)->orderBy('nombre')->get();

        return view('panel-agenda-eventos.form', compact('evento', 'subcomites'));
    }

    public function show(AgendaEvento $agendaEvento)
    {
        $agendaEvento->load('subcomite');

        return view('panel-agenda-eventos.show', ['evento' => $agendaEvento]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $this->validateAgendaDateAndHours($data);
        $data['folio'] = 'AG-' . now()->format('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
        $data['publicado'] = $request->boolean('publicado', true);
        $data['estado'] = $data['estado'] ?? 'confirmado';
        $data['confirmado_at'] = $data['estado'] === 'confirmado' ? now() : null;

        $this->ensureDateAvailable($data['fecha_evento'], $data['hora_inicio']);
        $existenteInactivo = AgendaEvento::whereDate('fecha_evento', $data['fecha_evento'])
            ->whereTime('hora_inicio', $data['hora_inicio'])
            ->first();
        if ($existenteInactivo) {
            $existenteInactivo->update($data);
        } else {
            AgendaEvento::create($data);
        }

        return redirect()->route('panel-agenda-eventos.index')->with('success', 'Evento de agenda creado.');
    }

    public function edit(AgendaEvento $agendaEvento)
    {
        $evento = $agendaEvento;
        $subcomites = Subcomite::where('publicado', true)->orderBy('nombre')->get();

        return view('panel-agenda-eventos.form', compact('evento', 'subcomites'));
    }

    public function update(Request $request, AgendaEvento $agendaEvento)
    {
        $data = $this->validated($request, $agendaEvento);
        $this->validateAgendaDateAndHours($data);
        $data['publicado'] = $request->boolean('publicado');

        $this->ensureDateAvailable($data['fecha_evento'], $data['hora_inicio'], $agendaEvento);
        $data['confirmado_at'] = ($data['estado'] ?? $agendaEvento->estado) === 'confirmado'
            ? ($agendaEvento->confirmado_at ?: now())
            : null;
        $agendaEvento->update($data);

        return redirect()->route('panel-agenda-eventos.index')->with('success', 'Evento de agenda actualizado.');
    }

    public function status(Request $request, AgendaEvento $agendaEvento)
    {
        $data = $request->validate([
            'estado' => 'required|in:pendiente,confirmado,rechazado,cancelado',
            'observaciones_admin' => 'nullable|string|max:2000',
            'liga_videoconferencia' => 'nullable|url|max:2000',
        ]);

        $agendaEvento->fill($data);
        $agendaEvento->confirmado_at = $data['estado'] === 'confirmado' ? now() : null;
        $agendaEvento->save();

        return back()->with('success', 'Estado de la solicitud actualizado.');
    }

    public function destroy(AgendaEvento $agendaEvento)
    {
        $agendaEvento->delete();

        return redirect()->route('panel-agenda-eventos.index')->with('success', 'Solicitud eliminada y fecha liberada.');
    }

    private function validated(Request $request, ?AgendaEvento $evento = null): array
    {
        $request->merge([
            'hora_inicio' => $this->normalizarHora($request->input('hora_inicio')),
            'hora_fin' => $this->normalizarHora($request->input('hora_fin')),
        ]);

        return $request->validate([
            'tipo_evento' => 'required|in:sesion,mesa_tecnica',
            'subcomite_id' => 'nullable|exists:subcomites,id',
            'tematica' => 'nullable|string|max:255',
            'institucion_organizadora' => 'required|string|max:255',
            'fecha_evento' => 'required|date|after:today',
            'hora_inicio' => 'required|in:10:00,13:00',
            'hora_fin' => 'nullable|string',
            'modalidad' => 'required|in:virtual,presencial',
            'liga_videoconferencia' => 'nullable|url|max:2000',
            'ubicacion' => 'required_if:modalidad,presencial|nullable|string|max:1000',
            'solicitante_nombre' => 'required|string|max:255',
            'solicitante_cargo' => 'nullable|string|max:255',
            'solicitante_email' => 'required|email|max:255',
            'solicitante_telefono' => 'nullable|string|max:40',
            'correos_invitados' => 'nullable|string|max:5000',
            'estado' => 'required|in:pendiente,confirmado,rechazado,cancelado',
            'observaciones_admin' => 'nullable|string|max:2000',
            'comentarios' => 'nullable|string|max:3000',
            'publicado' => 'nullable|boolean',
        ]);
    }

    private function ensureDateAvailable(string $date, string $horaInicio, ?AgendaEvento $evento = null): void
    {
        $queryActivos = AgendaEvento::activos()->whereDate('fecha_evento', $date);

        if ($evento) {
            $queryActivos->where('id', '<>', $evento->id);
        }

        if ($queryActivos->count() >= 2) {
            throw ValidationException::withMessages([
                'fecha_evento' => 'La fecha seleccionada ya tiene el límite máximo de 2 eventos activos alcanzado.',
            ]);
        }

        $queryMismoHorario = AgendaEvento::activos()
            ->whereDate('fecha_evento', $date)
            ->whereTime('hora_inicio', $horaInicio);

        if ($evento) {
            $queryMismoHorario->where('id', '<>', $evento->id);
        }

        if ($queryMismoHorario->exists()) {
            $horarioTexto = $horaInicio === '10:00' ? '10:00 - 11:00 AM' : '01:00 - 02:00 PM';
            throw ValidationException::withMessages([
                'hora_inicio' => "El horario {$horarioTexto} ya está ocupado por otra solicitud activa en esta fecha.",
            ]);
        }
    }

    private function validateAgendaDateAndHours(array &$data): void
    {
        if (AgendaEvento::fechaEsNoLaborable($data['fecha_evento'])) {
            throw ValidationException::withMessages([
                'fecha_evento' => 'Solo se pueden registrar fechas laborales que no sean festivas.',
            ]);
        }

        $horaInicio = substr((string) $data['hora_inicio'], 0, 5);

        if (!in_array($horaInicio, ['10:00', '13:00'], true)) {
            throw ValidationException::withMessages([
                'hora_inicio' => 'Los únicos horarios permitidos son 10:00 - 11:00 AM y 01:00 - 02:00 PM.',
            ]);
        }

        $data['hora_inicio'] = $horaInicio;
        $data['hora_fin'] = $horaInicio === '10:00' ? '11:00' : '14:00';
    }

    private function normalizarHora(?string $hora): ?string
    {
        return $hora ? substr($hora, 0, 5) : $hora;
    }
}
