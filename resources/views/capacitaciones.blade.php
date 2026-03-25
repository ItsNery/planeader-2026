@extends('layouts.plantilla')
@section('title', 'Capacitaciones del COPLADEMUN')
@section('meta-description',
    'Página donde se encontrarán los documentos de las capacitaciones del Comité de Planeación
    Municipal del Sistema Estatal de Planeación Democrática del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'COPLADEMUN:Capacitaciones - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Bienvenido a la página donde se encontrarán los documentos de las capacitaciones del Comité
    de Planeación Municipal del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'COPLADEMUN:Capacitaciones - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Bienvenido a la página donde se encontrarán los documentos de las capacitaciones del
    Comité de Planeación Municipal del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('css')
@endsection

@section('content')
    <section class="contenedor-imagen-capacitaciones">
        <h1>Capacitación municipal</h1>
    </section>
    <section class="capacitaciones">
        <div class="container py-5">
            <div class="col">
                <div class="text-center mb-3 pb-3">
                    <p class="text-black pt-3">
                        Herramientas de apoyo técnico y metodológico para la integración de documentos municipales en
                        materia de evaluación y planeación.
                    </p>
                </div>
            </div>
            <div class="accordion" id="mainAccordion">

                {{-- Verificamos si hay capacitaciones, si no, mostramos un mensaje --}}
                @forelse ($capacitaciones as $capacitacion)

                    {{-- INICIO DE UN ITEM DEL ACORDEÓN PRINCIPAL --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-{{ $capacitacion->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{ $capacitacion->id }}" aria-expanded="false"
                                aria-controls="collapse-{{ $capacitacion->id }}">

                                {{-- Usamos el nombre de la capacitación desde la base de datos --}}
                                {{ $capacitacion->nombre }}

                            </button>
                        </h2>
                        <div id="collapse-{{ $capacitacion->id }}" class="accordion-collapse collapse"
                            aria-labelledby="heading-{{ $capacitacion->id }}" data-bs-parent="#mainAccordion">
                            <div class="accordion-body">

                                {{-- Mostramos la imagen principal del programa --}}
                                <div class="text-center mb-4">
                                    <img src="{{ asset('documentos/capacitacion-municipal/' . $capacitacion->imagen_programa) }}"
                                        alt="Programa de {{ $capacitacion->nombre }}" class="img-fluid">
                                </div>

                                {{-- Verificamos si esta capacitación tiene documentos antes de mostrar el acordeón anidado --}}
                                @if ($capacitacion->documentos->isNotEmpty())
                                    <div class="accordion" id="nestedAccordion-{{ $capacitacion->id }}">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="nestedHeading-{{ $capacitacion->id }}">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#nestedCollapse-{{ $capacitacion->id }}"
                                                    aria-expanded="false"
                                                    aria-controls="nestedCollapse-{{ $capacitacion->id }}">
                                                    Documentos
                                                </button>
                                            </h2>
                                            <div id="nestedCollapse-{{ $capacitacion->id }}"
                                                class="accordion-collapse collapse"
                                                aria-labelledby="nestedHeading-{{ $capacitacion->id }}"
                                                data-bs-parent="#nestedAccordion-{{ $capacitacion->id }}">
                                                <div class="accordion-body">

                                                    @php
                                                        // Agrupamos los documentos por el campo 'dia_agrupador'
                                                        // Esto nos dará un array donde la clave es el día (1, 2, 3, o '' para los generales)
                                                        $documentosAgrupados = $capacitacion->documentos->groupBy(
                                                            'dia_agrupador',
                                                        );
                                                    @endphp

                                                    {{-- Iteramos sobre cada grupo de día --}}
                                                    @foreach ($documentosAgrupados as $dia => $documentosDelDia)
                                                        {{-- Si la clave 'dia' no está vacía, mostramos el título del día --}}
                                                        @if ($dia)
                                                            <h4>Día {{ $dia }}</h4>
                                                        @endif

                                                        <ul class="document-list">
                                                            {{-- Iteramos sobre los documentos de este día en específico --}}
                                                            @foreach ($documentosDelDia as $documento)
                                                                <li class="document-item">
                                                                    <div class="document-item__main-content">
                                                                        <p class="document-item__name">
                                                                            {{ $documento->nombre_display }}
                                                                        </p>
                                                                        {{-- Opcional: Podríamos generar la etiqueta del formato dinámicamente --}}
                                                                        <span
                                                                            class="document-badge badge-pdf">{{ strtoupper(pathinfo($documento->ruta_archivo, PATHINFO_EXTENSION)) }}</span>
                                                                    </div>
                                                                    <div class="document-item__actions">
                                                                        <a href="#" class="js-open-modal"
                                                                            data-src="{{ asset('documentos/capacitacion-municipal/' . $documento->ruta_archivo) }}"
                                                                            data-title="{{ $documento->nombre_display }}"
                                                                            title="Ver documento">
                                                                            <i class="fas fa-eye"></i> <span>Ver aquí</span>
                                                                        </a>
                                                                        <a href="{{ asset('documentos/capacitacion-municipal/' . $documento->ruta_archivo) }}" target="_blank"
                                                                            rel="noopener noreferrer" title="Abrir en nueva pestaña">
                                                                            <i class="fas fa-external-link-alt"></i> <span>Abrir</span>
                                                                        </a>
                                                                        <a href="{{ asset('documentos/capacitacion-municipal/' . $documento->ruta_archivo) }}"
                                                                            download rel="noopener"
                                                                            title="Descargar documento">
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
                                    </div>
                                @else
                                    <p class="text-center text-muted mt-4">No hay documentos disponibles para esta
                                        capacitación.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- FIN DE UN ITEM DEL ACORDEÓN PRINCIPAL --}}

                @empty
                    {{-- Esto se muestra si la variable $capacitaciones está vacía --}}
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            Actualmente no hay programas de capacitación disponibles.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        <div id="myModal" class="modal-planeader">
            <div class="modal-content">
                <button class="close-btn" aria-label="Cerrar">
                    &times;
                </button>
                <h2 id="modalTitle"></h2>
                <iframe class="w-100 h-100" id="modalIframe" src=""></iframe>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        /**
         * Función mejorada para cerrar el modal.
         * Limpia el iframe para detener la carga y liberar recursos.
         */
        function closeModal() {
            const modal = document.getElementById('myModal');
            if (modal) {
                modal.style.display = 'none';
            }

            const modalIframe = document.getElementById('modalIframe');
            if (modalIframe) {
                modalIframe.src = ''; // ¡Importante!
            }
        }

        // Se ejecuta cuando la página ha cargado completamente.
        document.addEventListener('DOMContentLoaded', function() {

            // --- Referencias a los elementos del DOM ---
            const modal = document.getElementById('myModal');
            const modalIframe = document.getElementById('modalIframe');
            const modalTitle = document.getElementById('modalTitle');
            const closeButton = document.querySelector('#myModal .close-btn');

            // --- Lógica para ABRIR el modal (con delegación de eventos) ---
            document.addEventListener('click', function(event) {

                // Revisa si el elemento clickeado es un enlace para abrir el modal
                const openTrigger = event.target.closest('.js-open-modal');

                if (openTrigger) {
                    event.preventDefault(); // Evita que el enlace '#' navegue

                    // Obtiene la info desde los data-attributes
                    const docUrl = openTrigger.dataset.src;
                    const docTitle = openTrigger.dataset.title;

                    if (docUrl) {
                        modalTitle.textContent = docTitle;
                        modalIframe.src = docUrl;
                        modal.style.display = 'block';
                    }
                }
            });

            // --- Lógica para CERRAR el modal (todas las opciones) ---
            if (closeButton) {
                closeButton.addEventListener('click', closeModal);
            }

            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && modal.style.display === 'block') {
                    closeModal();
                }
            });
        });
    </script>
@endsection
