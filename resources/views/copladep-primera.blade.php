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
    <script src="https://cdn.jsdelivr.net/npm/add-to-calendar-button@2" async defer></script>
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
                        <h2 class="accordion-header" id="heading0">
                            <button class="accordion-button show" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse0" aria-expanded="false" aria-controls="collapse0">
                                Liga de registro
                            </button>
                        </h2>
                        <div id="collapse0" class="accordion-collapse collapse show" aria-labelledby="heading0"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="container d-flex justify-content-center bg-light px-4 py-4">
                                    <a href="{{ url('/copladep/primera-sesion-ordinaria/registro') }}" 
                                    rel="noopener" 
                                    target="_blank" 
                                    title="Registro de asistencia"
                                    class="btn btn-outline-primary btn-sm shadow-sm px-5 py-3 rounded-pill fw-bold text-uppercase"> 
                                        Registro
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <div class="container">
                                    @php
                                        $descripcionEvento = "Evento: Privado | Sectores Estratégicos | Código de vestimenta: Formal\n\n" .
                                            "Presentar avances en materia de planeación estatal:\n" .
                                            "• Presentación y, en su caso, aprobación de los Lineamientos para el funcionamiento del COPLADEP y sus Órganos Auxiliares, así como de los Subcomités Sectoriales del COPLADEP.\n" .
                                            "• Presentación y, en su caso, aprobación de Programas Institucionales del Plan Estatal de Desarrollo 2024-2030.\n" .
                                            "• Actualización de la regionalización y los Programas Regionales.\n" .
                                            "• Presentación de los resultados de la Evaluación de Diseño del Plan Estatal de Desarrollo 2024-2030.\n" .
                                            "• Relanzamiento de la Agenda 2030 en el Estado de Puebla.";
                                    @endphp
                                    <add-to-calendar-button
                                        name="Primera Sesión Ordinaria 2026 de la Asamblea Plenaria del COPLADEP"
                                        description="{{ $descripcionEvento }}" startDate="2026-03-31" startTime="17:00"
                                        endTime="17:50" timeZone="America/Mexico_City"
                                        location="Casa Puebla, Calzada de los Fuertes 106, Centro histórico de Puebla, 72260, Puebla de Zaragoza"
                                        options="'Google','Apple','Microsoft365','Outlook.com'" buttonsList
                                        hideTextLabelButton lightMode="system"></add-to-calendar-button>
                                    <iframe
                                        src="{{ asset('documentos/primera-sesion-ordinaria-2026/1. Logística del evento.pdf') }}"
                                        frameborder="0" class="iframe-documento"></iframe>
                                </div>
                                {{-- <ul>
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
                                                data-title="Logística del evento" title="Ver aquí">
                                                <i class="fas fa-eye"></i> <span>Ver aquí</span>
                                            </a>
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/1. Logística del evento.pdf') }}"
                                                target="_blank" rel="noopener noreferrer" title="Abrir en nueva pestaña">
                                                <i class="fas fa-external-link-alt"></i> <span>Abrir</span>
                                            </a>
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/1. Logística del evento.pdf') }}"
                                                download="1. Logística del evento.pdf" rel="noopener"
                                                title="Descargar Logística del evento">
                                                <i class="fas fa-download"></i>
                                                <span>Descargar</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul> --}}
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
                                <div class="container">
                                    <iframe
                                        src="{{ asset('documentos/primera-sesion-ordinaria-2026/2. Orden del Día.pdf') }}"
                                        frameborder="0" class="iframe-documento"></iframe>
                                </div>
                                {{-- <ul>
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
                                                data-title="Orden del día" title="Ver aquí">
                                                <i class="fas fa-eye"></i> <span>Ver aquí</span>
                                            </a>
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/2. Orden del Día.pdf') }}"
                                                target="_blank" rel="noopener noreferrer" title="Abrir en nueva pestaña">
                                                <i class="fas fa-external-link-alt"></i> <span>Abrir</span>
                                            </a>
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/2. Orden del Día.pdf') }}"
                                                download="Nombre documento" rel="noopener"
                                                title="Descargar 2. Orden del Día.pdf">
                                                <i class="fas fa-download"></i>
                                                <span>Descargar</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul> --}}
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading9">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                Lineamientos para el Funcionamiento del COPLADEP y sus Órganos Auxiliares
                            </button>
                        </h2>
                        <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                    <iframe
                                        src="{{ asset('documentos/primera-sesion-ordinaria-2026/Lineamientos-COPLADEP.pdf') }}"
                                        frameborder="0" class="iframe-documento"></iframe>
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
                                            {{-- <a href="#" class="js-open-modal"
                                                data-src="{{ asset('documentos/primera-sesion-ordinaria-2026/3. Estructura General de los Subcomités.pdf') }}"
                                                data-title="Estructura General de los Subcomités" title="Ver aqui">
                                                <i class="fas fa-eye"></i> <span>Ver aquí</span>
                                            </a> --}}
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/3. Estructura General de los Subcomités.pdf') }}"
                                                target="_blank" rel="noopener noreferrer" title="Abrir en nueva pestaña">
                                                <i class="fas fa-external-link-alt"></i> <span>Abrir</span>
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
                                            {{-- <a href="#" class="js-open-modal"
                                                data-src="{{ asset('documentos/primera-sesion-ordinaria-2026/4. Subcomités Sectoriales para el Desarrollo Regional y la Riqueza Comunitaria.pdf') }}"
                                                data-title="Subcomités Sectoriales para el Desarrollo Regional y la Riqueza Comunitaria"
                                                title="Ver aquí">
                                                <i class="fas fa-eye"></i> <span>Ver aquí</span>
                                            </a> --}}
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/4. Subcomités Sectoriales para el Desarrollo Regional y la Riqueza Comunitaria.pdf') }}"
                                                target="_blank" rel="noopener noreferrer" title="Abrir en nueva pestaña">
                                                <i class="fas fa-external-link-alt"></i> <span>Abrir</span>
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
                                <div class="container">
                                    <img src="{{ asset('documentos/primera-sesion-ordinaria-2026/5. Actualización de la Regionalización del Estado de Puebla.webp') }}" alt="" srcset="" class="w-100">
                                </div>
                                {{-- <ul>
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
                                                title="Ver aquí">
                                                <i class="fas fa-eye"></i> <span>Ver aquí</span>
                                            </a> 
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/5. Actualización de la Regionalización del Estado de Puebla.pdf') }}"
                                                target="_blank" rel="noopener noreferrer" title="Abrir en nueva pestaña">
                                                <i class="fas fa-external-link-alt"></i> <span>Abrir</span>
                                            </a>
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/5. Actualización de la Regionalización del Estado de Puebla.pdf') }}"
                                                download="Actualización de la Regionalización del Estado de Puebla"
                                                rel="noopener" title="Descargar documento">
                                                <i class="fas fa-download"></i>
                                                <span>Descargar</span>
                                            </a>
                                        </div>
                                    </li>
                                </ul> --}}
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
                                <div class="container mb-5 accion-programa">
                                    <a href="https://planeader.puebla.gob.mx/ped-programas" target="_self" rel="noopener" title="Programas Derivados" class="accion-programa__boton accion-programa__boton--vino">
                                        <span class="accion-programa__texto">Conócelos</span>
                                        <i class="fa-solid fa-arrow-right accion-programa__icono"></i>
                                    </a>
                                </div>
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
                                            <p class="document-item__name">
                                                Programas Institucionales - Sector Educativo
                                            </p>
                                            <span class="document-badge badge-pdf">
                                                PDF
                                            </span>
                                        </div>
                                        <div class="document-item__actions">
                                            {{-- <a href="#" class="js-open-modal"
                                                data-src="{{ asset('documentos/primera-sesion-ordinaria-2026/Programas Institucionales-Sector Educativo.pdf') }}"
                                                data-title="Programas Institucionales - Sector Educativo" title="Ver aquí">
                                                <i class="fas fa-eye"></i> <span>Ver aquí</span>
                                            </a> --}}
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/Programas Institucionales-Sector Educativo.pdf') }}"
                                                target="_blank" rel="noopener noreferrer" title="Abrir en nueva pestaña">
                                                <i class="fas fa-external-link-alt"></i> <span>Abrir</span>
                                            </a>
                                            <a href="{{ asset('documentos/primera-sesion-ordinaria-2026/Programas Institucionales-Sector Educativo.pdf') }}"
                                                download="Programas Institucionales - Sector Educativo" rel="noopener"
                                                title="Descargar Programas Institucionales - Sector Educativo">
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
                        <h2 class="accordion-header" id="heading7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                Relanzamiento de la Agenda 2030 en el Estado de Puebla
                            </button>
                        </h2>
                        <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                    <iframe
                                        src="{{ asset('documentos/primera-sesion-ordinaria-2026/Relanzamiento-Agenda2030.pdf') }}"
                                        frameborder="0" class="iframe-documento"></iframe>
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
                                    <div class="mx-auto px-4 py-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                        <div class="contenedor-tarjetadocs">
                                            <img src="{{ asset('documentos/primera-sesion-ordinaria-2026/9.1 PED.png') }}"
                                                alt="Titulo" class="width-100" title="Titulo">
                                        </div>
                                    </div>
                                    <div class="mx-auto px-4 py-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                        <div class="contenedor-tarjetadocs">
                                            <img src="{{ asset('documentos/primera-sesion-ordinaria-2026/9.2 Evaluación de Diseño del Plan Estatal de Desarrollo 2024 – 2030.png') }}"
                                                alt="Titulo" class="width-100" title="Titulo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                        <div class="accordion-item">
                        <h2 class="accordion-header" id="heading10">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                                Proyectos Transformadores del Plan Estatal de Desarrollo 2024-2030
                            </button>
                        </h2>
                        <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                                                <div class="container">
                                    <iframe
                                        src="{{ asset('documentos/primera-sesion-ordinaria-2026/Proyectos Transformadores.pdf') }}"
                                        frameborder="0" class="iframe-documento"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="heading11">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                Guía metodológica para la construcción, seguimiento y análisis de indicadores estratégicos y tácticos
                            </button>
                        </h2>
                        <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               <div class="container">
                                 <img src="{{asset('documentos/primera-sesion-ordinaria-2026/Esquema_Mesa de trabajo.webp')}}" alt="" srcset="" class="w-100">
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
@endsection