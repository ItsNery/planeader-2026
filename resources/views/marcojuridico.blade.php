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
            <div class="contenedor-flex">
                <div class="container row">
                    @if ($documentos->isEmpty())
                        <div class="container flex-container-centro">
                            <img src="{{ asset('imagen/no-file.png') }}" alt="Imagen de Not Found"
                                title="Imagen de Not Found" class="w-40p">
                            <p class="text-black text-center pb-5">Upps, no se encontraron documentos del marco
                                jurídico.</p>
                        </div>
                    @else
                        @foreach ($documentos as $tipo => $docs)
                            <div class="contenedor-tipo">
                                <h2 class="contenedor-titulo">{{ $tipo }}</h2>
                            </div>
                            <div class="row">
                                @foreach ($docs as $documento)
                                    <div class="container px-4 col-12 col-lg-3 col-md-6">
                                        <div class="tarjeta-marco">
                                            <div class="imagen">
                                                <img src="{{ asset('portadas-marcojuridico/' . $documento->portada) }}"
                                                    alt="Portada de {{ $documento->nombre }}"
                                                    title="{{ $documento->nombre }}">
                                            </div>
                                            <div class="contenedor-boton">
                                                <a href="{{ asset('marco-juridico/' . $documento->ruta_documento) }}"
                                                    target="_blank" class="btn-descargar" title="{{ $documento->nombre }}">
                                                    <span class="btn-descargar__texto">Consultar documento</span>
                                                    <span class="btn-descargar__icono">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="currentColor">
                                                            <path
                                                                d="M12 15.586l-4.293-4.293a1 1 0 0 1 1.414-1.414L11 11.586V4a1 1 0 0 1 2 0v7.586l1.879-1.879a1 1 0 0 1 1.414 1.414L12 15.586z" />
                                                            <path
                                                                d="M18 21H6a3 3 0 0 1-3-3V11a1 1 0 0 1 2 0v7a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-7a1 1 0 0 1 2 0v7a3 3 0 0 1-3 3z" />
                                                        </svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                    @if ($docs->isNotEmpty())
                        @php
                            $ultimaActualizacion = $docs->max('updated_at');
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
