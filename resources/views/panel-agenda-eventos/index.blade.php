<x-app-layout>
    @section('title', 'Agenda de sesiones y mesas técnicas')
    @if ($message = Session::get('success'))
        <script>document.addEventListener('DOMContentLoaded', () => Swal.fire({ icon: 'success', title: @json($message) }));</script>
    @endif
    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3">
            <h2>Agenda de sesiones y mesas técnicas</h2>
            <p class="text-white mb-0">Administra solicitudes, disponibilidad, datos operativos y ligas virtuales.</p>
        </div>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('panel-agenda-eventos.export') }}" class="btn btn-outline-secondary me-2"><i class="fa-solid fa-file-csv me-1"></i>Exportar contactos</a>
            <a href="{{ route('panel-agenda-eventos.create') }}" class="btn btn-custom-primary">Crear evento</a>
        </div>

        <section id="agenda-admin-calendar" class="agenda-admin-calendar mb-5" aria-labelledby="agenda-admin-calendar-title">
            <div class="agenda-admin-calendar__heading">
                <div>
                    <span class="agenda-admin-calendar__eyebrow"><i class="fa-regular fa-calendar-days me-2"></i>Vista de agenda</span>
                    <h3 id="agenda-admin-calendar-title">{{ ucfirst($fechaBase->isoFormat('MMMM YYYY')) }}</h3>
                </div>
                <div class="agenda-admin-calendar__navigation">
                    <a href="?mes={{ $mesAnterior }}#agenda-admin-calendar" class="btn btn-outline-secondary" title="Mes anterior"><i class="fa-solid fa-chevron-left"></i></a>
                    <a href="?mes={{ now()->format('Y-m') }}#agenda-admin-calendar" class="btn btn-outline-secondary">Hoy</a>
                    <a href="?mes={{ $mesSiguiente }}#agenda-admin-calendar" class="btn btn-outline-secondary" title="Mes siguiente"><i class="fa-solid fa-chevron-right"></i></a>
                </div>
            </div>
            <div class="agenda-admin-calendar__grid">
                @foreach (['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'] as $weekday)
                    <div class="agenda-admin-calendar__weekday">{{ $weekday }}</div>
                @endforeach
                @for ($i = 0; $i < $diaDeLaSemanaInicio; $i++)
                    <div class="agenda-admin-calendar__day agenda-admin-calendar__day--empty"></div>
                @endfor
                @for ($dia = 1; $dia <= $diasEnMes; $dia++)
                    @php $eventosDelDia = $eventosPorDia->get($dia, collect()); @endphp
                    <div class="agenda-admin-calendar__day {{ $eventosDelDia->isNotEmpty() ? 'agenda-admin-calendar__day--has-event' : '' }}">
                        <span class="agenda-admin-calendar__day-number">{{ $dia }}</span>
                        @foreach ($eventosDelDia as $eventoCalendario)
                            <button type="button" class="agenda-admin-calendar__event agenda-admin-calendar__event--{{ $eventoCalendario->estado }}" data-bs-toggle="modal" data-bs-target="#adminAgendaDetailModal-{{ $eventoCalendario->id }}">
                                <span>{{ $eventoCalendario->horaInicioFormateada() }}</span>
                                <strong>{{ $eventoCalendario->tituloPublico() }}</strong>
                            </button>
                        @endforeach
                    </div>
                @endfor
            </div>
        </section>

        @foreach ($eventos as $eventoModal)
            <div class="modal fade agenda-admin-detail-modal" id="adminAgendaDetailModal-{{ $eventoModal->id }}" tabindex="-1" aria-labelledby="adminAgendaDetailModalLabel-{{ $eventoModal->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header"><div><span class="agenda-admin-detail-modal__eyebrow">Folio {{ $eventoModal->folio }}</span><h2 class="modal-title h4" id="adminAgendaDetailModalLabel-{{ $eventoModal->id }}">{{ $eventoModal->tituloPublico() }}</h2></div><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button></div>
                        <div class="modal-body">
                            <div class="agenda-admin-modal-status agenda-status-badge--{{ $eventoModal->estado }}">{{ ucfirst($eventoModal->estado) }}</div>
                            <div class="agenda-detail-fields mt-3">
                                <div class="agenda-detail-field"><span>Fecha</span><strong>{{ $eventoModal->fecha_evento->translatedFormat('l d \\d\\e F \\d\\e Y') }}</strong></div>
                                <div class="agenda-detail-field"><span>Horario</span><strong>{{ $eventoModal->horaInicioFormateada() }}{{ $eventoModal->hora_fin ? ' a ' . substr($eventoModal->hora_fin, 0, 5) : '' }} hrs.</strong></div>
                                <div class="agenda-detail-field"><span>Tipo</span><strong>{{ $eventoModal->descripcionTipo() }}</strong></div>
                                <div class="agenda-detail-field"><span>Modalidad</span><strong>{{ ucfirst($eventoModal->modalidad) }}</strong></div>
                                <div class="agenda-detail-field agenda-detail-field--wide"><span>Subcomité</span><strong>{{ $eventoModal->subcomite?->nombre ?: 'No aplica' }}</strong></div>
                                <div class="agenda-detail-field agenda-detail-field--wide"><span>Temática</span><strong>{{ $eventoModal->tematica ?: 'No especificada' }}</strong></div>
                                <div class="agenda-detail-field"><span>Institución</span><strong>{{ $eventoModal->institucion_organizadora }}</strong></div>
                                <div class="agenda-detail-field"><span>Responsable</span><strong>{{ $eventoModal->solicitante_nombre }}</strong></div>
                                <div class="agenda-detail-field"><span>Correo</span><strong>{{ $eventoModal->solicitante_email }}</strong></div>
                                <div class="agenda-detail-field"><span>Teléfono</span><strong>{{ $eventoModal->solicitante_telefono ?: 'No especificado' }}</strong></div>
                                <div class="agenda-detail-field agenda-detail-field--wide"><span>Correos de invitados</span><strong class="agenda-detail-value--break">{{ $eventoModal->correos_invitados ?: 'No especificados' }}</strong></div>
                                <div class="agenda-detail-field agenda-detail-field--wide"><span>Ubicación</span><strong>{{ $eventoModal->ubicacion ?: 'No aplica' }}</strong></div>
                                <div class="agenda-detail-field agenda-detail-field--wide"><span>Liga de videoconferencia</span><strong>@if($eventoModal->liga_videoconferencia)<a href="{{ $eventoModal->liga_videoconferencia }}" target="_blank" rel="noopener">Abrir videoconferencia</a>@else No capturada @endif</strong></div>
                            </div>
                            <div class="agenda-detail-copy mt-3"><span>Comentarios del solicitante</span><p>{{ $eventoModal->comentarios ?: 'Sin comentarios.' }}</p></div>
                            <div class="agenda-detail-copy mt-3"><span>Observaciones administrativas</span><p>{{ $eventoModal->observaciones_admin ?: 'Sin observaciones.' }}</p></div>
                        </div>
                        <div class="modal-footer"><a href="{{ route('panel-agenda-eventos.edit', $eventoModal) }}" class="btn btn-custom-primary"><i class="fa-regular fa-pen-to-square me-1"></i>Editar</a>@if ($eventoModal->estado === 'confirmado')<a href="{{ route('agenda-eventos.google-calendar', $eventoModal) }}" target="_blank" rel="noopener noreferrer" class="btn agenda-google-button" title="Agregar a Google Calendar" aria-label="Agregar a Google Calendar"><i class="fa-brands fa-google"></i></a><a href="{{ route('agenda-eventos.ics', $eventoModal) }}" class="btn btn-outline-primary" title="Descargar archivo ICS"><i class="fa-solid fa-download"></i></a>@endif<a href="{{ route('panel-agenda-eventos.show', $eventoModal) }}" class="btn btn-outline-secondary">Ver ficha completa</a></div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="table-responsive">
            <table id="myTable" class="table table-hover align-middle w-100">
                <thead class="table-light"><tr><th>Folio</th><th>Evento</th><th>Fecha y hora</th><th>Solicitante</th><th>Estado</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse ($eventos as $evento)
                        <tr>
                            <td><strong>{{ $evento->folio }}</strong></td>
                            <td>{{ $evento->tituloPublico() }}<br><small class="text-muted">{{ $evento->institucion_organizadora }}</small></td>
                            <td>{{ $evento->fecha_evento->translatedFormat('d/m/Y') }}<br><small>{{ substr($evento->hora_inicio, 0, 5) }}</small></td>
                            <td>{{ $evento->solicitante_nombre }}<br><small>{{ $evento->solicitante_email }}</small></td>
                            <td>
                                <span class="badge {{ $evento->estado === 'confirmado' ? 'bg-success' : ($evento->estado === 'pendiente' ? 'bg-warning text-dark' : 'bg-secondary') }}">{{ ucfirst($evento->estado) }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('panel-agenda-eventos.show', $evento) }}" class="btn btn-outline-dark" title="Ver detalle"><i class="fa-regular fa-eye"></i></a>
                                    <a href="{{ route('panel-agenda-eventos.edit', $evento) }}" class="btn btn-outline-secondary" title="Editar"><i class="fa-regular fa-pen-to-square"></i></a>
                                    @if ($evento->estado === 'confirmado')
                                        <a href="{{ route('agenda-eventos.google-calendar', $evento) }}" target="_blank" rel="noopener noreferrer" class="btn agenda-google-button" title="Agregar a Google Calendar" aria-label="Agregar a Google Calendar"><i class="fa-brands fa-google"></i></a>
                                        <a href="{{ route('agenda-eventos.ics', $evento) }}" class="btn btn-outline-primary" title="Descargar ICS"><i class="fa-solid fa-download"></i></a>
                                    @endif
                                    <form action="{{ route('panel-agenda-eventos.destroy', $evento) }}" method="POST" class="formEliminar">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger" title="Eliminar"><i class="fa-regular fa-trash-can"></i></button>
                                    </form>
                                </div>
                                <form action="{{ route('panel-agenda-eventos.status', $evento) }}" method="POST" class="mt-2">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="estado" value="{{ $evento->estado === 'confirmado' ? 'pendiente' : 'confirmado' }}">
                                    <button class="btn btn-sm btn-outline-{{ $evento->estado === 'confirmado' ? 'warning' : 'success' }}">{{ $evento->estado === 'confirmado' ? 'Pasar a pendiente' : 'Confirmar' }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No hay solicitudes registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
