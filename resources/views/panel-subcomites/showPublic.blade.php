@extends('layouts.plantilla')

@section('title', $subcomite->nombre)

@section('meta-description', $subcomite->objetivo ?: 'Lee más sobre el ' . $subcomite->nombre)
@section('canonical-url', url()->current())
@section(
    'keywords',
    $subcomite->nombre .
    ' Subcomité, Subcomités, Planeación Democrática, Plan Estatal de Desarrollo, Puebla, PLANEADER,
    Gobierno, Estado de Puebla, Planeación Democrática, Sistema Estatal, Desarrollo Estatal, Planeación del Desarrollo,
    Gobierno de Puebla, Plan Estatal de Desarrollo, Sistema de Planeación, Planeación en Puebla, Desarrollo en Puebla,
    Política Pública, Gestión Pública, Administración Estatal, Planeación Estratégica, Participación Ciudadana,
    Transparencia, Rendición de Cuentas'
)
@section('og-title', $subcomite->nombre . ' - Sistema Estatal de Planeación Democrática')
@section('og-description', $subcomite->objetivo ?: 'Lee más sobre el ' . $subcomite->nombre)
@section('og:url', url()->current())
@section('og:image', asset('icono_subcomites/' . $subcomite->icono))
@section('twitter-title', $subcomite->nombre . ' - Sistema Estatal de Planeación Democrática')
@section('twitter-description', $subcomite->objetivo ?: 'Lee más sobre el ' . $subcomite->nombre)
@section('twitter:image', asset('icono_subcomites/' . $subcomite->icono))
@section('css')
    {!! NoCaptcha::renderJs() !!}
