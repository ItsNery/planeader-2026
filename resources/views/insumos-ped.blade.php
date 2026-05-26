@extends('layouts.plantilla')
@section('title', 'Insumos del Plan Estatal de Desarrollo')
@section('meta-description',
    'Consulta los insumos documentales para la integración y elaboración del Plan Estatal de Desarrollo del
    Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Insumos del PED - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Accede a los insumos documentales: Árboles de problemas y Fichas de indicadores del Plan Estatal de Desarrollo.')
@section('og:image', asset('img/logo-gobierno-1.png'))
@section('og:url', url()->current())
@section('css')
@endsection
@section('content')
    <section class="ped-breadcrumb">
        <div class="container">
            <ol class="breadcrumb ped-breadcrumb__list justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                <li class="breadcrumb-item ped-breadcrumb__item">
                    <a href="{{ url('/') }}" class="ped-breadcrumb__link">
                        <i class="fa-solid fa-home me-2"></i>Inicio
                    </a>
                </li>
                <li class="breadcrumb-item ped-breadcrumb__item">
                    <a href="{{ url('/ped') }}" class="ped-breadcrumb__link">
                        Plan Estatal de Desarrollo
                    </a>
                </li>
                <li class="breadcrumb-item active ped-breadcrumb__item ped-breadcrumb__item--active" aria-current="page">
                    Insumos del PED
                </li>
            </ol>
        </div>
    </section>

    <section class="ped-insumos">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="ped-insumos__title">
                        Insumos para la Elaboración del Plan Estatal de Desarrollo
                    </div>
                    <div class="ped-insumos__text-container">
                        <p class="ped-insumos__text">
                            A continuación encontrarás los insumos documentales que fueron utilizados en la integración
                            y elaboración del Plan Estatal de Desarrollo 2024-2030. Estos documentos incluyen los árboles
                            de problemas identificados y las fichas técnicas de indicadores.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ped-insumos ped-insumos--documents">
        <div class="container">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs ped-insumos__tab-list" id="insumosTab" role="tablist">
                <li class="nav-item ped-insumos__tab-item" role="presentation">
                    <button class="nav-link ped-insumos__tab-button active" id="arboles-tab" data-bs-toggle="tab"
                        data-bs-target="#arboles-problemas" type="button" role="tab" aria-controls="arboles-problemas"
                        aria-selected="true">
                        Árboles de Problemas
                    </button>
                </li>
                <li class="nav-item ped-insumos__tab-item" role="presentation">
                    <button class="nav-link ped-insumos__tab-button" id="fichas-tab" data-bs-toggle="tab" data-bs-target="#fichas-indicadores"
                        type="button" role="tab" aria-controls="fichas-indicadores" aria-selected="false">
                        Fichas de Indicadores
                    </button>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content ped-insumos__tab-content" id="insumos-tabContent">
                <!-- Árboles de Problemas Tab -->
                <div class="tab-pane ped-insumos__panel fade show active" id="arboles-problemas" role="tabpanel"
                    aria-labelledby="arboles-tab">
                    @if ($arbolesProblemas->isEmpty())
                        <div class="container ped-insumos__empty-state">
                            <img class="ped-insumos__empty-image mb-3" src="{{ asset('imagen/no-file.png') }}" alt="Imagen de Not Found"
                                title="Imagen de Not Found">
                            <p class="ped-insumos__empty-text">No hay documentos de Árboles de Problemas disponibles en este
                                momento.</p>
                        </div>
                    @else
                        <div class="pmd-list-section">
                            <ul class="list-group list-group-flush">
                                @foreach ($arbolesProblemas as $documento)
                                    <li class="document-item">
                                        <div class="document-item__main-content">
                                            <p class="document-item__name">
                                                {{ $documento->titulo }}
                                            </p>
                                            @if ($documento->formato === 'pdf')
                                                <span class="document-badge badge-pdf">PDF</span>
                                            @else
                                                <span class="document-badge badge-xls">EXCEL</span>
                                            @endif
                                        </div>

                                        <div class="document-item__actions">
                                            @if ($documento->formato === 'pdf')
                                                <a href="#" class="js-open-modal"
                                                    data-src="{{ asset('insumos-ped/' . $documento->ruta_documento) }}"
                                                    data-title="{{ $documento->titulo }}" title="Ver documento">
                                                    <i class="fas fa-eye"></i> <span>Ver aquí</span>
                                                </a>
                                            @endif
                                            <a href="{{ asset('insumos-ped/' . $documento->ruta_documento) }}" target="_blank"
                                                rel="noopener noreferrer" title="Abrir en nueva pestaña">
                                                <i class="fas fa-external-link-alt"></i> <span>Abrir</span>
                                            </a>
                                            <a href="{{ asset('insumos-ped/' . $documento->ruta_documento) }}" download
                                                rel="noopener" title="Descargar documento">
                                                <i class="fas fa-download"></i> <span>Descargar</span>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Fichas de Indicadores Tab -->
                <div class="tab-pane ped-insumos__panel fade" id="fichas-indicadores" role="tabpanel" aria-labelledby="fichas-tab">
                    @if ($fichasIndicadores->isEmpty())
                        <div class="container ped-insumos__empty-state">
                            <img class="ped-insumos__empty-image mb-3" src="{{ asset('imagen/no-file.png') }}" alt="Imagen de Not Found"
                                title="Imagen de Not Found">
                            <p class="ped-insumos__empty-text">No hay documentos de Fichas de Indicadores disponibles en este
                                momento.</p>
                        </div>
                    @else
                        <div class="pmd-list-section">
                            <ul class="list-group list-group-flush">
                                @foreach ($fichasIndicadores as $documento)
                                    <li class="document-item">
                                        <div class="document-item__main-content">
                                            <p class="document-item__name">
                                                {{ $documento->titulo }}
                                            </p>
                                            @if ($documento->formato === 'pdf')
                                                <span class="document-badge badge-pdf">PDF</span>
                                            @else
                                                <span class="document-badge badge-xls">EXCEL</span>
                                            @endif
                                        </div>

                                        <div class="document-item__actions">
                                            @if ($documento->formato === 'pdf')
                                                <a href="#" class="js-open-modal"
                                                    data-src="{{ asset('insumos-ped/' . $documento->ruta_documento) }}"
                                                    data-title="{{ $documento->titulo }}" title="Ver documento">
                                                    <i class="fas fa-eye"></i> <span>Ver aquí</span>
                                                </a>
                                            @endif
                                            <a href="{{ asset('insumos-ped/' . $documento->ruta_documento) }}" target="_blank"
                                                rel="noopener noreferrer" title="Abrir en nueva pestaña">
                                                <i class="fas fa-external-link-alt"></i> <span>Abrir</span>
                                            </a>
                                            <a href="{{ asset('insumos-ped/' . $documento->ruta_documento) }}" download
                                                rel="noopener" title="Descargar documento">
                                                <i class="fas fa-download"></i> <span>Descargar</span>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
