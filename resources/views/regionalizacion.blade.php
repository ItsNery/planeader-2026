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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-minimap/3.6.1/Control.MiniMap.min.css" />
    <style>
        #mi-minimapa-estatico {
            width: 150px;
            height: 150px;
            position: absolute;
            bottom: 20px;
            right: 20px;
            z-index: 98;
            border: 2px solid #fff;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            background: white;
            pointer-events: none;
        }
    </style>
@endsection
@section('content')
    <section class="contenedor-imagen-regionalizacion">
        <h1>Regionalización</h1>
    </section>
    <section class="regionalizacion">
        <div class="container">
            <p class="corra-light text-justify my-5">
                Bienvenidos a la sección de Regionalización del Portal de Planeación para el Desarrollo del Estado
                de Puebla. Aquí podrás explorar un mapa interactivo que te permitirá conocer de manera sencilla las
                distintas regiones del estado y los municipios que las componen. Nuestro objetivo es facilitar la
                identificación de cada región y promover un entendimiento más claro de la estructura territorial de
                Puebla para fomentar un desarrollo equilibrado y sostenible.
            </p>
            <div class="row my-5">
                <div class="col-md-4">
                    <ul class="nav nav-tabs" id="regionalizacionTab" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="macrorregiones-tab" data-bs-toggle="tab"
                                data-bs-target="#macrorregiones-pane" type="button" role="tab"
                                aria-controls="macrorregiones-pane" aria-selected="false" data-capa="Macrorregiones">
                                Macrorregiones
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="microrregiones-tab" data-bs-toggle="tab"
                                data-bs-target="#microrregiones-pane" type="button" role="tab"
                                aria-controls="microrregiones-pane" aria-selected="true" data-capa="Microrregiones">
                                Microrregiones
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="regionalizacionTabContent">
                        <div class="tab-pane fade show active" id="macrorregiones-pane" role="tabpanel"
                            aria-labelledby="macrorregiones-tab" tabindex="0">
                            <article class="leaderboard">
                                <header class="encabezado-regiones">
                                    <img src="{{ asset('Regiones/mapas/Mapa_puebla_gris.webp') }}" class="mapa-gris-puebla"
                                        title="Puebla" alt="Mapa de Puebla en gris">
                                    <h1 class="leaderboard__title">
                                        <span class="leaderboard__title--top">
                                            Macrorregiones
                                        </span>
                                    </h1>
                                </header>
                                <main class="leaderboard__profiles">
                                    <div class="container">
                                        <input type="text" id="searchMacro"
                                            onkeyup="searchNames('searchMacro', '#macrorregiones-pane')"
                                            placeholder="Buscar macrorregión..."
                                            style="margin-top: 3%; margin-bottom:0; margin-left:1%; width: 98%;">
                                    </div>
                                    <table class="table"
                                        style="border-spacing: 0 !important; border-collapse: collapse !important;">
                                        @foreach ($macrorregiones as $region)
                                            <article class="leaderboard__profile item-region"
                                                data-id="{{ $region->id_macrorregion }}" data-capa="Macrorregiones">
                                                <img src="{{ asset('Regiones/2026/Macro/' . $region->id_macrorregion . '.webp') }}"
                                                    alt="Forma con la figura de la macrorregión {{ $region->nombre_macrorregion }}"
                                                    class="leaderboard__picture w-50" loading="lazy"
                                                    title="Ubicación de la Macrorregión {{ $region->nombre_macrorregion }}">
                                                <span class="leaderboard__name">{{ $region->id_macrorregion }} -
                                                    {{ $region->nombre_macrorregion }}</span>
                                            </article>
                                        @endforeach
                                    </table>
                                </main>
                            </article>
                        </div>
                        <div class="tab-pane fade" id="microrregiones-pane" role="tabpanel"
                            aria-labelledby="microrregiones-tab" tabindex="0">
                            <article class="leaderboard">
                                <header class="encabezado-regiones">
                                    <img src="{{ asset('Regiones/mapas/Mapa_puebla_gris.webp') }}" class="mapa-gris-puebla"
                                        title="Puebla" alt="Mapa de Puebla en gris">
                                    <h1 class="leaderboard__title">
                                        <span class="leaderboard__title--top">
                                            Microrregiones
                                        </span>
                                    </h1>
                                </header>
                                <main class="leaderboard__profiles">
                                    <div class="container">
                                        <input type="text" id="searchMicro"
                                            onkeyup="searchNames('searchMicro', '#microrregiones-pane')"
                                            placeholder="Buscar microrregión..."
                                            style="margin-top: 3%; margin-bottom:0; margin-left:1%; width: 98%;">
                                    </div>
                                    <table class="table"
                                        style="border-spacing: 0 !important; border-collapse: collapse !important;">
                                        @foreach ($microrregiones as $region)
                                            <article class="leaderboard__profile item-region"
                                                data-id="{{ $region->id_microrregion }}" data-capa="Microrregiones">
                                                <img src="{{ asset('Regiones/2026/Micro/' . $region->id_microrregion . '.webp') }}"
                                                    alt="Forma con la figura de la microrregión {{ $region->nombre_microrregion }}"
                                                    class="leaderboard__picture w-50" loading="lazy"
                                                    title="Ubicación de la Microrregión {{ $region->nombre_microrregion }}">
                                                <span class="leaderboard__name">{{ $region->id_microrregion }} -
                                                    {{ $region->nombre_microrregion }}</span>
                                            </article>
                                        @endforeach
                                    </table>
                                </main>
                            </article>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="mapa-wrapper" style="">
                        <div id="loader-mapa" class="loader-overlay d-flex">
                            <div class="spinner"></div>
                            <p>Cargando mapa...</p>
                        </div>

                        <div class="mapa wihi100" id="mapa"></div>
                        <div id="mi-minimapa-estatico"></div>

                        <!-- CONTENEDOR FLOTANTE (ABSOLUTO) -->
                        <div class="controles-flotantes"
                            style="position: absolute; bottom: 10px; left: 10px; z-index: 98; pointer-events: none;">
                            <div class="botonera-vertical" style="pointer-events: auto;">
                                <button class="btn-info" id="btnInfo"
                                    title="Seleccione una región de la lista o haga clic en el mapa">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                                <button class="btn-reset" id="btnResetMap" title="Restablecer vista">
                                    <i class="fa-solid fa-arrow-rotate-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="descarga-base">
        <div class="container">
            <h2 class="titulo">Base de datos de las regiones</h2>
            <p class="descripcion">
                Aquí podrás descargar la base de datos con la relación de las regiones y sus municipios.
            </p>
            <div class="contenedor-boton">
                <a href="{{ asset('documentos/Regiones2026.xlsx') }}" target="_blank" class="btn-descargar"
                    title="Base Regionalizacion 2026">
                    <span class="btn-descargar__texto">Consultar<br>documento</span>

                    <span class="btn-descargar__icono">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 15.586l-4.293-4.293a1 1 0 0 1 1.414-1.414L11 11.586V4a1 1 0 0 1 2 0v7.586l1.879-1.879a1 1 0 0 1 1.414 1.414L12 15.586z" />
                            <path
                                d="M18 21H6a3 3 0 0 1-3-3V11a1 1 0 0 1 2 0v7a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-7a1 1 0 0 1 2 0v7a3 3 0 0 1-3 3z" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function searchNames(inputId, paneId) {
            // Obtener el valor del input de búsqueda
            var input = document.getElementById(inputId);
            var filter = input.value.toUpperCase();

            // Obtener el panel contenedor para buscar solo dentro del tab activo
            var pane = document.querySelector(paneId);

            // Obtener todos los elementos <span> dentro de los <article> de ese panel
            var names = pane.querySelectorAll('.leaderboard__name');

            // Recorrer los nombres y mostrar u ocultar los elementos <article> según coincidan
            names.forEach(function(name) {
                if (name.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    // Sube al elemento <article> padre para mostrarlo/ocultarlo
                    name.closest('.leaderboard__profile').style.display = '';
                } else {
                    name.closest('.leaderboard__profile').style.display = 'none';
                }
            });
        }
    </script>
    {{-- <script src="{{ asset('js/mapa_regionalizacion.js') }}"></script> --}}
    <script src="{{ asset('js/mapa_regionalizacion_v2.js') }}"></script>
    {{--
    <script src="{{ asset('web/js/mostrar-regiones.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-minimap/3.6.1/Control.MiniMap.min.js"></script>
@endsection
