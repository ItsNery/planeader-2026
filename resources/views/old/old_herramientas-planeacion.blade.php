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
                <div class="mx-auto px-4 py-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="contenedor-tarjetadocs">
                        <img src="{{ asset('imagen/SEATI-VF.jpg') }}" alt="Portada de Índice" class="width-100"
                            title="Índice SEATI">
                        <a class="btn boton-tarjetadocs" href="{{ asset('documentos/SEATI-VF.pdf') }}" download
                            rel="noopener">
                            Descarga <i class="fas fa-download"></i>
                            <i class="fas fa-file-pdf pdf"></i>
                        </a>
                    </div>
                </div>
                <div class="mx-auto px-4 py-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="contenedor-tarjetadocs">
                        <img src="{{ asset('imagen/Criterios_de_priorización.jpg') }}"
                            alt="Portada de Criterios de Priorización" class="width-100" title="Criterios de Priorización">
                        <a class="btn boton-tarjetadocs" href="{{ asset('documentos/Criterios_de_priorización.pdf') }}"
                            download rel="noopener">
                            Descarga <i class="fas fa-download"></i>
                            <i class="fas fa-file-pdf pdf"></i>
                        </a>
                    </div>
                </div>
                <div class="mx-auto px-4 py-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="contenedor-tarjetadocs">
                        <img src="{{ asset('imagen/Reporte_de_Analisis_Regional_para_la_Priorizacion_de_la_Inversion_Publica.webp') }}"
                            alt="Portada de Criterios de Priorización" class="width-100" title="Criterios de Priorización">
                        <a class="btn boton-tarjetadocs" href="{{ asset('documentos/Reporte_de_Analisis_Regional_para_la_Priorizacion_de_la_Inversion_Publica.pdf') }}"
                            download rel="noopener">
                            Descarga <i class="fas fa-download"></i>
                            <i class="fas fa-file-pdf pdf"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 titulo-tematica">
                    Anexos del Índice SEATI
                </div>
                <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="contenedor-tarjetadocs-compacta">
                        <p class="titulo-documento-compacta">Anexo 1. Encuesta Municipal</p> <a
                            href="{{ asset('documentos/seati/Anexo_1._Encuesta_Municipal.pdf') }}"
                            class="boton-descargar-compacta" download="" rel="noopener"> <i
                                class="fas fa-file-pdf pdf"></i>
                            Descargar
                        </a>
                    </div>
                </div>
                <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="contenedor-tarjetadocs-compacta">
                        <p class="titulo-documento-compacta">Anexo 2. Análisis de los indicadores seleccionados
                        </p> <a
                            href="{{ asset('documentos/seati/Anexo_2._Análisis_de_los_indicadores_seleccionados.pdf') }}"
                            class="boton-descargar-compacta" download="" rel="noopener"> <i
                                class="fas fa-file-pdf pdf"></i>
                            Descargar
                        </a>
                    </div>
                </div>
                <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="contenedor-tarjetadocs-compacta">
                        <p class="titulo-documento-compacta">Anexo 3. Códigos</p> <a
                            href="{{ asset('documentos/seati/Anexo_3._Códigos.rar') }}" class="boton-descargar-compacta"
                            download="" rel="noopener"> <i class="fas fa-file-zipper"></i> Descargar
                        </a>
                    </div>
                </div>
                <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="contenedor-tarjetadocs-compacta">
                        <p class="titulo-documento-compacta">Anexo 4. Matriz de Comparación Regional</p> <a
                            href="{{ asset('documentos/seati/Anexo_4._Matriz_de_Comparación_Regional.pdf') }}"
                            class="boton-descargar-compacta" download="" rel="noopener"> <i
                                class="fas fa-file-pdf pdf"></i>
                            Descargar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
@endsection
