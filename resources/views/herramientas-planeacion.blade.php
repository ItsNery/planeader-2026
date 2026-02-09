@extends('layouts.plantilla')
@section('title', 'Herramientas de Planeación')
@section('meta-description',
    'Bienvenido al apartado de Herramientas de Planeación, donde podras consultar los
    instrumentos encaminados a brindar un apoyo a la planeación estratégica, dentro del Portal de Planeación para el
    Desarrollo')
@section('canonical-url', url()->current())
@section('og-title', 'Herramientas de Planeación')
@section('og-description',
    'Bienvenido al apartado de Herramientas de Planeación, donde podras consultar los
    instrumentos encaminados a brindar un apoyo a la planeación estratégica, dentro del Portal de Planeación para el
    Desarrollo')
@section('og:url', url()->current())
@section('twitter-title', 'Herramientas de Planeación')
@section('twitter-description',
    'Bienvenido al apartado de Herramientas de Planeación, donde podras consultar los
    instrumentos encaminados a brindar un apoyo a la planeación estratégica, dentro del Portal de Planeación para el
    Desarrollo')
@section('css')
    <style>
    </style>
@endsection
@section('jss')
@endsection
@section('content')
    <section class="contenedor-imagen-herramientas-plan">
        <h1>Herramientas de planeación</h1>
    </section>
    <section class="herramientas-planeacion">
        <div class="container">
            <p class="corra-light text-justify my-5">
                Descubre las herramientas de planeación que la Dirección de Planeación y Desarrollo pone a tu
                disposición.
            </p>
            <div class="row my-5">
                @foreach ($herramientas as $herramienta)
                    <div class="mx-auto px-4 py-4 col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="contenedor-tarjetadocs">
                            @if ($herramienta->imagen)
                                <img src="{{ asset('imagen/herramientas/' . $herramienta->imagen) }}"
                                    alt="Portada de {{ $herramienta->titulo }}" class="width-100"
                                    title="{{ $herramienta->titulo }}">
                            @else
                                <img src="{{ asset('imagen/SEATI-VF.jpg') }}" alt="Portada default" class="width-100"
                                    title="{{ $herramienta->titulo }}">
                            @endif
                            <a class="btn boton-tarjetadocs"
                                href="{{ asset('documentos/herramientas/' . $herramienta->archivo) }}" download
                                rel="noopener">
                                Descarga <i class="fas fa-download"></i>
                                <i class="fas fa-file-pdf pdf"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @foreach ($herramientas as $herramienta)
                @if ($herramienta->anexos->count() > 0)
                    <div class="row">
                        <div class="col-12 titulo-tematica">
                            Anexos de: {{ $herramienta->titulo }}
                        </div>
                        @foreach ($herramienta->anexos as $anexo)
                            <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="contenedor-tarjetadocs-compacta">
                                    <p class="titulo-documento-compacta">{{ $anexo->titulo }}</p>
                                    <a href="{{ asset('documentos/herramientas/anexos/' . $anexo->archivo) }}"
                                        class="boton-descargar-compacta" download="" rel="noopener">
                                        <i class="fas fa-file-pdf pdf"></i>
                                        Descargar
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endsection
@section('scripts')
@endsection
