@extends('layouts.plantilla')
@section('title', 'Plan Estatal de Desarrollo 2024-2030')
@section('meta-description',
'Visión general del Plan Estatal de Desarrollo 2024-2030 del Gobierno
del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Plan Estatal de Desarrollo 2024-2030 - Sistema Estatal de Planeación Democrática')
@section('og-description',
'Bienvenido a la página de visión general del Plan Estatal 2024-2030 de
Desarrollo del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('og:image', 'https://planeader.puebla.gob.mx/img/ped2/PED23.png')
@section('og:url', url()->current())
@section('twitter-title', 'Plan Estatal de Desarrollo 2024-2030 - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
'Bienvenido a la página de visión general del Plan Estatal 2024-2030 de
Desarrollo del Sistema Estatal de Planeación Democrática del Estado de Puebla.')
@section('jss')
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
@endsection
@section('content')
<main id="#" class="">
    <section class="ped-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 text-center mb-4 mb-md-0">
                    <img src="{{ asset('imagen/logo-ped.png') }}" alt="Logo Plan Estatal de Desarrollo Puebla 2024-2030" class="img-fluid ped-logo">
                </div>
                <div class="col-md-9">
                    <h2 class="ped-title">Conoce el Nuevo Plan Estatal de Desarrollo 2024-2030</h2>
                    <p class="ped-description">
                        Con el PED 2024–2030 en mano y con amor a Puebla, es un honor asumir esta responsabilidad y ser parte, con todas y todos, de la Cuarta Transformación en el Estado
                    </p>
                    <a href="https://ped2024-2030.puebla.gob.mx/" target="_blank" class="btn btn-primary ped-button">
                        Descubre Más
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="nuevo-ped">
        <div class="container-fluid bg-breadcrumb-nuevo-ped">
            <div class="container text-center py-5">
                <h3 class="text-white display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Documentos de apoyo</h1>
                    <ol class="breadcrumb justify-content-center text-white mb-0 wow fadeInDown" data-wow-delay="0.3s">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-white">Documentos de apoyo</a>
                        </li>
                    </ol>
            </div>
        </div>
        <div class="container mx-auto py-4">
            {{-- <p class="text-black text-justify">
                    Descubre los documentos de apoyo que las diferentes instituciones han elaborado para la elaboración del
                    Plan Estatal de Desarrollo 2024-2030.
                </p> --}}
        </div>
        <div class="container">
            <h2 class="text-black">INEGI</h2>
            <div class="row">
                <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                    <div class="contenedor-tarjetadocs">
                        <div class="tarjeta-herramientas">
                            <p class="titulo-documento">Anexo Estadístico del Estado de Puebla</p>
                            <a href="#" class="boton"
                                onclick="openModal('{{ asset('documentos/nuevo-ped/INEGI/ESTATAL/AnexoEstadísticoEstatalPUEBLA.pdf') }}', 'Anexo Estadístico del Estado de Puebla')">Ver</a>
                            <a href="{{ asset('documentos/nuevo-ped/INEGI/ESTATAL/AnexoEstadísticoEstatalPUEBLA.pdf') }}"
                                class="boton boton-descargar" download="" rel="noopener">
                                <i class="fas fa-file-pdf"></i> Descargar
                            </a>
                        </div>
                    </div>
                </div>
                <!-- <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                            <div class="contenedor-tarjetadocs">
                                <div class="tarjeta-herramientas">
                                    <p class="titulo-documento">Visión en Cifras de Puebla</p>
                                    <a href="#" class="boton"
                                        onclick="openModal('{{ asset('documentos/nuevo-ped/INEGI/ESTATAL/Vision_en_cifras_de_Puebla.pdf') }}', 'Visión en Cifras de Puebla')">Ver</a>
                                    <a href="{{ asset('documentos/nuevo-ped/INEGI/ESTATAL/Vision_en_cifras_de_Puebla.pdf') }}"
                                        class="boton boton-descargar">
                                        <i class="fas fa-file-pdf"></i> Descargar
                                    </a>
                                </div>
                            </div>
                        </div> -->
                <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                    <div class="contenedor-tarjetadocs">
                        <div class="tarjeta-herramientas">
                            <p class="titulo-documento">Visión en Cifras de los municipios de Puebla</p>
                            {{-- <a href="#" class="boton">Ver</a> --}}
                            <a href="{{ asset('documentos/nuevo-ped/INEGI/MUNICIPAL/MUNICIPAL.zip') }}"
                                class="boton boton-descargar" download="" rel="noopener">
                                <i class="fa-regular fa-file-zipper"></i> Descargar
                            </a>
                        </div>
                    </div>
                </div>
                <!-- <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                            <div class="contenedor-tarjetadocs">
                                <div class="tarjeta-herramientas">
                                    <p class="titulo-documento">Anexo Estadístico del Estado de Puebla</p>
                                    <a href="#" class="boton"
                                        onclick="openModal('{{ asset('documentos/nuevo-ped/Anexo_Estadístico_Estatal_PUEBLA.pdf') }}', 'Anexo Estadístico del Estado de Puebla')">Ver</a>
                                    <a href="{{ asset('documentos/nuevo-ped/Anexo_Estadístico_Estatal_PUEBLA.pdf') }}"
                                        class="boton boton-descargar">
                                        <i class="fas fa-file-pdf"></i> Descargar
                                    </a>
                                </div>
                            </div>
                        </div> -->
                <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                    <div class="contenedor-tarjetadocs">
                        <div class="tarjeta-herramientas">
                            <p class="titulo-documento">Anexo estadístico municipal del estado de Puebla</p>
                            <a href="#" class="boton"
                                onclick="openModal('{{ asset('documentos/nuevo-ped/AnexoMun2024Puebla.pdf') }}', 'Anexo estadístico municipal del estado de Puebla')">Ver</a>
                            <a href="{{ asset('documentos/nuevo-ped/AnexoMun2024Puebla.pdf') }}"
                                class="boton boton-descargar">
                                <i class="fas fa-file-pdf"></i> Descargar
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                    <div class="contenedor-tarjetadocs">
                        <div class="tarjeta-herramientas">
                            <p class="titulo-documento">El SNIEG en el Estado de Puebla</p>
                            <a href="#" class="boton"
                                onclick="openModal('{{ asset('documentos/nuevo-ped/El_SNIEG_en_el_estado_de_Puebla.pdf') }}', 'El SNIEG en el Estado de Puebla')">Ver</a>
                            <a href="{{ asset('documentos/nuevo-ped/El_SNIEG_en_el_estado_de_Puebla.pdf') }}"
                                class="boton boton-descargar">
                                <i class="fas fa-file-pdf"></i> Descargar
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12 d-flex justify-content-center">
                    <div class="contenedor-tarjetadocs">
                        <div class="tarjeta-herramientas">
                            <p class="titulo-documento">Versión en Cifras de Puebla</p>
                            <a href="#" class="boton"
                                onclick="openModal('{{ asset('documentos/nuevo-ped/Vision_en_cifras_de_Puebla_20012025_Imagen_actualizada.pdf') }}', 'Versión en Cifras de Puebla')">Ver</a>
                            <a href="{{ asset('documentos/nuevo-ped/Vision_en_cifras_de_Puebla_20012025_Imagen_actualizada.pdf') }}"
                                class="boton boton-descargar">
                                <i class="fas fa-file-pdf"></i> Descargar
                            </a>
                        </div>
                    </div>
                </div>
                {{-- <div class="mx-auto px-4 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="contenedor-tarjetadocs">
                                <div class="tarjeta-herramientas">
                                    <p class="titulo-documento">Anexo 4. Matriz de Comparación Regional</p>
                                    <a href="#" class="boton"
                                        onclick="openModal('{{ asset('documentos/seati/Anexo_4._Matriz_de_Comparación_Regional.pdf') }}', 'Anexo 4')">Ver</a>
                <a href="{{ asset('documentos/seati/Anexo_4._Matriz_de_Comparación_Regional.pdf') }}"
                    class="boton boton-descargar" download="" rel="noopener">
                    <i class="fas fa-file-pdf"></i> Descargar
                </a>
            </div>
        </div>
        </div> --}}
        </div>
        </div>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2 id="modalTitle"></h2>
                <iframe id="modalIframe" src="" width="100%" height="100%"></iframe>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
@endpush