@extends('layouts.plantilla')
@section('title', 'Programas Estatales')
@section('meta-description', 'Documentos de carácter estatal que no son derivados del Plan Estatal de Desarrollo')
@section('canonical-url', url()->current())
@section('og-title', 'Programas Estatales - Sistema Estatal de Planeación Democrática')
@section('og-description', 'Documentos de carácter estatal que no son derivados del Plan Estatal de Desarrollo.')
@section('og:url', url()->current())
@section('twitter-title', 'Programas Estatales - Sistema Estatal de Planeación Democrática')
@section('twitter-description', 'Documentos de carácter estatal que no son derivados del Plan Estatal de Desarrollo.')
@section('content')
    <section class="contenedor-imagen-programasest">
        <h1>Programas Estatales</h1>
    </section>
    <section class="programas-estatales">
        <div class="container py-5">
            <div class="text-center mb-3 pb-3">
                <p class="text-black">Documentos de carácter estatal que no son derivados del Plan Estatal de Desarrollo</p>
            </div>
        </div>
        <div class="container derivadosnew">
            @if ($programas->isEmpty())
                <div class="container flex-container-centro">
                    <p class="subtitulo-seccion">Proximamente.</p>
                </div>
            @else
                <div class="container row">
                    @foreach ($programas as $programa)
                        <div class="col pb-3">
                            <div class="tarjeta-documentos-ped js-ver-documento"
                                data-src="{{ asset('programasEstatales/' . $programa->ruta_documento) }}"
                                data-title="{{ $programa->nombre }}">
                                <div class="tarjeta-documentos-ped__img">
                                    <img loading="lazy" class="w-100"
                                        src="{{ asset('img/portadas-programas-estatales/' . $programa->portada) }}"
                                        alt="Portada de Anexo 1" title="Portada de Anexo 1">
                                </div>
                                <div class="tarjeta-documentos-ped__wrapper">
                                    <div class="tarjeta-documentos-ped__icon">
                                        @include('layouts.svgflecha')
                                    </div>
                                    <img class="justify-items-center w-15p" src="{{ asset('imagen/pdf.png') }}"
                                        alt="imagen de excel" title="Ícono de PDF">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    <section class="historicos-subcomites" id="historicos-programas">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div class="row">
                        <div class="col-12">
                            <div class="subtitulo-tematica">
                                Archivo Histórico de los
                            </div>
                            <div class="titulo-tematica">
                                Programas Estatales
                            </div>
                        </div>
                    </div>

                    @if ($historico_programas_agrupados->isNotEmpty())

                        {{-- El div padre del acordeón. Necesita un ID único. --}}
                        <div class="accordion" id="accordionHistorico">

                            {{-- La clave ($plan_id) no la usamos, pero el valor ahora es la colección de programas de ese plan
                            --}}
                            @foreach ($historico_programas_agrupados as $plan_id => $programas_del_plan)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-{{ $plan_id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $plan_id }}" aria-expanded="false"
                                            aria-controls="collapse-{{ $plan_id }}">

                                            {{-- <strong>{{ $programas_del_plan->first()->planEstatal->nombre }}</strong> --}}
                                            <strong>
                                                {{ $programas_del_plan->first()->planEstatal->periodo }}
                                            </strong>
                                            {{-- <span class="ms-2 fst-italic fw-normal">({{
                                                $programas_del_plan->first()->planEstatal->periodo }})
                                            </span> --}}
                                        </button>
                                    </h2>

                                    <div id="collapse-{{ $plan_id }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading-{{ $plan_id }}" data-bs-parent="#accordionHistorico">
                                        <div class="accordion-body">
                                            <ul class="list-group list-group-flush">
                                                {{-- Ahora iteramos sobre los programas de este plan en específico --}}
                                                @foreach ($programas_del_plan as $programa)
                                                    <li class="document-item">

                                                        <div class="document-item__main-content">
                                                            <p class="document-item__name">
                                                                {{ $programa->nombre }}
                                                            </p>
                                                            <span
                                                                class="document-badge badge-pdf">{{ strtoupper(pathinfo($programa->ruta_documento, PATHINFO_EXTENSION)) }}</span>
                                                        </div>

                                                        <div class="document-item__actions">

                                                            <a href="#" class="js-ver-documento"
                                                                data-src="{{ asset('programasEstatales/' . $programa->ruta_documento) }}"
                                                                data-title="{{ $programa->nombre }}" title="Ver documento">
                                                                <i class="fas fa-eye"></i> <span>Ver aquí</span>
                                                            </a>
                                                            <a href="{{ asset('programasEstatales/' . $programa->ruta_documento) }}"
                                                                target="_blank" rel="noopener noreferrer"
                                                                title="Abrir en nueva pestaña">
                                                                <i class="fas fa-external-link-alt"></i> <span>Abrir</span>
                                                            </a>
                                                            <a href="{{ asset('programasEstatales/' . $programa->ruta_documento) }}"
                                                                download rel="noopener" title="Descargar documento">
                                                                <i class="fas fa-download"></i>
                                                                <span>Descargar</span>
                                                            </a>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @else
                        {{-- Mensaje si no hay programas históricos --}}
                        <p class="text-center text-muted">No hay registros históricos de programas estatales disponibles.
                        </p>
                    @endif

                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection