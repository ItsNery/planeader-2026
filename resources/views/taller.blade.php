@extends('layouts.plantilla')
@section('title', 'Taller de Planeación Estratégica')
@section('meta-description', 'Taller de Planeación Estratégica a Funcionaros de la Administración Públic Estatal')
@section('canonical-url', url()->current())
@section('og-title', 'Taller de Planeación Estratégica')
@section('og-description',
    'Bienvenido a la página de del Taller de Planeación Estratégica a Funcionaros de la
    Administración Públic Estatal')
@section('og:url', url()->current())
@section('twitter-title', 'Taller de Planeación Estratégica a Funcionaros de la Administración Públic Estatal')
@section('twitter-description',
    'Bienvenido a la página de del Taller de Planeación Estratégica a Funcionaros de la
    Administración Públic Estatal')
@section('css')
@endsection
@section('content')
    <script>
        function openModal(url, title) {
            var modal = document.getElementById('myModal');
            var modalIframe = document.getElementById('modalIframe');
            var modalTitle = document.getElementById('modalTitle');

            modalIframe.src = url;
            modalTitle.textContent = title;
            modal.style.display = 'block';
        }

        function closeModal() {
            var modal = document.getElementById('myModal');
            modal.style.display = 'none';
        }
    </script>
    <section id="contact">
        <div class="container-fluid bg-breadcrumb-contacto">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h1 class="text-white text-bold display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s"
                    style="text-shadow: 1px 1px 2px black;">
                    Taller de Planeación Estratégica
                </h1>
                <ol class="breadcrumb justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}" class="text-white">
                            Inicio
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" class="text-white">
                            Taller
                        </a>
                    </li>
                </ol>
            </div>
        </div>
        <div class="container-fluid contact overflow-hidden py-5">

            <h2 class="text-center">Lunes 12 de mayo de 2025</h2>

            <div class="container py-5">

                <div class="row">
                    <div class="container mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjetadocs">
                                <div class="front">
                                    <div class="atras">
                                        <img src="{{ asset('portadas-taller/portada1.png') }}"
                                            alt="Portada de Documento Taller de Planeación Estratégica"
                                            title="Taller de Planeación Estratégica" class="width-100">
                                    </div>
                                </div>
                                <div class="back">
                                    <img src="{{ asset('imagen/ver-archivo.png') }}" alt="Icono de Ver Archivo"
                                        title="Icono de Ver Archivo" class="width-100">
                                    <button class="btn boton-neumorfo no_s"
                                        onclick="openModal('{{ asset('documentos/talleres/presentacion_c.pdf') }}', 'Taller de Planeación Estratégica')">Ver
                                        <i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <a class="btn boton-tarjetadocs" href="{{ asset('documentos/talleres/presentacion_c.pdf') }}"
                                download="" rel="noopener" title="Taller de Planeación Estratégica">
                                Descarga <i class="fas fa-download"></i>
                                <img class="justify-items-center w-10p" src="{{ asset('imagen/pdf.png') }}"
                                    alt="imagen de icono PDF" title="Imagen de icono PDF">
                            </a>
                        </div>
                    </div>
                    {{-- <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjeta-herramientas">
                                <p class="titulo-documento">Taller de Planeación Estratégica</p>
                                <a href="{{ asset('documentos/talleres/presentacion_c.pdf') }}"
                                    class="boton boton-descargar" target="_blank" rel="noopener">
                                    Ver
                                </a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="container mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjetadocs">
                                <div class="front">
                                    <div class="atras">
                                        <img src="{{ asset('portadas-taller/portada2.png') }}"
                                            alt="Portada de Documento Planeación Estratégica del GEP"
                                            title="Planeación Estratégica del GEP" class="width-100">
                                    </div>
                                </div>
                                <div class="back">
                                    <img src="{{ asset('imagen/ver-archivo.png') }}" alt="Icono de Ver Archivo"
                                        title="Icono de Ver Archivo" class="width-100">
                                    <button class="btn boton-neumorfo no_s"
                                        onclick="openModal('{{ asset('documentos/talleres/curso_planeacion_estrategica_gabinetes.pdf') }}', 'Planeación Estratégica del GEP')">Ver
                                        <i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <a class="btn boton-tarjetadocs"
                                href="{{ asset('documentos/talleres/curso_planeacion_estrategica_gabinetes.pdf') }}"
                                download="" rel="noopener" title="Planeación Estratégica del GEP">
                                Descarga <i class="fas fa-download"></i>
                                <img class="justify-items-center w-10p" src="{{ asset('imagen/pdf.png') }}"
                                    alt="imagen de icono PDF" title="Imagen de icono PDF">
                            </a>
                        </div>
                    </div>
                    {{-- <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjeta-herramientas">
                                <p class="titulo-documento">Planeación Estratégica del GEP</p>
                                <a href="{{ asset('documentos/talleres/curso_planeacion_estrategica_gabinetes.pdf') }}"
                                    class="boton boton-descargar" target="_blank" rel="noopener">
                                    Ver
                                </a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="container mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjetadocs">
                                <div class="front">
                                    <div class="atras">
                                        <img src="{{ asset('portadas-taller/portada3.png') }}"
                                            alt="Portada de Documento Buen Gobierno en Puebla"
                                            title="Buen Gobierno en Puebla" class="width-100">
                                    </div>
                                </div>
                                <div class="back">
                                    <img src="{{ asset('imagen/ver-archivo.png') }}" alt="Icono de Ver Archivo"
                                        title="Icono de Ver Archivo" class="width-100">
                                    <button class="btn boton-neumorfo no_s"
                                        onclick="openModal('{{ asset('documentos/talleres/presentacion_buengobierno_vf.pdf') }}', 'Buen Gobierno en Puebla')">Ver
                                        <i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <a class="btn boton-tarjetadocs"
                                href="{{ asset('documentos/talleres/presentacion_buengobierno_vf.pdf') }}" download=""
                                rel="noopener" title="Buen Gobierno en Puebla">
                                Descarga <i class="fas fa-download"></i>
                                <img class="justify-items-center w-10p" src="{{ asset('imagen/pdf.png') }}"
                                    alt="imagen de icono PDF" title="Imagen de icono PDF">
                            </a>
                        </div>
                    </div>
                    {{-- <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjeta-herramientas">
                                <p class="titulo-documento">BUEN GOBIERNO EN PUEBLA</p>
                                <a href="{{ asset('documentos/talleres/presentacion_buengobierno_vf.pdf') }}"
                                    class="boton boton-descargar" target="_blank" rel="noopener">
                                    Ver
                                </a>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>

            <h2 class="text-center">Martes 13 de mayo de 2025</h2>

            <div class="container py-5">

                <div class="row">
                    <div class="container mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjetadocs">
                                <div class="front">
                                    <div class="atras">
                                        <img src="{{ asset('portadas-taller/portada4.png') }}"
                                            alt="Portada de Documento Presentación del Plan Estatal de Desarrollo 2024-2030"
                                            title="Presentación del Plan Estatal de Desarrollo 2024-2030" class="width-100">
                                    </div>
                                </div>
                                <div class="back">
                                    <img src="{{ asset('imagen/ver-archivo.png') }}" alt="Icono de Ver Archivo"
                                        title="Icono de Ver Archivo" class="width-100">
                                    <button class="btn boton-neumorfo no_s"
                                        onclick="openModal('{{ asset('documentos/talleres/prsentacion_ped.pdf') }}', 'Presentación del Plan Estatal de Desarrollo 2024-2030')">Ver
                                        <i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <a class="btn boton-tarjetadocs"
                                href="{{ asset('documentos/talleres/prsentacion_ped.pdf') }}" download=""
                                rel="noopener" title="Presentación del Plan Estatal de Desarrollo 2024-2030">
                                Descarga <i class="fas fa-download"></i>
                                <img class="justify-items-center w-10p" src="{{ asset('imagen/pdf.png') }}"
                                    alt="imagen de icono PDF" title="Imagen de icono PDF">
                            </a>
                        </div>
                    </div>
                    {{-- <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjeta-herramientas">
                                <p class="titulo-documento">Presentación del Plan Estatal de Desarrollo 2024-2030</p>
                                <a href="{{ asset('documentos/talleres/prsentacion_ped.pdf') }}"
                                    class="boton boton-descargar" target="_blank" rel="noopener">
                                    Ver
                                </a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="container mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjetadocs">
                                <div class="front">
                                    <div class="atras">
                                        <img src="{{ asset('portadas-taller/portada5.png') }}"
                                            alt="Portada de Documento Articulación del Plan Estatal de Desarrollo 2024-2030"
                                            title="Articulación del Plan Estatal de Desarrollo 2024-2030" class="width-100">
                                    </div>
                                </div>
                                <div class="back">
                                    <img src="{{ asset('imagen/ver-archivo.png') }}" alt="Icono de Ver Archivo"
                                        title="Icono de Ver Archivo" class="width-100">
                                    <button class="btn boton-neumorfo no_s"
                                        onclick="openModal('{{ asset('documentos/talleres/articulacion_ped.pdf') }}', 'Articulación del Plan Estatal de Desarrollo 2024-2030')">Ver
                                        <i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <a class="btn boton-tarjetadocs"
                                href="{{ asset('documentos/talleres/articulacion_ped.pdf') }}" download=""
                                rel="noopener" title="Articulación del Plan Estatal de Desarrollo 2024-2030">
                                Descarga <i class="fas fa-download"></i>
                                <img class="justify-items-center w-10p" src="{{ asset('imagen/pdf.png') }}"
                                    alt="imagen de icono PDF" title="Imagen de icono PDF">
                            </a>
                        </div>
                    </div>
                    {{-- <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjeta-herramientas">
                                <p class="titulo-documento">Articulación del Plan Estatal de Desarrollo 2024-2030</p>
                                <a href="{{ asset('documentos/talleres/articulacion_ped.pdf') }}"
                                    class="boton boton-descargar" target="_blank" rel="noopener">
                                    Ver
                                </a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="container mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjetadocs">
                                <div class="front">
                                    <div class="atras">
                                        <img src="{{ asset('portadas-taller/portada6.png') }}"
                                            alt="Portada de Documento Taller de Procedimientos de Adquisiciones"
                                            title="Taller de Procedimientos de Adquisiciones" class="width-100">
                                    </div>
                                </div>
                                <div class="back">
                                    <img src="{{ asset('imagen/ver-archivo.png') }}" alt="Icono de Ver Archivo"
                                        title="Icono de Ver Archivo" class="width-100">
                                    <button class="btn boton-neumorfo no_s"
                                        onclick="openModal('{{ asset('documentos/talleres/TALLER-DE-PROCEDIMIENTOS-DE-ADQUISICIONES.pdf') }}', 'Taller de Procedimientos de Adquisiciones')">Ver
                                        <i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <a class="btn boton-tarjetadocs"
                                href="{{ asset('documentos/talleres/TALLER-DE-PROCEDIMIENTOS-DE-ADQUISICIONES.pdf') }}" download=""
                                rel="noopener" title="Taller de Procedimientos de Adquisiciones">
                                Descarga <i class="fas fa-download"></i>
                                <img class="justify-items-center w-10p" src="{{ asset('imagen/pdf.png') }}"
                                    alt="imagen de icono PDF" title="Imagen de icono PDF">
                            </a>
                        </div>
                    </div>
                    {{-- <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjeta-herramientas">
                                <p class="titulo-documento">Taller de Procedimientos de Adquisiciones</p>
                                <a href="{{ asset('documentos/talleres/TALLER-DE-PROCEDIMIENTOS-DE-ADQUISICIONES.pdf') }}"
                                    class="boton boton-descargar" target="_blank" rel="noopener">
                                    Ver
                                </a>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>

            <h2 class="text-center">Miércoles 14 de mayo de 2025</h2>

            <div class="container py-5">

                <div class="row">
                    <div class="container mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjetadocs">
                                <div class="front">
                                    <div class="atras">
                                        <img src="{{ asset('portadas-taller/portada7.png') }}"
                                            alt="Portada de Documento Análisis de la Congruencia Horizontal del PED"
                                            title="Análisis de la Congruencia Horizontal del PED" class="width-100">
                                    </div>
                                </div>
                                <div class="back">
                                    <img src="{{ asset('imagen/ver-archivo.png') }}" alt="Icono de Ver Archivo"
                                        title="Icono de Ver Archivo" class="width-100">
                                    <button class="btn boton-neumorfo no_s"
                                        onclick="openModal('{{ asset('documentos/talleres/Presentacion_SPED.pdf') }}', 'Análisis de la Congruencia Horizontal del PED')">Ver
                                        <i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <a class="btn boton-tarjetadocs"
                                href="{{ asset('documentos/talleres/Presentacion_SPED.pdf') }}" download=""
                                rel="noopener" title="Análisis de la Congruencia Horizontal del PED">
                                Descarga <i class="fas fa-download"></i>
                                <img class="justify-items-center w-10p" src="{{ asset('imagen/pdf.png') }}"
                                    alt="imagen de icono PDF" title="Imagen de icono PDF">
                            </a>
                        </div>
                    </div>
                    {{-- <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjeta-herramientas">
                                <p class="titulo-documento">ANÁLISIS DE LA CONGRUENCIA HORIZONTAL DEL PED</p>
                                <a href="{{ asset('documentos/talleres/Presentacion_SPED.pdf') }}"
                                    class="boton boton-descargar" target="_blank" rel="noopener">
                                    Ver
                                </a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="container mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="contenedor-tarjetadocs">
                            <div class="tarjetadocs">
                                <div class="front">
                                    <div class="atras">
                                        <img src="{{ asset('portadas-taller/portada8.png') }}"
                                            alt="Portada de Documento Importancia de los Ingresos y la Recaudación"
                                            title="Importancia de los Ingresos y la Recaudación" class="width-100">
                                    </div>
                                </div>
                                <div class="back">
                                    <img src="{{ asset('imagen/ver-archivo.png') }}" alt="Icono de Ver Archivo"
                                        title="Icono de Ver Archivo" class="width-100">
                                    <button class="btn boton-neumorfo no_s"
                                        onclick="openModal('{{ asset('documentos/talleres/Taller-Gep-Ingresos.pdf') }}', 'Importancia de los Ingresos y la Recaudación')">Ver
                                        <i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <a class="btn boton-tarjetadocs"
                                href="{{ asset('documentos/talleres/Taller-Gep-Ingresos.pdf') }}" download=""
                                rel="noopener" title="Importancia de los Ingresos y la Recaudación">
                                Descarga <i class="fas fa-download"></i>
                                <img class="justify-items-center w-10p" src="{{ asset('imagen/pdf.png') }}"
                                    alt="imagen de icono PDF" title="Imagen de icono PDF">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2 id="modalTitle"></h2>
                <iframe id="modalIframe" src="" class="w-100 h-100"></iframe>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
