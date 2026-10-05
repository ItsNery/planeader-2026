<x-app-layout>
    @section('title', 'Detalle de solicitud ' . $evento->folio)

    <div class="container py-3">
        <div class="tarjeta-admin agenda-detail-card p-4 rounded-3 bg-white">
            <div class="form-header py-3 mb-4 agenda-detail-header">
                <div>
                    <h2 class="fw-bold m-0">Detalle de la solicitud</h2>
                    <p class="text-white mb-0 small opacity-75">Folio: <strong>{{ $evento->folio }}</strong></p>
                </div>
                <span class="agenda-status-badge agenda-status-badge--{{ $evento->estado }}">
                    {{ ucfirst($evento->estado) }}
                </span>
            </div>

            <div class="row g-4">
                <div class="col-lg-7">
                    <section class="agenda-detail-section">
                        <div class="custom-section-title">
                            <i class="fa-solid fa-calendar-check text-primary-integration"></i>
                            Información de la actividad
                        </div>
                        <div class="agenda-detail-fields">
                            <div class="agenda-detail-field agenda-detail-field--wide">
                                <span>Tipo de actividad</span><strong>{{ $evento->descripcionTipo() }}</strong>
                            </div>
                            <div class="agenda-detail-field agenda-detail-field--wide">
                                <span>Subcomité</span><strong>{{ $evento->subcomite?->nombre ?: 'No aplica' }}</strong>
                            </div>
                            <div class="agenda-detail-field">
                                <span>Fecha</span><strong>{{ $evento->fecha_evento->translatedFormat('l d \\d\\e F \\d\\e Y') }}</strong>
                            </div>
                            <div class="agenda-detail-field">
                                <span>Hora de inicio</span><strong>{{ $evento->horaInicioFormateada() }} hrs.</strong>
                            </div>
                            <div class="agenda-detail-field">
                                <span>Modalidad</span><strong>{{ ucfirst($evento->modalidad) }}</strong>
                            </div>
                            <div class="agenda-detail-field">
                                <span>Institución organizadora</span><strong>{{ $evento->institucion_organizadora }}</strong>
                            </div>
                            <div class="agenda-detail-field agenda-detail-field--wide">
                                <span>Temática</span><strong>{{ $evento->tematica ?: 'No especificada' }}</strong>
                            </div>
                        </div>
                    </section>

                    <section class="agenda-detail-section mb-lg-0">
                        <div class="custom-section-title">
                            <i class="fa-solid fa-user-tie text-primary-integration"></i>
                            Persona responsable
                        </div>
                        <div class="agenda-detail-fields">
                            <div class="agenda-detail-field"><span>Nombre completo</span><strong>{{ $evento->solicitante_nombre }}</strong></div>
                            <div class="agenda-detail-field"><span>Cargo</span><strong>{{ $evento->solicitante_cargo ?: 'No especificado' }}</strong></div>
                            <div class="agenda-detail-field"><span>Correo electrónico</span><strong><a href="mailto:{{ $evento->solicitante_email }}">{{ $evento->solicitante_email }}</a></strong></div>
                            <div class="agenda-detail-field"><span>Teléfono</span><strong>{{ $evento->solicitante_telefono ?: 'No especificado' }}</strong></div>
                            <div class="agenda-detail-field agenda-detail-field--wide"><span>Correos de invitados</span><strong class="agenda-detail-value--break">{{ $evento->correos_invitados ?: 'No especificados' }}</strong></div>
                        </div>
                    </section>
                </div>

                <div class="col-lg-5">
                    <section class="agenda-detail-section">
                        <div class="custom-section-title">
                            <i class="fa-solid fa-location-dot text-primary-integration"></i>
                            Datos operativos
                        </div>
                        <div class="agenda-detail-fields agenda-detail-fields--single">
                            <div class="agenda-detail-field"><span>Ubicación</span><strong>{{ $evento->ubicacion ?: 'No aplica' }}</strong></div>
                            <div class="agenda-detail-field"><span>Liga de videoconferencia</span><strong>@if($evento->liga_videoconferencia)<a href="{{ $evento->liga_videoconferencia }}" target="_blank" rel="noopener">Abrir videoconferencia</a>@else No capturada @endif</strong></div>
                            <div class="agenda-detail-field"><span>Registro creado</span><strong>{{ $evento->created_at->format('d/m/Y H:i') }}</strong></div>
                            <div class="agenda-detail-field"><span>Visible en calendario público</span><strong>{{ $evento->publicado ? 'Sí' : 'No' }}</strong></div>
                        </div>
                    </section>

                    <section class="agenda-detail-section">
                        <div class="custom-section-title">
                            <i class="fa-solid fa-comments text-primary-integration"></i>
                            Comentarios y seguimiento
                        </div>
                        <div class="agenda-detail-copy">
                            <span>Comentarios del solicitante</span>
                            <p>{{ $evento->comentarios ?: 'Sin comentarios.' }}</p>
                        </div>
                        <div class="agenda-detail-copy">
                            <span>Observaciones administrativas</span>
                            <p>{{ $evento->observaciones_admin ?: 'Sin observaciones.' }}</p>
                        </div>
                    </section>
                </div>
            </div>

            <div class="agenda-detail-actions">
                <a href="{{ route('panel-agenda-eventos.edit', $evento) }}" class="btn btn-custom-primary"><i class="fa-regular fa-pen-to-square me-2"></i>Editar solicitud</a>
                @if ($evento->estado === 'confirmado')
                    <a href="{{ route('agenda-eventos.google-calendar', $evento) }}" target="_blank" rel="noopener noreferrer" class="btn agenda-google-button" title="Agregar a Google Calendar" aria-label="Agregar a Google Calendar"><i class="fa-brands fa-google"></i></a>
                    <a href="{{ route('agenda-eventos.ics', $evento) }}" class="btn btn-outline-primary" title="Descargar archivo ICS"><i class="fa-solid fa-download me-2"></i>Descargar .ics</a>
                @endif
                <a href="{{ route('panel-agenda-eventos.index') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-2"></i>Volver al listado</a>
            </div>
        </div>
    </div>
</x-app-layout>
