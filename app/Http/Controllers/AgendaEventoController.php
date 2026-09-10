<?php

namespace App\Http\Controllers;

use App\Models\AgendaEvento;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon as SupportCarbon;

class AgendaEventoController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_evento' => 'required|in:sesion,mesa_tecnica',
            'subcomite_id' => 'nullable|exists:subcomites,id',
            'tematica' => 'nullable|string|max:255',
            'institucion_organizadora' => 'required|string|max:255',
            'fecha_evento' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio',
            'modalidad' => 'required|in:virtual,presencial',
            'ubicacion' => 'required_if:modalidad,presencial|nullable|string|max:1000',
            'solicitante_nombre' => 'required|string|max:255',
            'solicitante_cargo' => 'nullable|string|max:255',
            'solicitante_email' => 'required|email|max:255',
            'solicitante_telefono' => 'nullable|string|max:40',
            'correos_invitados' => 'nullable|string|max:5000',
            'comentarios' => 'nullable|string|max:3000',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'subcomite_id.exists' => 'El subcomité seleccionado no es válido.',
            'hora_fin.after' => 'La hora de término debe ser posterior a la hora de inicio.',
            'ubicacion.required_if' => 'La ubicación es obligatoria para eventos presenciales.',
            'g-recaptcha-response.required' => 'Por favor, completa el captcha.',
            'g-recaptcha-response.captcha' => 'La validación del captcha falló. Intenta nuevamente.',
        ]);

        $data['solicitante_email'] = Str::lower($data['solicitante_email']);
        $this->validarCorreosInvitados($data['correos_invitados'] ?? null, $data['solicitante_email']);
        $data['correos_invitados'] = $this->normalizarCorreosInvitados($data['correos_invitados'] ?? null, $data['solicitante_email']);
        $this->validateAgendaDateAndHours($data);
        $data['estado'] = 'pendiente';
        $data['publicado'] = true;

        try {
            $agendaEvento = DB::transaction(function () use ($data) {
                $existente = AgendaEvento::whereDate('fecha_evento', $data['fecha_evento'])
                    ->lockForUpdate()
                    ->first();

                if ($existente?->estaActivo()) {
                    throw ValidationException::withMessages([
                        'fecha_evento' => 'La fecha seleccionada ya no está disponible.',
                    ]);
                }

                $data['folio'] = $this->generarFolio();

                if ($existente) {
                    $existente->fill($data);
                    $existente->save();
                    return $existente;
                }

                return AgendaEvento::create($data);
            });
        } catch (QueryException $exception) {
            if ($this->esConflictoDeFecha($exception)) {
                throw ValidationException::withMessages([
                    'fecha_evento' => 'La fecha seleccionada acaba de ser ocupada. Elige otra fecha.',
                ]);
            }

            throw $exception;
        }

        return back()->with('agenda_success', [
            'folio' => $agendaEvento->folio,
            'fecha' => $agendaEvento->fecha_evento->translatedFormat('d \d\e F \d\e Y'),
        ]);
    }

    public function consulta(Request $request)
    {
        $evento = null;

        if ($request->filled('folio')) {
            $request->validate([
                'folio' => 'required|string|max:30',
            ]);

            $evento = AgendaEvento::with('subcomite')
                ->where('folio', Str::upper(trim($request->folio)))
                ->first();
        }

        return view('agenda.consulta', compact('evento'));
    }

    public function googleCalendar(AgendaEvento $agendaEvento)
    {
        abort_unless($agendaEvento->estado === 'confirmado', 404);

        $start = Carbon::parse($agendaEvento->fecha_evento->format('Y-m-d') . ' ' . $agendaEvento->hora_inicio, 'America/Mexico_City');
        $end = $agendaEvento->hora_fin
            ? Carbon::parse($agendaEvento->fecha_evento->format('Y-m-d') . ' ' . $agendaEvento->hora_fin, 'America/Mexico_City')
            : $start->copy()->addHour();

        $details = $agendaEvento->tematica ?: $agendaEvento->descripcionTipo();
        if ($agendaEvento->comentarios) {
            $details .= "\nComentarios: " . $agendaEvento->comentarios;
        }
        if ($agendaEvento->liga_videoconferencia) {
            $details .= "\nLiga de videoconferencia: " . $agendaEvento->liga_videoconferencia;
        }
        $attendees = $this->correosInvitadosComoArray($agendaEvento->correos_invitados);
        $attendees[] = $agendaEvento->solicitante_email;
        $url = 'https://calendar.google.com/calendar/render?' . http_build_query([
            'action' => 'TEMPLATE',
            'text' => $agendaEvento->tituloPublico(),
            'dates' => $start->utc()->format('Ymd\THis\Z') . '/' . $end->utc()->format('Ymd\THis\Z'),
            'details' => $details,
            'location' => $agendaEvento->modalidad === 'presencial' ? $agendaEvento->ubicacion : '',
            'ctz' => 'America/Mexico_City',
            'add' => implode(',', array_unique($attendees)),
            'sf' => 'true',
        ]);

        return redirect()->away($url);
    }

    public function ics(AgendaEvento $agendaEvento)
    {
        abort_unless($agendaEvento->estado === 'confirmado', 404);

        $start = Carbon::parse($agendaEvento->fecha_evento->format('Y-m-d') . ' ' . $agendaEvento->hora_inicio, 'America/Mexico_City');
        $end = $agendaEvento->hora_fin
            ? Carbon::parse($agendaEvento->fecha_evento->format('Y-m-d') . ' ' . $agendaEvento->hora_fin, 'America/Mexico_City')
            : $start->copy()->addHour();
        $description = $agendaEvento->tematica ?: $agendaEvento->descripcionTipo();
        if ($agendaEvento->comentarios) {
            $description .= "\nComentarios: " . $agendaEvento->comentarios;
        }
        if ($agendaEvento->liga_videoconferencia) {
            $description .= "\nLiga de videoconferencia: " . $agendaEvento->liga_videoconferencia;
        }
        $location = $agendaEvento->modalidad === 'presencial' ? $agendaEvento->ubicacion : '';

        $ics = implode("\r\n", [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Planeader//Agenda//ES',
            'BEGIN:VEVENT',
            'UID:' . $agendaEvento->folio . '@planeader.puebla.gob.mx',
            'DTSTAMP:' . now('UTC')->format('Ymd\THis\Z'),
            'DTSTART:' . $start->utc()->format('Ymd\THis\Z'),
            'DTEND:' . $end->utc()->format('Ymd\THis\Z'),
            'SUMMARY:' . $this->icsEscape($agendaEvento->tituloPublico()),
            'DESCRIPTION:' . $this->icsEscape($description),
            'LOCATION:' . $this->icsEscape($location),
            ...array_map(fn ($email) => 'ATTENDEE;CN=' . $this->icsEscape($email) . ';ROLE=REQ-PARTICIPANT:mailto:' . $email, array_unique(array_merge([$agendaEvento->solicitante_email], $this->correosInvitadosComoArray($agendaEvento->correos_invitados)))),
            'END:VEVENT',
            'END:VCALENDAR',
            '',
        ]);

        return response($ics, 200, [
            'Content-Type' => 'text/calendar; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $agendaEvento->folio . '.ics"',
        ]);
    }

    private function generarFolio(): string
    {
        do {
            $folio = 'AG-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (AgendaEvento::where('folio', $folio)->exists());

        return $folio;
    }

    private function esConflictoDeFecha(QueryException $exception): bool
    {
        return str_contains(strtolower($exception->getMessage()), 'fecha_evento');
    }

    private function icsEscape(?string $value): string
    {
        return str_replace(['\\', ';', ',', "\r\n", "\n"], ['\\\\', '\\;', '\\,', '\\n', '\\n'], $value ?? '');
    }

    private function normalizarCorreosInvitados(?string $correos, string $responsable): ?string
    {
        $emails = preg_split('/[\s,;]+/', trim((string) $correos), -1, PREG_SPLIT_NO_EMPTY);
        $validos = collect($emails)
            ->map(fn ($email) => Str::lower(trim($email)))
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->reject(fn ($email) => $email === $responsable)
            ->unique()
            ->values();

        return $validos->isEmpty() ? null : $validos->implode(',');
    }

    private function validarCorreosInvitados(?string $correos, string $responsable): void
    {
        $emails = preg_split('/[\s,;]+/', trim((string) $correos), -1, PREG_SPLIT_NO_EMPTY);
        $invalidos = collect($emails)
            ->map(fn ($email) => trim($email))
            ->filter(fn ($email) => !filter_var($email, FILTER_VALIDATE_EMAIL))
            ->values();

        if ($invalidos->isNotEmpty()) {
            throw ValidationException::withMessages([
                'correos_invitados' => 'Revisa los correos de invitados: ' . $invalidos->implode(', ') . '.',
            ]);
        }
    }

    private function correosInvitadosComoArray(?string $correos): array
    {
        return collect(preg_split('/[\s,;]+/', trim((string) $correos), -1, PREG_SPLIT_NO_EMPTY))
            ->map(fn ($email) => Str::lower(trim($email)))
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values()
            ->all();
    }

    private function validateAgendaDateAndHours(array $data): void
    {
        if (AgendaEvento::fechaEsNoLaborable($data['fecha_evento'])) {
            throw ValidationException::withMessages([
                'fecha_evento' => 'Solo se pueden solicitar fechas laborales que no sean festivas.',
            ]);
        }

        $start = SupportCarbon::createFromFormat('H:i', $data['hora_inicio']);
        $end = !empty($data['hora_fin']) ? SupportCarbon::createFromFormat('H:i', $data['hora_fin']) : null;
        $opening = SupportCarbon::createFromFormat('H:i', '10:00');
        $closing = SupportCarbon::createFromFormat('H:i', '18:00');

        if ($start->lt($opening) || $start->gt($closing) || ($end && ($end->lt($opening) || $end->gt($closing)))) {
            throw ValidationException::withMessages([
                'hora_inicio' => 'El horario permitido es de 10:00 a 18:00 horas.',
            ]);
        }
    }
}
