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
                    <div class="mx-auto px-4 py-4 col-12 col-md-6 col-lg-3">
                        <x-tarjeta-documento 
                            :titulo="$herramienta->titulo"
                            :imagen="$herramienta->imagen"
                            :archivo="$herramienta->archivo"
                        />

                        @if ($herramienta->anexos->isNotEmpty())
                            <div class="w-100 text-center mt-3">
                                <button class="btn btn-sm btn-outline-secondary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#anexos-{{ $herramienta->id }}" aria-expanded="false" aria-controls="anexos-{{ $herramienta->id }}" style="border-radius: 20px;">
                                    Ver {{ $herramienta->anexos->count() }} Anexos <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                            <div class="collapse w-100 mt-3" id="anexos-{{ $herramienta->id }}">
                                <div class="anexos-container">
                                    <div class="row">
                                        @foreach ($herramienta->anexos as $anexo)
                                            <div class="col-12 mb-3">
                                                <div class="contenedor-tarjetadocs-compacta">
                                                    <p class="titulo-documento-compacta text-center mb-2">{{ $anexo->titulo }}</p>
                                                    <a href="javascript:void(0);"
                                                        class="boton-descargar-compacta btn btn-sm btn-block text-center"
                                                        onclick="openModal('{{ asset('documentos/herramientas/anexos/' . $anexo->archivo) }}', '{{ $anexo->titulo }}')">
                                                        <i class="fas fa-file-pdf pdf"></i> Ver / Descargar
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
@section('scripts')

@endsection
