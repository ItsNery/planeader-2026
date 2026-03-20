@extends('layouts.plantilla')
@section('title', 'Primera Sesión Ordinaria 2026 del COPLADEP')
@section('meta-description',
    'Página principal de los Primera Sesión Ordinaria del Comité de Planeación para el
    Desarrollo del Estado de Puebla del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Primera Sesión Ordinaria del COPLADEP - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Página principal de los Primera Sesión Ordinaria del Comité de Planeación para el Desarrollo
    del Estado de Puebla del Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'Primera Sesión Ordinaria del COPLADEP - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Página principal de los Primera Sesión Ordinaria del Comité de Planeación para el
    Desarrollo del Estado de Puebla del Estado de Puebla.')
@section('css')
@endsection

@section('content')
    <section class="contenedor-imagen-primera-sesion">
        <h1>
            Primera Sesión Ordinaria 2026
            <br>
            de la Asamblea Plenaria
            <br> del COPLADEP
        </h1>
    </section>
    <section class="documentos-metodologicos">
        <div class="container">
            <p class="corra-light text-justify my-5">
                Listado con los anexos a la convocatoria:
            </p>
            <div class="container my-4">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                Logística del evento
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li class="document-item">
                                        <div class="document-item__main-content">
                                            <p class="document-item__name">
                                                Logística del evento
                                            </p>
                                            <span class="document-badge badge-pdf">
                                                PDF
                                            </span>
                                        </div>

                                        <div class="document-item__actions">
                                            <a href="#" class="js-open-modal"
                                                data-src="{{ asset('documentos/primera-sesion-ordinaria-2026/1. Logística del evento.pdf') }}"
                                                data-title="Logística del evento" title="Logística del evento">
                                                <i class="fas fa-eye"></i> <span>Ver</span>
                                            </a>
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/1. Logística del evento.pdf') }}"
                                                download="1. Logística del evento.pdf" rel="noopener"
                                                title="Logística del evento">
                                                <i class="fas fa-download"></i>
                                                <span>Descargar</span>
                                            </a>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                Orden del día
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li class="document-item">
                                        <div class="document-item__main-content">
                                            <p class="document-item__name">
                                                Orden del día
                                            </p>
                                            <span class="document-badge badge-pdf">
                                                PDF
                                            </span>
                                        </div>
                                        <div class="document-item__actions">
                                            <a href="#" class="js-open-modal"
                                                data-src="{{ asset('documentos/primera-sesion-ordinaria-2026/2. Orden del Día.pdf') }}"
                                                data-title="Orden del día" title="Orden del día">
                                                <i class="fas fa-eye"></i> <span>Ver</span>
                                            </a>
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/2. Orden del Día.pdf') }}"
                                                download="Nombre documento" rel="noopener" title="Descargar documento">
                                                <i class="fas fa-download"></i>
                                                <span>Descargar</span>
                                            </a>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                Subcomités Sectoriales para el Desarrollo Regional y la Riqueza Comunitaria
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li class="document-item">
                                        <div class="document-item__main-content">
                                            <p class="document-item__name">
                                                Estructura General de los Subcomités
                                            </p>
                                            <span class="document-badge badge-pdf">
                                                PDF
                                            </span>
                                        </div>
                                        <div class="document-item__actions">
                                            <a href="#" class="js-open-modal"
                                                data-src="{{ asset('documentos/primera-sesion-ordinaria-2026/3. Estructura General de los Subcomités.pdf') }}"
                                                data-title="Estructura General de los Subcomités"
                                                title="Estructura General de los Subcomités">
                                                <i class="fas fa-eye"></i> <span>Ver</span>
                                            </a>
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/3. Estructura General de los Subcomités.pdf') }}"
                                                download="Estructura General de los Subcomités" rel="noopener"
                                                title="Descargar documento">
                                                <i class="fas fa-download"></i>
                                                <span>Descargar</span>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="document-item">
                                        <div class="document-item__main-content">
                                            <p class="document-item__name">
                                                Subcomités Sectoriales para el Desarrollo Regional y la Riqueza Comunitaria
                                            </p>
                                            <span class="document-badge badge-pdf">
                                                PDF
                                            </span>
                                        </div>
                                        <div class="document-item__actions">
                                            <a href="#" class="js-open-modal"
                                                data-src="{{ asset('documentos/primera-sesion-ordinaria-2026/4. Subcomités Sectoriales para el Desarrollo Regional y la Riqueza Comunitaria.pdf') }}"
                                                data-title="Subcomités Sectoriales para el Desarrollo Regional y la Riqueza Comunitaria"
                                                title="Subcomités Sectoriales para el Desarrollo Regional y la Riqueza Comunitaria">
                                                <i class="fas fa-eye"></i> <span>Ver</span>
                                            </a>
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/4. Subcomités Sectoriales para el Desarrollo Regional y la Riqueza Comunitaria.pdf') }}"
                                                download="Subcomités Sectoriales para el Desarrollo Regional y la Riqueza Comunitaria"
                                                rel="noopener" title="Descargar documento">
                                                <i class="fas fa-download"></i>
                                                <span>Descargar</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                Actualización de la Regionalización del Estado de Puebla
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li class="document-item">
                                        <div class="document-item__main-content">
                                            <p class="document-item__name">
                                                Actualización de la Regionalización del Estado de Puebla
                                            </p>
                                            <span class="document-badge badge-pdf">
                                                PDF
                                            </span>
                                        </div>
                                        <div class="document-item__actions">
                                            <a href="#" class="js-open-modal"
                                                data-src="{{ asset('documentos/primera-sesion-ordinaria-2026/5. Actualización de la Regionalización del Estado de Puebla.pdf') }}"
                                                data-title="Actualización de la Regionalización del Estado de Puebla"
                                                title="Actualización de la Regionalización del Estado de Puebla">
                                                <i class="fas fa-eye"></i> <span>Ver</span>
                                            </a>
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/5. Actualización de la Regionalización del Estado de Puebla.pdf') }}"
                                                download="Actualización de la Regionalización del Estado de Puebla"
                                                rel="noopener" title="Descargar documento">
                                                <i class="fas fa-download"></i>
                                                <span>Descargar</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                Actualización de Programas Regionales
                            </button>
                        </h2>
                        <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li class="document-item">
                                        <div class="document-item__main-content">
                                            {{-- <p class="document-item__name">
                                                Pendiente
                                            </p> --}}
                                            {{-- <span class="document-badge badge-pdf">
                                                PDF
                                            </span> --}}
                                        </div>
                                        {{-- <div class="document-item__actions">
                                            <a href="#" class="js-open-modal"
                                                data-src="{{ asset('documentocopladep') }}"
                                                data-title="Titulo del documento" title="Ver documento">
                                                <i class="fas fa-eye"></i> <span>Ver</span>
                                            </a>
                                            <a href="{{ asset('documentocopladep') }}" download="Nombre documento"
                                                rel="noopener" title="Descargar documento">
                                                <i class="fas fa-download"></i>
                                                <span>Descargar</span>
                                            </a>
                                        </div> --}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                Aprobación de los Programas Institucionales
                            </button>
                        </h2>
                        <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li class="document-item">
                                        <div class="document-item__main-content">
                                            {{-- <p class="document-item__name">
                                                Pendiente
                                            </p> --}}
                                            {{-- <span class="document-badge badge-pdf">
                                                PDF
                                            </span> --}}
                                        </div>
                                        {{-- <div class="document-item__actions">
                                            <a href="#" class="js-open-modal"
                                                data-src="{{ asset('documentocopladep') }}"
                                                data-title="Titulo del documento" title="Ver documento">
                                                <i class="fas fa-eye"></i> <span>Ver</span>
                                            </a>
                                            <a href="{{ asset('documentocopladep') }}" download="Nombre documento"
                                                rel="noopener" title="Descargar documento">
                                                <i class="fas fa-download"></i>
                                                <span>Descargar</span>
                                            </a>
                                        </div> --}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                Relanzamiento de la Agenda 2030 en el Estado de Puebla
                            </button>
                        </h2>
                        <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="mx-auto px-4 py-4 col-lg-8 col-md-6 col-sm-12 col-12">
                                        <div class="container">
                                            <img src="{{ asset('documentos/primera-sesion-ordinaria-2026/8.1 Esquema piramide.png') }}"
                                                alt="Titulo" class="acordion__imagen-piramide" title="Titulo">
                                        </div>
                                    </div>
                                    <div class="mx-auto px-4 py-4 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="contenedor-tarjetadocs">
                                            <img src="{{ asset('documentos/primera-sesion-ordinaria-2026/8.2 Portada Documento Relanzamiento Agenda 2030.webp') }}"
                                                alt="Titulo" class="width-100" title="Titulo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading8">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                Evaluación de Diseño del Plan Estatal de Desarrollo 2024 – 2030
                            </button>
                        </h2>
                        <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="mx-auto px-4 py-4 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="contenedor-tarjetadocs">
                                            <img src="{{ asset('documentos/primera-sesion-ordinaria-2026/9.1 PED.png') }}"
                                                alt="Titulo" class="width-100" title="Titulo">
                                        </div>
                                    </div>
                                    <div class="mx-auto px-4 py-4 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="contenedor-tarjetadocs">
                                            <img src="{{ asset('documentos/primera-sesion-ordinaria-2026/9.2 Evaluación de Diseño del Plan Estatal de Desarrollo 2024 – 2030.png') }}"
                                                alt="Titulo" class="width-100" title="Titulo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="myModal" class="modal-planeader">
        <div class="modal-content">
            <button class="close-btn" aria-label="Cerrar">
                &times;
            </button>
            <h3 id="modalTitle" class="text-center"></h3>
            <iframe class="w-100 h-100" src="" id="modalIframe"></iframe>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('myModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalIframe = document.getElementById('modalIframe');
            const closeModalButton = document.querySelector('#myModal .close-btn');

            const openModalTriggers = document.querySelectorAll('.js-open-modal');

            openModalTriggers.forEach(trigger => {
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    const docUrl = this.dataset.src;
                    const docTitle = this.dataset.title;

                    if (docUrl) {
                        modalTitle.textContent = docTitle;
                        modalIframe.src = docUrl;
                        modal.style.display = 'block';
                    }
                });
            });

            if (closeModalButton) {
                closeModalButton.addEventListener('click', closeModal);
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

        function closeModal() {
            const modal = document.getElementById('myModal');
            if (modal) {
                modal.style.display = 'none';
            }
            const modalIframe = document.getElementById('modalIframe');
            if (modalIframe) {
                modalIframe.src = '';
            }
        }
    </script>
@endsection
