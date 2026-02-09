@extends('layouts.plantilla')
@section('title', 'Regionalización')
@section('meta-description', 'Visión general de las regiones del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Regionalización - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Bienvenido a la página de visión general de las regiones del estado, parte del Sistema
    Estatal de Planeación Democrática del Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'Regionalización - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Bienvenido a la página de visión general de las regiones del estado, parte del Sistema
    Estatal de Planeación Democrática del Estado de Puebla.')
@section('jss')
    <script src="{{ asset('js/leaflet.js') }}"></script>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}">
@endsection
@section('content')
    <main id="#" class="">
        <section class="coplademun-regiones" id="regionalizacion">
            <div class="container-fluid bg-breadcrumb-regionalizacion">
                <div class="container text-center py-5" style="max-width: 900px;">
                    <h3 class="text-black display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Regionalización</h3>
                    <ol class="breadcrumb justify-content-center text-white mb-0 wow fadeInDown" data-wow-delay="0.3s">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-black"
                                rel="noopener">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-black">Regionalización</a></li>
                    </ol>
                </div>
            </div>
            <div class="col py-4">
                <div class="text-center mb-3 pb-3">
                    <h6 class="text-white text-uppercase h6_planeader">Conoce las</h6>
                    <h2 class="subtitulo_sitios text-white">
                        Regiones del estado
                    </h2>
                    <div class="container text-white">
                        Bienvenidos a la sección de Regionalización del Portal de Planeación para el Desarrollo del Estado
                        de Puebla. Aquí podrás explorar un mapa interactivo que te permitirá conocer de manera sencilla las
                        distintas regiones del estado y los municipios que las componen. Nuestro objetivo es facilitar la
                        identificación de cada región y promover un entendimiento más claro de la estructura territorial de
                        Puebla para fomentar un desarrollo equilibrado y sostenible.
                    </div>
                </div>
            </div>
            <div class="container">

            </div>
            <div class="container mx-auto py-4">
                <div class="row" style="margin-left: auto; margin-right: auto;">
                    <div class="col-md-4">
                        <article class="leaderboard" style="">
                            <header class="encabezado-regiones">
                                <img src="{{ asset('Regiones/mapas/Mapa_puebla_gris.png') }}" width="20%"
                                    style="padding-left:40px; padding-top:10px;" title="Mapa de Puebla en gris"
                                    alt="Mapa de Puebla en gris">
                                <h1 class="leaderboard__title"><span class="leaderboard__title--top">Regiones</span></h1>
                            </header>
                            <table class="table"
                                style="border-spacing: 0 !important; border-collapse: collapse !important;">
                                <main class="leaderboard__profiles">
                                    <div class="container">
                                        <input type="text" id="searchInput" onkeyup="searchNames()"
                                            placeholder="Buscar por nombre..."
                                            style="margin-top: 3%; margin-bottom:0; margin-left:1%">
                                    </div>
                                    <tr>
                                        <td>
                                            @foreach ($regiones as $region)
                                                <article class="leaderboard__profile item-region"
                                                    data-id="{{ $region->id }}">
                                                    <img src="{{ asset('Regiones/regiones_' . $region->id . '.png') }}"
                                                        width="100%" alt="{{ $region->nombre }}"
                                                        class="leaderboard__picture"
                                                        title="Ubicación de la Región {{ $region->id }}">
                                                    <span class="leaderboard__name">{{ $region->nombre }}</span>
                                                </article>
                                            @endforeach
                                        </td>
                                    </tr>
                                </main>
                            </table>
                        </article>
                    </div>

                    <div class="col-md-8">
                        <div class="mapa" id="mapa">
                            <div class="container">
                                Seleccione una región de la lista o de clic en el mapa
                                <a href="https://geoportal.puebla.gob.mx/" target="_blank" class="btn btn-outline-secondary btn-sm text-white" style="position: absolute; top: 41rem; left: 10px;">
                                    Con la tecnología del Geoportal SEI
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mx-auto py-4 ">
                <h2 class="subtitulo_sitios text-white text-center">
                    Base de datos de las regiones
                </h2>
                <p class="text-center text-white">Aquí podrás descargar la base de datos con la relación de las regiones y
                    sus municipios</p>
                <div class="container d-flex justify-content-center">
                    <a class="btn-download" href="{{ asset('documentos/Regiones y municipios.xlsx') }}" download=""><img
                            class="justify-items-center" src="{{ asset('img/descarga-excel.png') }}" alt="imagen de excel">
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        function searchNames() {
            // Obtener el valor del input de búsqueda
            var input = document.getElementById('searchInput');
            var filter = input.value.toUpperCase();

            // Obtener todos los elementos <span> dentro de los <article>
            var names = document.querySelectorAll('.leaderboard__name');

            // Recorrer los nombres y mostrar u ocultar los elementos <article> según coincidan con la búsqueda
            names.forEach(function(name) {
                if (name.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    name.parentNode.style.display = '';
                } else {
                    name.parentNode.style.display = 'none';
                }
            });
        }
    </script>
    <script src="{{ asset('js/mapa_regionalizacion.js') }}"></script>
<script>
    
</script>
    {{-- <script src="{{ asset('web/js/mostrar-regiones.js') }}"></script> --}}
@endsection
