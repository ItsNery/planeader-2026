@extends('layouts.plantilla')
@section('title', 'Comité de Planeación para el Desarrollo del Estado de Puebla')
@section('meta-description',
    'Visión general del Comité de Planeación para el Desarrollo del Estado de Puebla del
    Sistema Estatal de Planeación Democrática del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'COPLADEP - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Bienvenido a la página de visión general del Comité de Planeación para el Desarrollo del
    Estado de Puebla del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'COPLADEP - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Bienvenido a la página de visión general del Comité de Planeación para el Desarrollo
    del Estado de Puebla del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('content')
    <section class="contenedor-imagen-copladep">
        <h1 class="visually-hidden">COPLADEP</h1>
    </section>
    <section class="copladep-inicio">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="titulo-tematica">
                        ¿Qué es el COPLADEP?
                    </div>
                    <div class="col-12">
                        <p class="text-justify">
                            El Comité de Planeación para el Desarrollo del Estado de Puebla (COPLADEP) es el órgano público,
                            colegiado e interinstitucional en materia de planeación, cuyos objetivos fundamentales son
                            promover y coadyuvar en la formulación, actualización, instrumentación y evaluación del Plan
                            Estatal de Desarrollo y de los programas sectoriales, especiales y regionales, mediante la
                            participación del sector público, social y privado, en el marco del Sistema Estatal de
                            Planeación Democrática.
                        </p>
                        <p class="text-justify">
                            Asimismo, el COPLADEP cuenta con las siguientes atribuciones:
                        </p>
                        <ul>
                            <li class="text-justify">
                                Promover, con la participación de los diversos sectores de la sociedad, la
                                elaboración y
                                actualización del Plan Estatal de Desarrollo y los programas sectoriales,
                                especiales y regionales, procurando que se realicen atendiendo los
                                principios
                                que rigen el Sistema Estatal de Planeación Democrática;
                            </li>
                            <li class="text-justify">
                                Aprobar en asamblea plenaria el Plan Estatal de Desarrollo, dentro de los
                                términos y
                                plazos que fija la Ley de Planeación para el Desarrollo del Estado de
                                Puebla;
                            </li>
                            <li class="text-justify">
                                Acordar el establecimiento de subcomités sectoriales, especiales y
                                regionales, los
                                cuales actuarán como auxiliares del COPLADEP y se integrarán conforme a lo
                                que
                                éste determine;
                            </li>
                            <li class="text-justify">
                                Promover el uso del Sistema Estatal de Información para la Planeación del
                                Desarrollo del
                                Estado;
                            </li>
                            <li class="text-justify">
                                Promover que el control, seguimiento y evaluación del Plan Estatal de
                                Desarrollo y de
                                los programas sectoriales, especiales y regionales se realice con
                                perspectiva
                                de género, a fin de visibilizar el gasto realizado específicamente para la
                                promoción, garantía, respeto y protección de los derechos humanos.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="integrantes-copladep">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="titulo-tematica">
                        Integrantes
                    </div>
                </div>
                <div class="col-12">
                    <img src="{{ asset('img/integrantes-copladep.jpg') }}" alt="Esquema de conformación del COPLADEP"
                        title="Conformación del Copladep" class="esquema-visual">
                </div>
            </div>
        </div>
        <div class="container-fluid services py-5">
            <div class="container">
                {{-- Comentado en espera de nueva integración --}}
                {{-- <div class="col-md-12 col-lg-12">
                        <div class="services-item-no-anim bg-light">
                            <div class="p-4 text-center services-content">
                                <div class="services-content-icon">
                                    <div class="container">
                                        <h4 class="mb-3 text-white copladep-titulo">
                                            Integrantes
                                        </h4>
                                    </div>
                                    <img class="w-100" src="{{ asset('subcomitesconformacion/COPLADEP.png') }}"
                                        alt="Integración de COPLADEP" title="Integración de COPLADEP">
                                </div>
                            </div>
                        </div>
                    </div> --}}

                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="titulo-tematica">
                                Documentos
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container my-4">
                    @if ($anios->isEmpty())
                        <div class="text-center p-5">
                            <img src="{{ asset('imagen/no-file.png') }}" alt="No hay archivos"
                                style="width: 200px; opacity: 0.7;">
                            <p class="text-muted mt-4">Upps, no se encontraron registros.</p>
                        </div>
                    @else
                        <div class="accordion" id="accordionExample">
                            @foreach ($anios->sortByDesc('anio') as $anio)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $anio->anio }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $anio->anio }}" aria-expanded="false"
                                            aria-controls="collapse{{ $anio->anio }}">
                                            {{ $anio->anio }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $anio->anio }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading{{ $anio->anio }}" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            @foreach ($documentos[$anio->anio] as $tipo => $documentosPorTipo)
                                                <h4>
                                                    {{ $tipo === 'Acta' ? 'Actas' : ($tipo === 'Informe' ? 'Informes de Actividades' : ($tipo === 'Programa' ? 'Programas de Trabajo' : $tipo)) }}
                                                </h4>
                                                <ul>
                                                    @foreach ($documentosPorTipo as $documento)
                                                        {{-- ESTRUCTURA COMPLETA CON ETIQUETA DE FORMATO --}}
                                                        <li class="document-item">
                                                            <div class="document-item__main-content">
                                                                <p class="document-item__name">
                                                                    {{ $documento->nombre }}
                                                                </p>
                                                                <span class="document-badge badge-pdf">
                                                                    PDF
                                                                </span>
                                                            </div>

                                                            <div class="document-item__actions">

                                                                <a href="#" class="js-open-modal"
                                                                    data-src="{{ asset('documentocopladep/' . $documento->ruta_documento) }}"
                                                                    data-title="{{ $documento->nombre }} {{ $documento->anio }}"
                                                                    title="Ver documento">
                                                                    <i class="fas fa-eye"></i> <span>Ver aquí</span>
                                                                </a>
                                                                <a href="{{ asset('documentocopladep/' . $documento->ruta_documento) }}"
                                                                    target="_blank" rel="noopener noreferrer"
                                                                    title="Abrir en nueva pestaña">
                                                                    <i class="fas fa-external-link-alt"></i>
                                                                    <span>Abrir</span>
                                                                </a>
                                                                <a href="{{ asset('documentocopladep/' . $documento->ruta_documento) }}"
                                                                    download="{{ $documento->nombre }}" rel="noopener"
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
                            @endforeach
                        </div>

                        @if ($ultimaActualizacion)
                            <p class="text-center text-muted mt-4" style="font-size: 0.8rem;">
                                Última actualización: {{ $ultimaActualizacion->format('d/m/Y H:i:s') }}
                            </p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection
