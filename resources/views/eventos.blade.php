@extends('componentes.plantilla')
@section('title', 'Noticias')
@section('meta-description', 'Últimas noticias sobre la implementación de la Agenda 2030 en el Estado de Puebla.')
@section('keywords',
    'Noticias, Agenda 2030, Estado de Puebla, Implementación de la Agenda 2030, Desarrollo Sostenible,
    Actualizaciones, Información, Gobierno de Puebla, Proyectos Sostenibles, Eventos, Comunicados, Innovación, Medio
    Ambiente, Economía, Sociedad, Políticas Públicas, Reportes, Avances, Noticias Recientes, Noticias de Desarrollo')
@section('canonical-url', url()->current())
@section('og-title', 'Noticias - Agenda 2030 Puebla')
@section('og-description', 'Últimas noticias sobre la implementación de la Agenda 2030 en el Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'Noticias - Agenda 2030 Puebla')
@section('twitter-description', 'Últimas noticias sobre la implementación de la Agenda 2030 en el Estado de Puebla.')
@section('css')
@endsection
@section('jss')
@endsection
@section('content')
    <section class="contenedor-imagen-noticias">
        <h1>
            Noticias y eventos
        </h1>
    </section>
    <section class="inicio-eventos">
        <div class="container py-5">
            <h2 class="titulo-tematica">
                Eventos
            </h2>
        </div>
        <div class="container">
            <div class="calendar-wrapper">
                <a href="?mes={{ $mesAnterior }}" class="calendar-nav-arrow desktop-arrow prev" title="Mes anterior">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
                <div class="calendar-container">
                    <header class="calendar-header">
                        <a href="?mes={{ $mesAnterior }}" class="nav-arrow mobile-arrow">&lt;</a>
                        <h2 class="current-month">{{ ucfirst($fechaBase->isoFormat('MMMM YYYY')) }}</h2>
                        <a href="?mes={{ $mesSiguiente }}" class="nav-arrow mobile-arrow">&gt;</a>
                    </header>

                    <div class="calendar-grid">
                        <div class="weekday-header">Dom</div>
                        <div class="weekday-header">Lun</div>
                        <div class="weekday-header">Mar</div>
                        <div class="weekday-header">Mié</div>
                        <div class="weekday-header">Jue</div>
                        <div class="weekday-header">Vie</div>
                        <div class="weekday-header">Sáb</div>

                        @for ($i = 0; $i < $diaDeLaSemanaInicio; $i++)
                            <div class="day-cell empty"></div>
                        @endfor

                        @for ($dia = 1; $dia <= $diasEnMes; $dia++)
                            @php
                                $evento = $eventosPorDia->get($dia);
                            @endphp
                            <div class="day-cell {{ $evento ? 'has-event' : '' }}">
                                <span class="day-number">{{ $dia }}</span>

                                @if ($evento)
                                    <div class="event-marker" data-bs-toggle="modal" data-bs-target="#eventDetailModal"
                                        data-titulo="{{ $evento->titulo }}"
                                        data-fecha="{{ Carbon\Carbon::parse($evento->fecha_evento)->isoFormat('dddd, D [de] MMMM, YYYY') }}"
                                        data-icono="{{ asset('imagen-eventos/' . $evento->icono_evento) }}"
                                        title="Ver detalles de: {{ $evento->titulo }}">

                                        <img src="{{ asset('imagen-eventos/' . $evento->icono_evento) }}" alt="Icono"
                                            class="event-marker-icon">
                                        <span class="event-marker-title">{{ $evento->titulo }}</span>
                                    </div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
                <a href="?mes={{ $mesSiguiente }}" class="calendar-nav-arrow desktop-arrow next" title="Mes siguiente">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>
        </div>
        <div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventDetailModalLabel">Detalles del Evento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <img src="" id="modal-event-icon" alt="Icono del evento" style="max-width: 80px;">
                        </div>
                        <h3 id="modal-event-title" class="text-center mb-3"></h3>
                        <p><strong>Fecha:</strong> <span id="modal-event-date"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var eventDetailModal = document.getElementById('eventDetailModal');

            eventDetailModal.addEventListener('show.bs.modal', function(event) {
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
