@extends('layouts.plantilla')
@section('title', 'Inicio')
@section('meta-description', 'Página principal del Sistema Estatal de Planeación Democrática del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Inicio - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Bienvenido a la página de inicio del Sistema Estatal de Planeación Democrática del Estado de
    Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'Inicio - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Bienvenido a la página de inicio del Sistema Estatal de Planeación Democrática del
    Estado de Puebla.')
@section('css')
@endsection
@section('content')
    {{-- <script>
        (function(d, w, c) {
            w.ChatraID = 'DGbhKob3ckcWLhwPx';
            var s = d.createElement('script');
            w[c] = w[c] || function() {
                (w[c].q = w[c].q || []).push(arguments);
            };
            s.async = true;
            s.src = 'https://call.chatra.io/chatra.js';
            if (d.head) d.head.appendChild(s);
        })(document, window, 'Chatra');
    </script> --}}

    <section class="carrusel">
        <div class="container-fluid p-0">
            <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @if ($banners && count($banners) > 0)
                        @foreach ($banners as $banner)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <a href="{{ $banner->enlace }}" target="_blank" title="{{ $banner->nombre }}" rel="noopener">
                                    <img class="w-100 imagen-banner-planeader" src="/baners/{{ $banner->imagen }}"
                                        alt="{{ $banner->nombre }}">
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="carousel-item active">
                            <a href="#" rel="noopener" title="Baner por defecto del Planeader">
                                <img class="w-100 imagen-banner-planeader" src="/baners/20240411231551.png" alt="Image">
                            </a>
                        </div>
                    @endif
                </div>
                @if ($banners && count($banners) > 1)
                    <a title="Boton de previo" class="carousel-control-prev" href="#header-carousel" data-bs-slide="prev">
                        <div class="btn previo_next">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a title="Siguiente slider" class="carousel-control-next" href="#header-carousel" data-bs-slide="next">
                        <div class="btn previo_next">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </section>
    <section class="inicio-planeader">
        <div class="container text-center my-5">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="titulo-inicio mb-4">
                        <h1>Bienvenido al Planeader</h1>
                        <h2 class="text-center">Portal de Planeación para el Desarrollo del Estado de Puebla</h2>
                    </div>

                    <div class="boton-ped mb-4">
                        <video autoplay loop muted playsinline class="img-fluid">
                            <source src="{{ asset('video/hero-video.mp4') }}" type="video/mp4">
                            <img src="{{ asset('img/logo-ped.png') }}" alt="Imagotipo del Plan Estatal de Desarrollo"
                                title="Imagotipo del PED" class="img-fluid">
                        </video>
                        <p class="mt-3">
                            Documento rector que establece los principios básicos sobre los cuales se llevará a cabo la
                            Planeación del Desarrollo en el estado de Puebla y que orienta el funcionamiento de la
                            Administración Pública Estatal.
                        </p>
                    </div>

                    <div class="contenedor-boton">
                        <a href="{{ url('/ped') }}" target="_self" class="btn-descargar" title="PED 2024-2030">
                            <span class="btn-descargar__texto">Saber más</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-12 col-md-6 mb-4">
                    <div class="tarjeta-uniforme h-100">
                        <div class="icono-seccion">
                            <img src="{{ asset('img/iconos-inicio/PlanesMun.png') }}" alt="Icono de Planes Municipales">
                        </div>
                        <div class="titulo-inicio-2">
                            <h3>Planes Municipales de Desarrollo</h3>
                            <p>
                                Documentos rectores que estableces los principios básicos sobre los cuales se llevará a cabo
                                la
                                Planeación del Desarrollo Municipal y que orientan el funcionamiento de la Administración
                                Pública Municipal.
                            </p>
                        </div>

                        <div class="contenedor-boton">
                            <a href="{{ url('/planesmunicipales') }}" target="_self" class="btn-descargar"
                                title="Planes Municipales de Desarrollo">
                                <span class="btn-descargar__texto">Saber más</span>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="tarjeta-uniforme h-100">
                        <div class="icono-seccion">
                            <img src="{{ asset('img/iconos-inicio/Programas-Derivados.png') }}"
                                alt="Icono de Planes Municipales">
                        </div>
                        <div class="titulo-inicio-2">
                            <h3>Programas Derivados</h3>
                            <p>
                                Documentos de planeación que permiten coadyuvar al cumplimiento de los objetivos y metas del
                                Plan Estatal de Desarrollo
                            </p>
                        </div>

                        <div class="contenedor-boton">
                            <a href="{{ url('/ped-programas') }}" target="_self" class="btn-descargar"
                                title="Programas Derivados">
                                <span class="btn-descargar__texto">Saber más</span>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="tarjeta-uniforme h-100">
                        <div class="icono-seccion">
                            <img src="{{ asset('img/iconos-inicio/Copladep-min.png') }}" alt="Icono del COPLADEP">
                        </div>
                        <div class="titulo-inicio-2">
                            <h3>COPLADEP</h3>
                            <p>
                                Comité de Planeación para el Desarrollo del Estado de Puebla
                            </p>
                        </div>

                        <div class="contenedor-boton">
                            <a href="{{ url('/copladep') }}" target="_self" class="btn-descargar" title="COPLADEP">
                                <span class="btn-descargar__texto">Saber más</span>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="tarjeta-uniforme h-100">
                        <div class="icono-seccion">
                            <img src="{{ asset('img/iconos-inicio/Subcomites.png') }}" alt="Icono de Subcomités">
                        </div>
                        <div class="titulo-inicio-2">
                            <h3>Subcomités</h3>
                            <p>
                                Órganos auxiliares del COPLADEP: Subcomités Sectoriales, Especiales y Regional
                            </p>
                        </div>

                        <div class="contenedor-boton">
                            <a href="{{ url('/subcomites') }}" target="_self" class="btn-descargar" title="Subcomites">
                                <span class="btn-descargar__texto">Saber más</span>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="tarjeta-uniforme h-100">
                        <div class="icono-seccion">
                            <img src="{{ asset('img/iconos-inicio/Coplademun.png') }}" alt="Icono de COPLADEMUN">
                        </div>
                        <div class="titulo-inicio-2">
                            <h3>COPLADEMUN</h3>
                            <p>
                                Órganos de participación social y consulta en materia de planeación y programación del
                                desarrollo municipal
                            </p>
                        </div>

                        <div class="contenedor-boton">
                            <a href="{{ url('/coplademun') }}" target="_self" class="btn-descargar" title="COPLADEMUN">
                                <span class="btn-descargar__texto">Saber más</span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
@endpush
