@extends('layouts.plantilla')

@section('title', 'Consultar solicitud de agenda')

@section('content')
    <section class="agenda-consulta-page container py-5">
        <div class="agenda-consulta-page__heading text-center mb-4">
            <span class="agenda-publica__eyebrow"><i class="fa-solid fa-magnifying-glass me-2"></i>Seguimiento</span>
            <h1 class="titulo-tematica">Consultar solicitud</h1>
            <p>Ingresa el folio para consultar la información completa de tu solicitud.</p>
        </div>

        <form method="GET" action="{{ route('agenda-eventos.consulta') }}" class="agenda-consulta-form mb-5">
            <div class="agenda-consulta-form__field">
                <label for="folio">Folio de solicitud</label>
                <input id="folio" name="folio" class="form-control" value="{{ request('folio') }}" required placeholder="AG-20260812-ABC123">
            </div>
            <button class="btn agenda-btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass me-2"></i>Consultar</button>
        </form>

        @if (request()->filled('folio'))
            @if ($evento)
                <article class="agenda-public-detail">
                    <header class="agenda-public-detail__header">
                        <div>
                            <span class="agenda-public-detail__eyebrow">Folio {{ $evento->folio }}</span>
                            <h2>{{ $evento->tituloPublico() }}</h2>
                        </div>
                        <span class="agenda-public-detail__status agenda-public-detail__status--{{ $evento->estado }}">{{ ucfirst($evento->estado) }}</span>
                    </header>

                    <div class="row g-4 p-4">
                        <div class="col-lg-7">
                            <section class="agenda-public-detail__section">
                                <div class="agenda-public-detail__section-title"><i class="fa-solid fa-calendar-check"></i>Información de la actividad</div>
                                <div class="agenda-public-detail__fields">
                                    <div class="agenda-public-detail__field agenda-public-detail__field--wide"><span>Tipo de actividad</span><strong>{{ $evento->descripcionTipo() }}</strong></div>
                                    <div class="agenda-public-detail__field agenda-public-detail__field--wide"><span>Subcomité</span><strong>{{ $evento->subcomite?->nombre ?: 'No aplica' }}</strong></div>
                                    <div class="agenda-public-detail__field"><span>Fecha</span><strong>{{ $evento->fecha_evento->translatedFormat('l d \\d\\e F \\d\\e Y') }}</strong></div>
                                    <div class="agenda-public-detail__field"><span>Horario</span><strong>{{ $evento->horaInicioFormateada() }}{{ $evento->hora_fin ? ' a ' . substr($evento->hora_fin, 0, 5) : '' }} hrs.</strong></div>
                                    <div class="agenda-public-detail__field"><span>Modalidad</span><strong>{{ ucfirst($evento->modalidad) }}</strong></div>
                                    <div class="agenda-public-detail__field"><span>Institución organizadora</span><strong>{{ $evento->institucion_organizadora }}</strong></div>
                                    <div class="agenda-public-detail__field agenda-public-detail__field--wide"><span>Temática</span><strong>{{ $evento->tematica ?: 'No especificada' }}</strong></div>
                                </div>
                            </section>

                            <section class="agenda-public-detail__section mb-lg-0">
                                <div class="agenda-public-detail__section-title"><i class="fa-solid fa-user-tie"></i>Persona responsable</div>
                                <div class="agenda-public-detail__fields">
                                    <div class="agenda-public-detail__field"><span>Nombre completo</span><strong>{{ $evento->solicitante_nombre }}</strong></div>
                                    <div class="agenda-public-detail__field"><span>Cargo</span><strong>{{ $evento->solicitante_cargo ?: 'No especificado' }}</strong></div>
                                    <div class="agenda-public-detail__field"><span>Correo electrónico</span><strong>{{ $evento->solicitante_email }}</strong></div>
                                    <div class="agenda-public-detail__field"><span>Teléfono</span><strong>{{ $evento->solicitante_telefono ?: 'No especificado' }}</strong></div>
                                    <div class="agenda-public-detail__field agenda-public-detail__field--wide"><span>Correos de invitados</span><strong class="agenda-public-detail__break">{{ $evento->correos_invitados ?: 'No especificados' }}</strong></div>
                                </div>
                            </section>
                        </div>

                        <div class="col-lg-5">
                            <section class="agenda-public-detail__section">
                                <div class="agenda-public-detail__section-title"><i class="fa-solid fa-location-dot"></i>Datos operativos</div>
                                <div class="agenda-public-detail__fields agenda-public-detail__fields--single">
                                    <div class="agenda-public-detail__field"><span>Ubicación</span><strong>{{ $evento->ubicacion ?: 'No aplica' }}</strong></div>
                                    <div class="agenda-public-detail__field"><span>Liga de videoconferencia</span><strong>@if ($evento->liga_videoconferencia)<a href="{{ $evento->liga_videoconferencia }}" target="_blank" rel="noopener noreferrer">Abrir videoconferencia</a>@else No capturada @endif</strong></div>
                                </div>
                            </section>

                            <section class="agenda-public-detail__section mb-lg-0">
                                <div class="agenda-public-detail__section-title"><i class="fa-solid fa-comments"></i>Comentarios</div>
                                <div class="agenda-public-detail__copy">{{ $evento->comentarios ?: 'Sin comentarios.' }}</div>
                            </section>
                        </div>
                    </div>
                </article>
            @else
                <div class="alert alert-warning agenda-consulta-empty text-center">No encontramos una solicitud con ese folio.</div>
            @endif
        @endif
    </section>
@endsection
