@extends('layouts.plantilla')
@section('title', 'Marco Jurídico')
@section('meta-description',
    'Documentos que conforman el marco jurídico del Sistema Estatal de Planeación Democrática
    del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Marco Jurídico - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Bienvenido a la página del Marco Jurídico del Sistema Estatal de Planeación Democrática del
    Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'Marco Jurídico - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Bienvenido a la página del Marco Jurídico del Sistema Estatal de Planeación Democrática
    del Estado de Puebla.')

@section('css')
@endsection

@section('content')
    <section class="contenedor-imagen-marco">
        <h1>Marco Jurídico</h1>
    </section>
    <section class="documentos-marco">
        <div class="container py-2">
            <div class="col">
                <div class="text-center mb-3 pb-3">
                    <p class="text-black pt-3">Conjunto de leyes, regulaciones y normativas que establecen principios,
                        objetivos y procedimientos en materia de planeación en el marco estatal</p>
                </div>
            </div>
            <div class="contenedor-flex w-100">
                <div class="container">
                    @if ($documentos->isEmpty())
                        <div class="container flex-container-centro">
                            <img src="{{ asset('imagen/no-file.png') }}" alt="Imagen de Not Found"
                                title="Imagen de Not Found" class="w-40p">
                            <p class="text-black text-center pb-5">Upps, no se encontraron documentos del marco
                                jurídico.</p>
                        </div>
                    @else
                        <!-- Grid de Tarjetas para cada Ámbito -->
                        <div class="row justify-content-center mb-5">
                            @foreach ($documentos as $ambito => $tiposDocumento)
                                @php
                                    $ambitoId = Str::slug($ambito);
                                    $primeroDoc = $tiposDocumento->flatten()->first();
                                    $ambitoModel = optional(optional($primeroDoc)->clasificacion)->ambito;
                                    
                                    $portadaSrc = asset('imagen/no-file.png');
                                    if ($ambitoModel && $ambitoModel->portada) {
                                        $portadaSrc = asset('portadas-marcojuridico/' . $ambitoModel->portada);
                                    } elseif ($primeroDoc && $primeroDoc->portada) {
                                        $portadaSrc = asset('portadas-marcojuridico/' . $primeroDoc->portada);
                                    }
                                @endphp
                                <div class="container px-4 col-12 col-lg-3 col-md-6 mb-4">
                                    <div class="tarjeta-marco tarjeta-marco--trigger"
                                         data-bs-toggle="collapse"
                                         data-bs-target="#collapseAmbito-{{ $ambitoId }}"
                                         aria-expanded="false"
                                         aria-controls="collapseAmbito-{{ $ambitoId }}"
                                         role="button">
                                        <div class="imagen">
                                            <img src="{{ $portadaSrc }}"
                                                alt="Portada de {{ $ambito }}"
                                                title="{{ $ambito }}">
                                        </div>
                                        <div class="contenedor-boton">
                                            <div class="btn-descargar m-0 w-100 justify-content-between px-3">
                                                <span class="btn-descargar__texto">{{ $ambito }}</span>
                                                <span class="btn-descargar__icono">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" width="20px" height="20px">
                                                        <path d="M12 15.586l-4.293-4.293a1 1 0 0 1 1.414-1.414L11 11.586V4a1 1 0 0 1 2 0v7.586l1.879-1.879a1 1 0 0 1 1.414 1.414L12 15.586z" />
                                                        <path d="M18 21H6a3 3 0 0 1-3-3V11a1 1 0 0 1 2 0v7a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-7a1 1 0 0 1 2 0v7a3 3 0 0 1-3 3z" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Secciones colapsables que contienen los acordeones de los Subtipos -->
                        <div class="row w-100 m-0">
                            @foreach ($documentos as $ambito => $tiposDocumento)
                                @php
                                    $ambitoId = Str::slug($ambito);
                                @endphp
                                <div class="collapse col-12 mb-4" id="collapseAmbito-{{ $ambitoId }}" data-bs-parent=".documentos-marco">
                                    <div class="p-4 bg-white rounded-3 shadow-sm border">
                                        <h3 class="text-black h5 mb-3">Ámbito: {{ $ambito }}</h3>
                                        
                                        <div class="accordion accordion-marco" id="accordionSubtipos-{{ $ambitoId }}">
                                            @foreach ($tiposDocumento as $tipoDocumento => $docs)
                                                @php
                                                    $tipoId = Str::slug($ambito . '-' . $tipoDocumento);
                                                @endphp
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading-{{ $tipoId }}">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse-{{ $tipoId }}" aria-expanded="false"
                                                            aria-controls="collapse-{{ $tipoId }}">
                                                            <strong>{{ $tipoDocumento }}</strong>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse-{{ $tipoId }}" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-{{ $tipoId }}" data-bs-parent="#accordionSubtipos-{{ $ambitoId }}">
                                                        <div class="accordion-body bg-white">
                                                            <ul class="list-group list-group-flush p-0 m-0">
                                                                @foreach ($docs as $documento)
                                                                    <li class="document-item">
                                                                        <div class="document-item__main-content">
                                                                            <p class="document-item__name js-ver-documento m-0"
                                                                                data-src="{{ asset('marco-juridico/' . $documento->ruta_documento) }}"
                                                                                data-title="{{ $documento->nombre }}">
                                                                                {{ $documento->nombre }}
                                                                            </p>
                                                                            <span class="document-badge badge-pdf">{{ strtoupper(pathinfo($documento->ruta_documento, PATHINFO_EXTENSION)) }}</span>
                                                                        </div>
                                                                        <div class="document-item__actions">
                                                                            <a href="#" class="js-ver-documento"
                                                                                data-src="{{ asset('marco-juridico/' . $documento->ruta_documento) }}"
                                                                                data-title="{{ $documento->nombre }}" title="Ver documento">
                                                                                <i class="fas fa-eye"></i> <span>Ver aquí</span>
                                                                            </a>
                                                                            <a href="{{ asset('marco-juridico/' . $documento->ruta_documento) }}"
                                                                                target="_blank" rel="noopener noreferrer"
                                                                                title="Abrir en nueva pestaña">
                                                                                <i class="fas fa-external-link-alt"></i> <span>Abrir</span>
                                                                            </a>
                                                                            <a href="{{ asset('marco-juridico/' . $documento->ruta_documento) }}"
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
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if ($documentos->isNotEmpty())
                        @php
                            $ultimaActualizacion = $documentos->flatten(2)->max('updated_at');
                        @endphp
                        <p class="text-black small">Última actualización:
                            {{ $ultimaActualizacion->format('d/m/Y H:i:s') }} UTC</p>
                    @else
                        <p class="text-black small">Última actualización:
                            No hay información disponible.</p>
                        <p>
                    @endif
                </div>
            </div>
            <div class="container pt-5">
                <h3 class="subtitulo_sitios">Para más información consulte el</h3>
                <div class="flex-container-centro">
                    <a class="d-flex justify-content-center" href="https://ojp.puebla.gob.mx/" target="_blank"
                        rel="noopener">
                        <img class="img-fluid w-50" src="{{ asset('imagen/ojp.png') }}"
                            alt="Logo del Orden Jurídico Poblano" title="Logo del Orden Jurídico Poblano">
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
