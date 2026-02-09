@extends('layouts.plantilla')

@section('title', $subcomite->nombre)

@section('meta-description', $subcomite->objetivo ?: 'Lee más sobre el ' . $subcomite->nombre)
@section('canonical-url', url()->current())
@section('keywords',
    $subcomite->nombre .
    ' Subcomité, Subcomités, Planeación Democrática, Plan Estatal de Desarrollo, Puebla, PLANEADER,
    Gobierno, Estado de Puebla, Planeación Democrática, Sistema Estatal, Desarrollo Estatal, Planeación del Desarrollo,
    Gobierno de Puebla, Plan Estatal de Desarrollo, Sistema de Planeación, Planeación en Puebla, Desarrollo en Puebla,
    Política Pública, Gestión Pública, Administración Estatal, Planeación Estratégica, Participación Ciudadana,
    Transparencia, Rendición de Cuentas')
@section('og-title', $subcomite->nombre . ' - Sistema Estatal de Planeación Democrática')
@section('og-description', $subcomite->objetivo ?: 'Lee más sobre el ' . $subcomite->nombre)
@section('og:url', url()->current())
@section('og:image', asset('icono_subcomites/' . $subcomite->icono))
@section('twitter-title', $subcomite->nombre . ' - Sistema Estatal de Planeación Democrática')
@section('twitter-description', $subcomite->objetivo ?: 'Lee más sobre el ' . $subcomite->nombre)
@section('twitter:image', asset('icono_subcomites/' . $subcomite->icono))

@section('css')
@endsection
@section('content')
    <main id="#" class="">
        <section class="subcomite_individual">
            <div class="container pt-5">
                <div class="text-center mb-3 pb-3">
                    <h6 class="text-black text-uppercase h6_planeader">
                        Conoce el @if ($subcomite->plan_estatal != 'Plan Estatal de Desarrollo 2024-2030')
                            <span class="fw-bold">Archivo Histórico</span> del
                        @endif
                    </h6>
                    <h2 class="titulo-subcomite text-black pb-3">{{ $subcomite->nombre }}</h2>
                    <div class="container flex-container-centro subcomite-icono">
                        <img src="{{ asset('icono_subcomites/' . $subcomite->icono) }}" alt="">
                    </div>
                </div>
            </div>
            <div class="container py-2 ficha-subcomite">
                <div class="container">
                    <div class="py-3 subcomite-titulo-objetivo">
                        <h2 class="titulo-tematica">
                            Objetivo
                        </h2>
                    </div>
                    <div class="objetivo">
                        <p>
                            {{ $subcomite->objetivo }}
                        </p>
                    </div>
                </div>
                <div class="container">
                    <div class="py-3 integracion-titulo-subcomite">
                        <h2 class="titulo-tematica">
                            Integración
                        </h2>
                    </div>
                    <div class="integracion-imagen-subcomite">
                        <img src="{{ asset('subcomitesconformacion/' . $subcomite->conformacion) }}"
                            title="Integración del {{ $subcomite->nombre }}" alt="Integración del {{ $subcomite->nombre }}"
                            width="100%">
                    </div>
                </div>
            </div>
        </section>
        <section class="historico-subcomite py-2">
            <div class="container">
                <div class="text-center">
                    <h2 class="titulo-tematica pb-3">Documentos</h2>
                </div>
            </div>
            <div class="container">
                <div id="myModal" class="modal-planeader">
                    <div class="modal-content">
                        <button class="close-btn" aria-label="Cerrar">&times;</button>
                        <h3 class="text-center" id="modalTitle"></h3>
                        <iframe id="modalIframe" src="" width="100%" height="100%"></iframe>
                    </div>
                </div>
                @if ($documentosAgrupados->isEmpty())
                    <div class="container"
                        style="display: flex; justify-content:center; align-items:center; flex-direction:column">
                        <img src="{{ asset('imagen/no-file.png') }}" alt="Imagen de Not Found" title="Imagen de Not Found"
                            style="width: 40%">
                        <p class="text-black text-center pb-5">Upps, no se encontraron documentos.</p>
                    </div>
                @else
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

                                                                <a href="#" class="open-modal"
                                                                    data-src="{{ asset('documentosubcomites/' . $documento->ruta_documento) }}"
                                                                    data-title="{{ $documento->nombre }} {{ $documento->anio }}"
                                                                    title="Ver documento">
                                                                    <i class="fas fa-eye"></i> <span>Ver</span>
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
                @endif
                <!-- Suponiendo que $documentos es una colección de documentos de COPLADEP obtenidos de tu base de datos -->
                @if ($documentosAgrupados->isNotEmpty())
                    <!-- Itera sobre los documentos y obtén la fecha de actualización más reciente -->
                    @php
                        $ultimaActualizacion = $documentosAgrupados->max('updated_at');
                    @endphp
                    <!-- Muestra la leyenda con la fecha de la última actualización -->
                    <p class="text-black" style="font-size: 10px">Última actualización:
                        {{-- {{ $ultimaActualizacion->format('d/m/Y H:i:s') }}</p> --}}
                        {{ $ultimaActualizacionDocSubcomite->format('d/m/Y H:i:s') }} UTC
                    @else
                    <p class="text-black" style="font-size: 10px; margin-bottom:inherit">Última actualización:
                        No hay información disponible.</p>
                    <p>
                @endif
            </div>
        </section>
        <section class="coplademun-agendar py-4">
            <div class="col py-4">
                <div class="text-center mb-3 pb-3">
                    <h6 class="text-dark text-uppercase h6_planeader">¿Gustas agendar una cita para tu sesión de Subcomité?
                    </h6>
                    <h2 class="subtitulo_sitios text-dark">
                        Usa nuestro calendario
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    <div class="container">
                        <iframe
                            src="https://calendar.google.com/calendar/appointments/schedules/AcZssZ3tkB_c4aKhyuWtFztgi_2RM9PvUAESIjPg_c40XMkfxdxrHoppqwAeoKAu4szA-3MKOl_2NlGa?gv=true"
                            style="border: 0" width="100%" height="900" frameborder="0"></iframe>
                    </div>
                </div>
                <div class="col-md-3">
                </div>
            </div>
        </section>
    </main>
@endsection
@section('scripts')
    <script>
        /**
         * Función para cerrar el modal.
         */
        function closeModal() {
            const modal = document.getElementById('myModal');
            if (modal) {
                modal.style.display = 'none';
            }

            const modalIframe = document.getElementById('modalIframe');
            if (modalIframe) {
                // Limpia la URL del iframe para detener contenido y liberar recursos.
                modalIframe.src = '';
            }
        }

        // Se ejecuta cuando todo el contenido del DOM ha sido cargado.
        document.addEventListener('DOMContentLoaded', function() {

            // --- Referencias a los elementos del DOM ---
            const modal = document.getElementById('myModal');
            const modalIframe = document.getElementById('modalIframe');
            const modalTitle = document.getElementById('modalTitle');
            const openModalLinks = document.querySelectorAll('.open-modal');
            // Asumimos que tu botón de cierre tiene la clase 'close-btn' como en los ejemplos anteriores
            const closeButton = document.querySelector('#myModal .close-btn');

            // --- Lógica para ABRIR el modal ---
            openModalLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const src = this.dataset.src;
                    const title = this.dataset.title;

                    if (src) {
                        modalIframe.src = src;
                        modalTitle.textContent = title;
                        modal.style.display = 'block';
                    }
                });
            });

            // --- Lógica para CERRAR el modal (todas las opciones) ---

            // 1. Clic en el botón de cierre (X)
            if (closeButton) {
                closeButton.addEventListener('click', closeModal);
            }

            // 2. Clic en el fondo (overlay)
            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    closeModal();
                }
            });

            // 3. Presionar la tecla "Escape"
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && modal.style.display === 'block') {
                    closeModal();
                }
            });
        });
    </script>
@endsection
