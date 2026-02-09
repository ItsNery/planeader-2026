@extends('layouts.plantilla')
@section('title', 'COPLADEMUN')
@section('meta-description',
    'Visión general del Comité de Planeación Municipal del Sistema Estatal de Planeación
    Democrática del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'COPLADEMUN - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Bienvenido a la página de visión general del Comité de Planeación Municipal del Sistema
    Estatal de Planeación Democrática del Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'COPLADEMUN - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Bienvenido a la página de visión general del Comité de Planeación Municipal del Sistema
    Estatal de Planeación Democrática del Estado de Puebla.')
@section('css')
@endsection
@section('content')
    <section class="contenedor-imagen-coplademun">
        <h1>COPLADEMUN</h1>
    </section>
    <section class="coplademun">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="titulo-tematica">
                        ¿Qué es el COPLADEMUN?
                    </div>
                    <div class="col-12">
                        <p class="text-justify">
                            El Comité de Planeación para el Desarrollo Municipal (COPLADEMUN) es el órgano
                            de participación social y consulta constituido por el ayuntamiento en materia de
                            planeación y programación del desarrollo municipal, el cual contará con la
                            intervención de los sectores público, social y privado en atención de las
                            necesidades de su población. El COPLADEMUN tiene como objetivos:
                        </p>
                        <ul>
                            <li class="text-justify">
                                Instrumentar y dar seguimiento al Plan Municipal de Desarrollo;
                            </li>
                            <li class="text-justify">
                                Atender las demandas del municipio, guardando congruencia con el Plan
                                Nacional, Estatal y Municipal, así como;
                            </li>
                            <li class="text-justify">
                                Planear, discutir, analizar y seleccionar las obras y acciones a realizar
                                para el desarrollo municipal.
                            </li>
                        </ul>
                        <p class="text-justify">
                            Entre las funciones del COPLADEMUN se encuentran, promover los objetivos,
                            estrategias y acciones del Fondo de Aportaciones para la Infraestructura Social
                            Municipal (FAISMUN); proponer, determinar y dar seguimiento a las obras y
                            acciones a ejecutar con recursos del FAISMUN; así como Impulsar la participación
                            social en la planeación y desarrollo de los programas y acciones que se
                            instrumenten.
                        </p>

                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="titulo-tematica">
                        Integrantes
                    </div>
                </div>
                <div class="col-12">
                    <img src="{{ asset('img/integracioncoplademun.png') }}" alt="Esquema de la conformación del Coplademun"
                        title="Conformación del Coplademun" class="esquema-visual">
                </div>
            </div>
        </div>
        <div class="container-fluid services py-5">
            <div class="container">

                <div class="container">
                    <div class="container mx-auto px-2">
                        <h3 class="titulo-tematica">
                            Documentos de apoyo
                        </h3>
                    </div>
                    <div class="container mx-auto py-1">
                        <p class="text-black text-center">A fin de brindar herramientas de apoyo a los municipios se
                            pone a disposición cuatro plantillas de actas para las sesiones ordinarias del
                            COPLADEMUN
                        </p>
                    </div>
                    <div class="container row">
                        @foreach ($documentos as $documento)
                            <div class="mx-auto px-4 py-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                <div class="contenedor-tarjetadocs">
                                    <img src="{{ asset('imagen/apoyo-coplademun/' . $documento->imagen) }}"
                                        alt="Portada de {{ $documento->titulo }}" class="width-100"
                                        title="{{ $documento->titulo }}">
                                    <a class="btn boton-tarjetadocs"
                                        href="{{ asset('documentos/apoyo-coplademun/' . $documento->ruta_documento) . '?v=' . $documento->updated_at->timestamp }}"
                                        download="{{ $documento->titulo }}" rel="noopener" title="{{ $documento->titulo }}">
                                        Descarga <i class="fas fa-download"></i>
                                        <i class="fa-regular fa-file-word"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="coplademun-agendar">
        <div class="col py-4">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-dark text-uppercase h6_planeader">¿Quieres conocer nuestros próximos eventos?</h6>
                <h2 class="subtitulo_sitios text-dark">
                    Usa nuestro calendario para enterarte
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <div class="container">
                    <iframe
                        src="https://calendar.google.com/calendar/embed?height=600&wkst=1&ctz=America%2FMexico_City&bgcolor=%23ffffff&hl=es_419&src=MzljNGIyMzEwNGNjYjRkOGM4YzIyMDNiYzI4NzEwMGUwOTJiZmU2YTAyZWQ1Mzg2NTZjNTFmZTUxNzUxZjdmY0Bncm91cC5jYWxlbmRhci5nb29nbGUuY29t&src=aHQzamxmYWFjNWxmZDYyNjN1bGZoNHRxbDhAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ&color=%23E67C73&color=%23B39DDB"
                        style="border:solid 1px #777" class="w-100" height="600"></iframe>
                </div>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </section>
@endsection
@section('scripts')
@endsection