@endsection
@section('content')
    <section class="subcomite_individual">
        <div class="container pt-5">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-black text-uppercase h6_planeader">
                    Conoce el @if ($subcomite->planestatal->nombre != 'Plan Estatal de Desarrollo 2024-2030')
                        <span class="fw-bold">Archivo Histórico</span> del
                    @endif
                </h6>
                <h2 class="titulo-subcomite text-black pb-3">{{ $subcomite->nombre }}</h2>

                <div class="container flex-container-centro subcomite-icono mb-3">
                    <img src="{{ asset('icono_subcomites/' . $subcomite->icono) }}" alt="">
                </div>

                @if ($subcomite->planestatal->nombre === 'Plan Estatal de Desarrollo 2024-2030')
                    <div class="mt-3">
                        <a href="#fechas-bloqueadas" class="btn btn-outline-color-1">
                            <i class="fa-solid fa-calendar-days me-2"></i> Conoce el Calendario de Subcomités y Mesas
                            Técnicas de Trabajo
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="container py-2 subcomite-ficha-compacta">
            <div class="row align-items-stretch">
                <div class="col-md-4 mb-4 mb-md-0 d-flex flex-column justify-content-start">
                    <div class="py-2 subcomite-titulo-objetivo-unico">
                        <h2 class="titulo-tematica">
                            Objetivo
                        </h2>
                    </div>
                    <div class="subcomite-objetivo-caja-unica flex-grow-1 bg-light p-4 rounded-3 border-start border-4">
                        <p class="mb-0 text-secondary subcomite-objetivo-texto-unico">
                            {{ $subcomite->objetivo }}
                        </p>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="py-2 subcomite-titulo-integracion-unico">
                        <h2 class="titulo-tematica">
                            Integración
                        </h2>
                    </div>
                    <div class="subcomite-integracion-img-unica text-center" data-bs-toggle="modal"
                        data-bs-target="#imagenIntegracionModal">
                        <img src="{{ asset('subcomitesconformacion/' . $subcomite->conformacion) }}"
                            title="Clic para ver en pantalla completa" alt="Integración del {{ $subcomite->nombre }}"
                            class="img-fluid rounded-3 shadow-sm border subcomite-img-responsiva-unica">
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if ($documentosAgrupados->isNotEmpty())
        <section class="historico-subcomite py-2">
            <div class="container">
                <div class="text-center">
                    <h2 class="titulo-tematica pb-3">Documentos</h2>
                </div>
            </div>
            <div class="container">
                <div class="container">
                    <h3 class="text-black text-center pb-3">{{ $subcomite->nombre }}</h3>
                    <div class="accordion" id="accordionDocumentos">
                        @foreach ($documentosAgrupados as $anio => $documentosPorAnio)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $anio }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $anio }}" aria-expanded="false"
                                        aria-controls="collapse{{ $anio }}">
                                        {{ $anio }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $anio }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $anio }}" data-bs-parent="#accordionDocumentos">
                                    <div class="accordion-body">
                                        @foreach ($documentosPorAnio as $tipoDocumento => $documentosPorTipo)
                                            @if ($tipoDocumento === 'Acta')
                                                <h4>
                                                    Actas
                                                </h4>
                                            @elseif ($tipoDocumento === 'Informe')
                                                <h4>
                                                    IAT
                                                </h4>
                                            @elseif ($tipoDocumento === 'Programa')
                                                <h4>
                                                    PAT
                                                </h4>
                                            @else
                                                <h4>
                                                    {{ $tipoDocumento }}
                                                </h4>
                                            @endif
                                            <ul>
                                                @foreach ($documentosPorTipo as $documento)
                                                    <li class="document-item">
                                                        <div class="document-item__main-content">
                                                            <p class="document-item__name">
                                                                {{ $documento->nombre }}
                                                            </p>
                                                            <span class="document-badge badge-pdf">
                                                                {{ strtoupper(pathinfo($documento->ruta_documento, PATHINFO_EXTENSION)) }}
                                                            </span>
                                                        </div>

                                                        <div class="document-item__actions">

                                                            <a href="#" class="js-open-modal"
                                                                data-src="{{ asset('documentosubcomites/' . $documento->ruta_documento) }}"
                                                                data-title="{{ $documento->nombre }} {{ $documento->anio }}"
                                                                title="Ver documento">
                                                                <i class="fas fa-eye"></i> <span>Ver aquí</span>
                                                            </a>
                                                            <a href="{{ asset('documentosubcomites/' . $documento->ruta_documento) }}"
                                                                target="_blank" rel="noopener noreferrer" title="Abrir en nueva pestaña">
                                                                <i class="fas fa-external-link-alt"></i> <span>Abrir</span>
                                                            </a>
                                                            <a href="{{ asset('documentosubcomites/' . $documento->ruta_documento) }}"
                                                                download rel="noopener" title="Descargar documento">
                                                                <i class="fas fa-download"></i>
                                                                <span>Descargar</span>
                                                            </a>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if ($documentosAgrupados->isNotEmpty())
                    @php
                        $ultimaActualizacion = $documentosAgrupados->max('updated_at');
                    @endphp
                    <p class="text-black subcomite-update-text">Última actualización:
                        {{ $ultimaActualizacionDocSubcomite->format('d/m/Y H:i:s') }} UTC
                @else
                        <p class="text-black subcomite-update-text subcomite-update-text--empty">Última actualización:
                            No hay información disponible.</p>
                        <p>
                    @endif
            </div>
        </section>
    @endif

    @if ($subcomite->planestatal->nombre === 'Plan Estatal de Desarrollo 2024-2030')
        <section class="coplademun-agendar py-3">
            <section id="fechas-bloqueadas" class="subcomite-calendar agenda-publica">
                <div class="container">
                    <div class="agenda-publica__heading">
                        <h2 class="titulo-tematica text-center mb-2">
                            Bloquea una fecha en el Calendario de Subcomités y Mesas Técnicas de Trabajo
                        </h2>
                        <p class="text-secondary text-center mb-3">Selecciona una fecha disponible para iniciar la
                            solicitud.
                            Las fechas ocupadas no se pueden seleccionar.</p>
                        <div class="agenda-publica__legend" aria-label="Estados del calendario">
                            <span><i
                                    class="agenda-publica__legend-dot agenda-publica__legend-dot--available"></i>Disponible</span>
                            <span><i class="agenda-publica__legend-dot agenda-publica__legend-dot--event"></i>Evento
                                agendado</span>
                            <span><i class="agenda-publica__legend-dot agenda-publica__legend-dot--off"></i>No
                                laborable</span>
                        </div>
                    </div>
                    @if (session('agenda_success'))
                        <div class="alert alert-success mt-3"><strong>Solicitud recibida.</strong> Tu folio es
                            <strong>{{ session('agenda_success.folio') }}</strong>. La fecha quedó reservada. Consérvalo
                            para
                            consultar el estado.
                        </div>
                    @endif
                </div>
                <div class="container">
                    <div class="subcomite-calendar__wrapper">
                        <a href="?mes={{ $mesAnterior }}#fechas-bloqueadas"
                            class="subcomite-calendar__navigation subcomite-calendar__navigation--desktop" title="Mes anterior">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                        <div class="subcomite-calendar__container">
                            <header class="subcomite-calendar__header">
                                <a href="?mes={{ $mesAnterior }}#fechas-bloqueadas"
                                    class="subcomite-calendar__navigation subcomite-calendar__navigation--mobile">&lt;</a>
                                <h2 class="subcomite-calendar__month">{{ ucfirst($fechaBase->isoFormat('MMMM YYYY')) }}
                                </h2>
                                <a href="?mes={{ $mesSiguiente }}#fechas-bloqueadas"
                                    class="subcomite-calendar__navigation subcomite-calendar__navigation--mobile">&gt;</a>
                            </header>

                            <div class="subcomite-calendar__grid">
                                <div class="subcomite-calendar__weekday">Dom</div>
                                <div class="subcomite-calendar__weekday">Lun</div>
                                <div class="subcomite-calendar__weekday">Mar</div>
                                <div class="subcomite-calendar__weekday">Mié</div>
                                <div class="subcomite-calendar__weekday">Jue</div>
                                <div class="subcomite-calendar__weekday">Vie</div>
                                <div class="subcomite-calendar__weekday">Sáb</div>

                                @for ($i = 0; $i < $diaDeLaSemanaInicio; $i++)
                                    <div class="subcomite-calendar__day subcomite-calendar__day--empty"></div>
                                @endfor

                                @for ($dia = 1; $dia <= $diasEnMes; $dia++)
                                    @php
                                        // Obtenemos la colección de eventos de este día (o una vacía si no hay)
                                        $eventos = $eventosPorDia->get($dia) ?? collect();
                                        $agendaEventos = $agendaEventosPorDia->get($dia) ?? collect();
                                        $fechaAgenda = $fechaBase->copy()->day($dia)->format('Y-m-d');
                                        $fechaAgendaOcupada = $fechasAgendaOcupadas->contains($fechaAgenda);
                                        $fechaNoLaborable = $fechasNoLaborables->contains($fechaAgenda);
                                    @endphp

                                    @php
                                        $fechaDisponible =
                                            !$fechaAgendaOcupada &&
                                            !$fechaNoLaborable &&
                                            $fechaAgenda > now()->format('Y-m-d');
                                    @endphp
                                    <div class="subcomite-calendar__day {{ $eventos->isNotEmpty() || $agendaEventos->isNotEmpty() || $fechaAgendaOcupada ? 'subcomite-calendar__day--has-event' : '' }} {{ $fechaDisponible ? 'agenda-day-available' : '' }} {{ $fechaNoLaborable ? 'agenda-day-unavailable' : '' }}"
                                        @if ($fechaDisponible && $eventos->isEmpty()) data-agenda-date="{{ $fechaAgenda }}"
                                        role="button" tabindex="0" title="Solicitar esta fecha" @endif>
                                        <span class="subcomite-calendar__day-number">{{ $dia }}</span>
                                        @if ($eventos->isNotEmpty())
                                            <div class="subcomite-calendar__events">
                                                @foreach ($eventos->take(2) as $evento)
                                                    <div class="subcomite-calendar__event" data-bs-toggle="modal"
                                                        data-bs-target="#eventDetailModal" data-titulo="{{ $evento->titulo }}"
                                                        data-fecha="{{ Carbon\Carbon::parse($evento->fecha_evento)->isoFormat('dddd, D [de] MMMM, YYYY') }}"
                                                        data-icono="{{ asset('imagen-eventos/' . $evento->icono_evento) }}"
                                                        title="Ver detalles de: {{ $evento->titulo }}">
                                                        <img src="{{ asset('imagen-eventos/' . $evento->icono_evento) }}" alt="Icono"
                                                            class="subcomite-calendar__event-icon">
                                                        <span class="subcomite-calendar__event-title">{{ $evento->titulo }}</span>
                                                    </div>
                                                @endforeach

                                                @if ($eventos->count() > 2)
                                                    <span class="subcomite-calendar__more-events" data-bs-toggle="modal"
                                                        data-bs-target="#dayEventsModal-{{ $dia }}"
                                                        title="Ver los {{ $eventos->count() }} eventos de este día">
                                                        +{{ $eventos->count() - 2 }} más
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                        @if ($agendaEventos->isNotEmpty())
                                            <div class="subcomite-calendar__events">
                                                @foreach ($agendaEventos as $agendaEvento)
                                                    <div class="subcomite-calendar__event agenda-event {{ $agendaEvento->estado === 'pendiente' ? 'agenda-event--pending' : '' }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#agendaEventDetailModal-{{ $agendaEvento->id }}"
                                                        title="Ver detalle del evento">
                                                        @if ($agendaEvento->tipo_evento === 'sesion' && $agendaEvento->subcomite?->icono)
                                                            <img src="{{ asset('icono_subcomites/' . $agendaEvento->subcomite->icono) }}" alt=""
                                                        class="agenda-event__icon">@else<i class="fa-solid fa-calendar-check me-1"></i>
                                                            @endif
                                                        <span class="subcomite-calendar__event-title">
                                                            {{ $agendaEvento->tituloPublico() }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif ($fechaAgendaOcupada)
                                            <div class="subcomite-calendar__events"><span
                                                    class="subcomite-calendar__event-title text-muted">No disponible</span>
                                            </div>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <a href="?mes={{ $mesSiguiente }}#fechas-bloqueadas"
                            class="subcomite-calendar__navigation subcomite-calendar__navigation--desktop"
                            title="Mes siguiente">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </div>
                    <footer class="agenda-calendar-footer">
                        <span class="agenda-calendar-footer__hint"><i class="fa-solid fa-circle-info me-1"></i>¿Ya realizaste una solicitud?</span>
                        <a href="{{ route('agenda-eventos.consulta') }}" class="btn agenda-consulta-button">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>Consultar solicitud
                        </a>
                    </footer>
                </div>

                <div class="container agenda-google-legacy mt-4">
                    <div class="agenda-google-legacy__heading text-center mb-3">
                        <h3 class="titulo-tematica mb-2">O usa también nuestro calendario de Google</h3>
                    </div>
                    <ul class="nav nav-tabs justify-content-center mb-3" id="agendaGoogleTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="agenda-google-subcomites-tab" data-bs-toggle="tab"
                                data-bs-target="#agenda-google-subcomites" type="button" role="tab"
                                aria-controls="agenda-google-subcomites" aria-selected="true">Subcomités</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="agenda-google-mesas-tab" data-bs-toggle="tab"
                                data-bs-target="#agenda-google-mesas" type="button" role="tab"
                                aria-controls="agenda-google-mesas" aria-selected="false">Mesas Técnicas de Trabajo</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="agendaGoogleTabsContent">
                        <div class="tab-pane fade show active" id="agenda-google-subcomites" role="tabpanel"
                            aria-labelledby="agenda-google-subcomites-tab">
                            <iframe
                                src="https://calendar.google.com/calendar/appointments/schedules/AcZssZ3tkB_c4aKhyuWtFztgi_2RM9PvUAESIjPg_c40XMkfxdxrHoppqwAeoKAu4szA-3MKOl_2NlGa?gv=true"
                                class="agenda-google-legacy__iframe" title="Calendario de citas de subcomités" loading="lazy"
                                frameborder="0"></iframe>
                        </div>
                        <div class="tab-pane fade" id="agenda-google-mesas" role="tabpanel"
                            aria-labelledby="agenda-google-mesas-tab">
                            <iframe
                                src="https://calendar.google.com/calendar/appointments/schedules/AcZssZ3tkB_c4aKhyuWtFztgi_2RM9PvUAESIjPg_c40XMkfxdxrHoppqwAeoKAu4szA-3MKOl_2NlGa?gv=true"
                                class="agenda-google-legacy__iframe" title="Calendario de citas de mesas técnicas"
                                loading="lazy" frameborder="0"></iframe>
                        </div>
                    </div>
                </div>

                <div class="modal fade agenda-modal" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="eventDetailModalLabel">Detalles del Evento</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-3">
                                    <img src="" id="modal-event-icon" class="subcomite-calendar__modal-icon"
                                        alt="Icono del evento">
                                </div>
                                <h3 id="modal-event-title" class="text-center mb-3 text-dark"></h3>
                                <p class="text-dark"><strong>Fecha:</strong> <span id="modal-event-date"></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                @for ($dia = 1; $dia <= $diasEnMes; $dia++)
                    @php
                        $eventos = $eventosPorDia->get($dia) ?? collect();
                    @endphp
                    @if ($eventos->count() > 2)
                        <div class="modal fade agenda-modal" id="dayEventsModal-{{ $dia }}" tabindex="-1"
                            aria-labelledby="dayEventsModalLabel-{{ $dia }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="dayEventsModalLabel-{{ $dia }}">
                                            Eventos del
                                            {{ Carbon\Carbon::create($fechaBase->year, $fechaBase->month, $dia)->isoFormat('D [de] MMMM, YYYY') }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-0">
                                        <div class="list-group list-group-flush">
                                            @foreach ($eventos as $evento)
                                                <button type="button"
                                                    class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 border-0"
                                                    data-bs-toggle="modal" data-bs-target="#eventDetailModal" data-bs-dismiss="modal"
                                                    data-titulo="{{ $evento->titulo }}"
                                                    data-fecha="{{ Carbon\Carbon::parse($evento->fecha_evento)->isoFormat('dddd, D [de] MMMM, YYYY') }}"
                                                    data-icono="{{ asset('imagen-eventos/' . $evento->icono_evento) }}">
                                                    <img src="{{ asset('imagen-eventos/' . $evento->icono_evento) }}" alt="Icono"
                                                        class="subcomite-calendar__event-icon subcomite-calendar__event-icon--list">
                                                    <span
                                                        class="subcomite-calendar__event-title subcomite-calendar__event-title--list">{{ $evento->titulo }}</span>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endfor
                @foreach ($agendaEventosPorDia->flatten() as $agendaEvento)
                    <div class="modal fade agenda-modal agenda-detail-modal" id="agendaEventDetailModal-{{ $agendaEvento->id }}"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div><span
                                            class="agenda-modal__eyebrow">{{ $agendaEvento->estado === 'pendiente' ? 'Fecha reservada' : 'Evento confirmado' }}</span>
                                        <h5 class="modal-title">{{ $agendaEvento->tituloPublico() }}</h5>
                                    </div><button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="agenda-detail__icon-wrap">
                                        @if ($agendaEvento->tipo_evento === 'sesion' && $agendaEvento->subcomite?->icono)
                                            <img src="{{ asset('icono_subcomites/' . $agendaEvento->subcomite->icono) }}"
                                                alt="Icono de {{ $agendaEvento->subcomite->nombre }}" class="agenda-detail__icon">
                                        @else
                                            <i class="fa-solid fa-people-group"></i>
                                        @endif
                                    </div>
                                    <div class="agenda-detail-grid">
                                        <div><span class="agenda-detail__label"><i
                                                    class="fa-regular fa-calendar me-1"></i>Fecha</span><strong>{{ $agendaEvento->fecha_evento->translatedFormat('l d \\d\\e F \\d\\e Y') }}</strong>
                                        </div>
                                        <div><span class="agenda-detail__label"><i
                                                    class="fa-regular fa-clock me-1"></i>Horario</span><strong>{{ $agendaEvento->horaInicioFormateada() }}{{ $agendaEvento->hora_fin ? ' a ' . substr($agendaEvento->hora_fin, 0, 5) : '' }}
                                                hrs.</strong></div>
                                    </div>
                                    <div class="agenda-detail__body">
                                        <p><strong>Modalidad:</strong> {{ ucfirst($agendaEvento->modalidad) }}</p>
                                        @if ($agendaEvento->tematica)
                                            <p><strong>Temática :</strong> {{ $agendaEvento->tematica }}</p>
                                        @endif
                                        <p><strong>Institución
                                                organizadora:</strong> {{ $agendaEvento->institucion_organizadora }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>
        </section>

        <div class="modal fade agenda-modal agenda-request-modal" id="agendaRequestModal" tabindex="-1"
            aria-labelledby="agendaRequestModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <div>
                            <h2 class="modal-title h4 mb-1" id="agendaRequestModalLabel">Solicitar una fecha</h2>
                            <p class="text-white small mb-0">La fecha quedará reservada al enviar la solicitud.</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger"><strong>Revisa la solicitud:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('agenda-eventos.store') }}" method="POST" id="agenda-request-form"
                            data-blocked-dates='@json($fechasAgendaOcupadas)'
                            data-non-working-dates='@json($fechasNoLaborables)'>
                            @csrf
                            <div class="agenda-form__intro"><i class="fa-solid fa-circle-info"></i><span>La fecha se
                                    selecciona
                                    desde el calendario. Completa los datos de la actividad y de la persona
                                    responsable.</span>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6"><label class="form-label fw-bold">Tipo de actividad *</label><select
                                        name="tipo_evento" class="form-select" id="agenda-type" required>
                                        <option value="sesion" @selected(old('tipo_evento', 'sesion') === 'sesion')>Sesión de
                                            subcomité</option>
                                        <option value="mesa_tecnica" @selected(old('tipo_evento') === 'mesa_tecnica')>Mesa técnica
                                            de trabajo</option>
                                    </select></div>
                                <div class="col-md-6"><label class="form-label fw-bold">Subcomité</label><select
                                        name="subcomite_id" class="form-select" id="agenda-subcomite">
                                        <option value="">Selecciona un subcomité</option>
                                        @foreach ($subcomitesAgenda as $subcomiteAgenda)
                                            <option value="{{ $subcomiteAgenda->id }}" @selected(old('subcomite_id', $subcomite->id) == $subcomiteAgenda->id)>
                                                {{ $subcomiteAgenda->nombre }}
                                            </option>
                                        @endforeach
                                    </select></div>
                                <div class="col-md-6"><label class="form-label fw-bold" for="agenda-date">Fecha *</label>
                                    <div class="agenda-input-icon"><i class="fa-regular fa-calendar"></i><input type="date"
                                            name="fecha_evento" class="form-control" id="agenda-date"
                                            min="{{ now()->addDay()->format('Y-m-d') }}" value="{{ old('fecha_evento') }}" readonly
                                            required></div>
                                    <div id="agenda-date-warning" class="text-danger small mt-1 d-none">Esta fecha ya está
                                        reservada.</div>
                                </div>
                                <div class="col-md-3"><label class="form-label fw-bold" for="agenda-start">Hora inicio
                                        *</label>
                                    <div class="agenda-input-icon"><i class="fa-regular fa-clock"></i><input type="time"
                                            name="hora_inicio" id="agenda-start" class="form-control" min="10:00" max="18:00"
                                            value="{{ old('hora_inicio', '10:00') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3"><label class="form-label fw-bold" for="agenda-end">Hora fin</label>
                                    <div class="agenda-input-icon"><i class="fa-regular fa-clock"></i><input type="time"
                                            name="hora_fin" id="agenda-end" class="form-control" min="10:00" max="18:00"
                                            value="{{ old('hora_fin') }}"></div>
                                </div>
                                <div class="col-md-6"><label class="form-label fw-bold">Modalidad *</label><select
                                        name="modalidad" class="form-select" id="agenda-modality" required>
                                        <option value="virtual" @selected(old('modalidad', 'virtual') === 'virtual')>Virtual
                                        </option>
                                        <option value="presencial" @selected(old('modalidad') === 'presencial')>Presencial
                                        </option>
                                    </select></div>
                                <div class="col-md-6"><label class="form-label fw-bold">Institución organizadora
                                        *</label><input name="institucion_organizadora" class="form-control"
                                        value="{{ old('institucion_organizadora') }}" required></div>
                                <div class="col-12"><label class="form-label fw-bold">Temática</label><input name="tematica"
                                        class="form-control" value="{{ old('tematica') }}"></div>
                                <div class="col-md-6"><label class="form-label fw-bold">Nombre de la persona responsable
                                        *</label><input name="solicitante_nombre" class="form-control"
                                        value="{{ old('solicitante_nombre') }}" required></div>
                                <div class="col-md-6"><label class="form-label fw-bold">Cargo</label><input
                                        name="solicitante_cargo" class="form-control" value="{{ old('solicitante_cargo') }}">
                                </div>
                                <div class="col-md-6"><label class="form-label fw-bold">Correo electrónico *</label><input
                                        type="email" name="solicitante_email" class="form-control"
                                        value="{{ old('solicitante_email') }}" required></div>
                                <div class="col-md-6"><label class="form-label fw-bold">Teléfono</label><input
                                        name="solicitante_telefono" class="form-control"
                                        value="{{ old('solicitante_telefono') }}"></div>
                                <div class="col-12"><label class="form-label fw-bold">Correos de invitados</label>
                                    <textarea name="correos_invitados" class="form-control" rows="2"
                                        placeholder="Uno por línea o separados por coma">{{ old('correos_invitados') }}</textarea>
                                    <div class="form-text">Se incluirán al exportar el evento a Google Calendar.</div>
                                </div>
                                <div class="col-12 d-none" id="agenda-location-field"><label
                                        class="form-label fw-bold">Ubicación *</label><input name="ubicacion"
                                        class="form-control" value="{{ old('ubicacion') }}"></div>
                                <div class="col-12"><label class="form-label fw-bold">Comentarios</label>
                                    <textarea name="comentarios" class="form-control" rows="3" maxlength="3000"
                                        placeholder="Información adicional para revisar la solicitud">{{ old('comentarios') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <div class="agenda-captcha">{!! NoCaptcha::display() !!}</div>
                                    @error('g-recaptcha-response')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="agenda-form__actions"><button class="btn btn-outline-color-1" type="button"
                                    data-bs-dismiss="modal">Cancelar</button><button class="btn agenda-btn-primary"
                                    type="submit" id="agenda-submit">Enviar
                                    solicitud</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de Imagen de Integración (Lightbox) -->
    <div class="modal fade" id="imagenIntegracionModal" tabindex="-1" aria-labelledby="imagenIntegracionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-header border-0 p-0 position-relative">
                    <button type="button"
                        class="btn-close btn-close-white position-absolute top-0 end-0 m-3 subcomite-lightbox-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center">
                    <img src="{{ asset('subcomitesconformacion/' . $subcomite->conformacion) }}"
                        alt="Integración de {{ $subcomite->nombre }}"
                        class="img-fluid rounded shadow-lg subcomite-lightbox-image">
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const agendaForm = document.getElementById('agenda-request-form');
            if (agendaForm) {
                const blockedDates = JSON.parse(agendaForm.dataset.blockedDates || '[]');
                const nonWorkingDates = JSON.parse(agendaForm.dataset.nonWorkingDates || '[]');
                const dateInput = document.getElementById('agenda-date');
                const warning = document.getElementById('agenda-date-warning');
                const submit = document.getElementById('agenda-submit');
                const modality = document.getElementById('agenda-modality');
                const locationField = document.getElementById('agenda-location-field');
                const locationInput = locationField.querySelector('input');
                const eventType = document.getElementById('agenda-type');
                const subcomiteInput = document.getElementById('agenda-subcomite');
                 const agendaModalElement = document.getElementById('agendaRequestModal');
                 const agendaModal = agendaModalElement ? bootstrap.Modal.getOrCreateInstance(agendaModalElement) :
                     null;
                 const startTimeInput = document.getElementById('agenda-start');
                 const endTimeInput = document.getElementById('agenda-end');
                 const normalizeAgendaHours = () => {
                     if (!startTimeInput.value || startTimeInput.value < '10:00') {
                         startTimeInput.value = '10:00';
                     }
                     if (endTimeInput.value && endTimeInput.value < '10:00') {
                         endTimeInput.value = '';
                     }
                 };
                const refreshDate = () => {
                    const blocked = blockedDates.includes(dateInput.value);
                    const nonWorking = nonWorkingDates.includes(dateInput.value);
                    warning.textContent = nonWorking ? 'Esta fecha no es laborable.' :
                        'Esta fecha ya está reservada.';
                    warning.classList.toggle('d-none', !blocked && !nonWorking);
                    submit.disabled = blocked || nonWorking;
                };
                const refreshModality = () => {
                    const presencial = modality.value === 'presencial';
                    locationField.classList.toggle('d-none', !presencial);
                    locationInput.required = presencial;
                };
                dateInput.addEventListener('change', refreshDate);
                modality.addEventListener('change', refreshModality);
                const refreshSubcomite = () => {
                    subcomiteInput.disabled = eventType.value !== 'sesion';
                    subcomiteInput.required = eventType.value === 'sesion';
                    if (eventType.value !== 'sesion') subcomiteInput.value = '';
                };
                eventType.addEventListener('change', refreshSubcomite);
                document.querySelectorAll('[data-agenda-date]').forEach((day) => {
                     const openRequest = () => {
                         dateInput.value = day.dataset.agendaDate;
                         normalizeAgendaHours();
                         refreshDate();
                         agendaModal?.show();
                    };
                    day.addEventListener('click', openRequest);
                    day.addEventListener('keydown', (event) => {
                        if (event.key === 'Enter' || event.key === ' ') {
                            event.preventDefault();
                            openRequest();
                        }
                    });
                });
                 refreshModality();
                 refreshSubcomite();
                 normalizeAgendaHours();
                 refreshDate();
                @if ($errors->any())
                    agendaModal?.show();
                @endif
                }

            @if (session('agenda_success'))
                const agendaCalendar = document.getElementById('fechas-bloqueadas');
                if (agendaCalendar) {
                    window.setTimeout(() => {
                        agendaCalendar.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        window.history.replaceState({}, document.title, '#fechas-bloqueadas');
                    }, 250);
                }
            @endif

                var eventDetailModal = document.getElementById('eventDetailModal');

            eventDetailModal.addEventListener('show.bs.modal', function (event) {
                // Botón o elemento que activó el modal
                var triggerElement = event.relatedTarget;

                // Extraer la información de los atributos data-*
                var titulo = triggerElement.getAttribute('data-titulo');
                var fecha = triggerElement.getAttribute('data-fecha');
                var icono = triggerElement.getAttribute('data-icono');

                // Seleccionar los elementos dentro del modal
                var modalTitle = eventDetailModal.querySelector('#modal-event-title');
                var modalDate = eventDetailModal.querySelector('#modal-event-date');
                var modalIcon = eventDetailModal.querySelector('#modal-event-icon');

                // Actualizar el contenido del modal
                modalTitle.textContent = titulo;
                modalDate.textContent = fecha;
                modalIcon.src = icono;
            });
        });
    </script>
@endsection
