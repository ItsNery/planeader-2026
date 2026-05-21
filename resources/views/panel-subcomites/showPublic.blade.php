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
<section class="subcomite_individual">
    <div class="container pt-5">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-black text-uppercase h6_planeader">
                Conoce el @if ($subcomite->planestatal->nombre != 'Plan Estatal de Desarrollo 2024-2030')
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
@if($documentosAgrupados->isNotEmpty())
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
                <p class="text-black" style="font-size: 10px">Última actualización:
                    {{ $ultimaActualizacionDocSubcomite->format('d/m/Y H:i:s') }} UTC
            @else
                    <p class="text-black" style="font-size: 10px; margin-bottom:inherit">Última actualización:
                        No hay información disponible.</p>
                    <p>
                @endif
        </div>
    </section>
@endif

<section class="coplademun-agendar py-4">
    <div class="container">
        <div class="text-center">
            <h2 class="titulo-tematica">Agendar citas</h2>
        </div>
    </div>
    <div class="col py-4">
        <div class="text-center mb-3 pb-3 d-flex justify-content-center flex-column align-items-center">
            <span class="text-dark fs-4">¿Gustas agendar una cita para tu sesión de Subcomité o
                Mesas Técnicas?
            </span>
            <span class="subtitulo_sitios text-dark fs-5">
                Usa nuestros calendarios
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs justify-content-center mb-4" id="calendarTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="subcomites-tab" data-bs-toggle="tab"
                        data-bs-target="#subcomites" type="button" role="tab" aria-controls="subcomites"
                        aria-selected="true">Subcomités</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="mesas-tab" data-bs-toggle="tab" data-bs-target="#mesas" type="button"
                        role="tab" aria-controls="mesas" aria-selected="false">Mesas técnicas</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="subcomites" role="tabpanel" aria-labelledby="subcomites-tab">
                    <div class="container">
                        <iframe
                            src="https://calendar.google.com/calendar/appointments/schedules/AcZssZ3tkB_c4aKhyuWtFztgi_2RM9PvUAESIjPg_c40XMkfxdxrHoppqwAeoKAu4szA-3MKOl_2NlGa?gv=true"
                            style="border: 0" width="100%" height="900" frameborder="0"></iframe>
                    </div>
                </div>
                <div class="tab-pane fade" id="mesas" role="tabpanel" aria-labelledby="mesas-tab">
                    <div class="container d-flex justify-content-center align-items-center flex-column">
                        <i class="fa-solid fa-hourglass-half fs-4 mb-3 text-secondary"></i>
                        <span class="card border-info bg-light py-3 px-3 fs-3">
                            Proximamente disponible
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
@endsection