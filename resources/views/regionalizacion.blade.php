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
        <h1 class="visually-hidden">Regionalización</h1>
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
            <div class="map-view-toggle d-md-none" role="group" aria-label="Cambiar vista de regionalización">
                <button type="button" class="active" data-map-view="list">Lista</button>
                <button type="button" data-map-view="map">Mapa</button>
            </div>
            <div class="row my-5 map-layout" data-map-layout>
                <div class="col-md-4 map-list-column" data-map-panel="list">
                    <ul class="nav nav-tabs" id="regionalizacionTab" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="macrorregiones-tab" data-bs-toggle="tab"
                                data-bs-target="#macrorregiones-pane" type="button" role="tab"
                                aria-controls="macrorregiones-pane" aria-selected="true" data-capa="Macrorregiones">
                                Macrorregiones
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="microrregiones-tab" data-bs-toggle="tab"
                                data-bs-target="#microrregiones-pane" type="button" role="tab"
                                aria-controls="microrregiones-pane" aria-selected="false" data-capa="Microrregiones">
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
                                        <label class="visually-hidden" for="searchMacro">Buscar macrorregión</label>
                                        <input type="search" id="searchMacro" class="map-search"
                                            data-search-pane="#macrorregiones-pane" placeholder="Buscar macrorregión...">
                                        <p class="map-search-status" aria-live="polite"></p>
                                    </div>
                                    <div class="map-item-list" role="list">
                                        @foreach ($macrorregiones as $region)
                                            <article class="leaderboard__profile item-region"
                                                data-id="{{ $region->id_macrorregion }}" data-capa="Macrorregiones"
                                                role="button" tabindex="0" aria-pressed="false">
                                                <img src="{{ asset('Regiones/2026/Macro/' . $region->id_macrorregion . '.webp') }}"
                                                    alt="Forma con la figura de la macrorregión {{ $region->nombre_macrorregion }}"
                                                    class="leaderboard__picture w-50" loading="lazy"
                                                    title="Ubicación de la Macrorregión {{ $region->nombre_macrorregion }}">
                                                <span class="leaderboard__name">{{ $region->id_macrorregion }} -
                                                    {{ $region->nombre_macrorregion }}</span>
                                            </article>
                                        @endforeach
                                    </div>
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
                                        <label class="visually-hidden" for="searchMicro">Buscar microrregión</label>
                                        <input type="search" id="searchMicro" class="map-search"
                                            data-search-pane="#microrregiones-pane" placeholder="Buscar microrregión...">
                                        <p class="map-search-status" aria-live="polite"></p>
                                    </div>
                                    <div class="map-item-list" role="list">
                                        @foreach ($microrregiones as $region)
                                            <article class="leaderboard__profile item-region"
                                                data-id="{{ $region->id_microrregion }}" data-capa="Microrregiones"
                                                role="button" tabindex="0" aria-pressed="false">
                                                <img src="{{ asset('Regiones/2026/Micro/' . $region->id_microrregion . '.webp') }}"
                                                    alt="Forma con la figura de la microrregión {{ $region->nombre_microrregion }}"
                                                    class="leaderboard__picture w-50" loading="lazy"
                                                    title="Ubicación de la Microrregión {{ $region->nombre_microrregion }}">
                                                <span class="leaderboard__name">{{ $region->id_microrregion }} -
                                                    {{ $region->nombre_microrregion }}</span>
                                            </article>
                                        @endforeach
                                    </div>
                                </main>
                            </article>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 map-map-column" data-map-panel="map">
                    <div class="mapa-wrapper">
                        <div id="loader-mapa" class="loader-overlay d-flex" role="status" aria-live="polite">
                            <div class="spinner"></div>
                            <p data-loader-message>Cargando mapa...</p>
                            <button type="button" class="map-retry-button d-none" data-map-retry>Reintentar</button>
                        </div>

                        <div class="mapa wihi100" id="mapa" role="region"
                            aria-label="Mapa interactivo de regionalización"
                            data-municipios-url="{{ asset('geojson/municipios.geojson') }}"
                            data-microrregiones-url="{{ asset('geojson/microrregiones-2026.geojson') }}"
                            data-macrorregiones-url="{{ asset('geojson/macrorregiones-2026.geojson') }}"
                            data-region-info-url="{{ url('/get_info_region') }}"></div>
                        <div id="mi-minimapa-estatico"></div>

                        <!-- CONTENEDOR FLOTANTE (ABSOLUTO) -->
                        <div class="controles-flotantes controles-flotantes-regionalizacion">
                            <div class="botonera-vertical">
                                <button type="button" class="btn-info" id="btnInfo"
                                    aria-label="Mostrar instrucciones"
                                    title="Seleccione una región de la lista o haga clic en el mapa">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                                <button type="button" class="btn-reset" id="btnResetMap" title="Restablecer vista"
                                    aria-label="Restablecer vista del mapa">
                                    <i class="fa-solid fa-arrow-rotate-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <aside class="map-selection-panel" id="region-details" aria-live="polite">
                        <h2>Explora las regiones</h2>
                        <p>Selecciona una región en la lista o un municipio en el mapa para consultar sus detalles.</p>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <section class="descarga-base">
        @if ($anexo5)
            <div class="container d-flex justify-content-center flex-column align-items-center">
                <h2 class="titulo">Consulta el Anexo 5, para más información</h2>
                <p class="descripcion">
                    Aquí podrás encontrar más información sobre la metodología para la regionalización.
                </p>
                <div class="container-imagen">
                    <img src="{{ asset('img/ped/anexos/' . $anexo5->imagen) . '?v=' . $anexo5->updated_at->timestamp }}"
                        alt="" class="w-100">
                </div>
                <div class="contenedor-boton">
                    <a href="{{ $anexo5->es_enlace ? $anexo5->ruta_documento : asset('documentos/planesest/anexos/' . $anexo5->ruta_documento) . '?v=' . $anexo5->updated_at->timestamp }}"
                        target="_blank" class="btn-descargar" title="Base Regionalizacion 2026">

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
        @endif
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
    <script src="{{ asset('js/mapa_regionalizacion_v2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-minimap/3.6.1/Control.MiniMap.min.js"></script>
@endsection
