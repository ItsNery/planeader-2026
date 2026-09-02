@extends('layouts.plantilla')
@section('title', 'Planes Municipales de Desarrollo')
@section('meta-description',
    'Página principal de los Planes Municipales de Desarrollo del Sistema Estatal de Planeación
    Democrática del Estado de Puebla')
@section('canonical-url', url()->current())
@section('og-title', 'Planes Municipales de Desarrollo - Sistema Estatal de Planeación Democrática')
@section('og-description',
    'Bienvenido a la página de los Planes Municipales de Desarrollo, parte del Sistema Estatal de
    Planeación Democrática del Estado de Puebla.')
@section('og:url', url()->current())
@section('twitter-title', 'Planes Municipales de Desarrollo - Sistema Estatal de Planeación Democrática')
@section('twitter-description',
    'Bienvenido a la página de los Planes Municipales de Desarrollo, parte del Sistema
    Estatal de Planeación Democrática del Estado de Puebla.')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}">
@endsection
@section('jss')
    <script src="{{ asset('js/leaflet.js') }}"></script>
@endsection

@section('content')
    <section class="contenedor-imagen-planesmun">
        <h1>Planes Municipales de Desarrollo</h1>
    </section>
    <section class="planes-mun">
        <div class="container py-5">
            <p class="text-justify">
                Documentos rectores que establecen los principios básicos sobre los cuales se llevará a cabo la
                Planeación del Desarrollo Municipal y que orientan el funcionamiento de la Administración Pública
                Municipal.
            </p>
            <p class="text-justify">
                Nota:
                La información presentada es responsabilidad de los Ayuntamientos y se pone a disposición en acuerdo con el
                artículo 15 fracción XXIII del Reglamento Interior de la Secretaría de Planeación y Finanzas que establece
                la facultad de recabar de los diferentes niveles de gobierno, la información relativa a los planes y
                programas que se deriven de los instrumentos rectores del desarrollo, y difundirla en el marco del Sistema
                Estatal de Planeación Democrática.
            </p>
        </div>
        <div class="container">
            <div class="map-view-toggle d-md-none" role="group" aria-label="Cambiar vista de planes municipales">
                <button type="button" class="active" data-map-view="list">Lista</button>
                <button type="button" data-map-view="map">Mapa</button>
            </div>
            <div class="row map-layout" data-map-layout>
                <div class="col-md-4 map-list-column" data-map-panel="list">
                    <article class="leaderboard">
                        <header class="encabezado-municipios">
                            <img src="{{ asset('Regiones/mapas/Mapa_puebla_gris.png') }}" class="mapa-gris-puebla"
                                alt="Mapa de Puebla en Gris" title="Puebla">
                            <h2 class="leaderboard__title">
                                <span class="leaderboard__title--top">
                                    Municipios
                                </span>
                            </h2>
                        </header>
                        <div class="container map-search-container">
                            <label class="visually-hidden" for="buscar-municipio">Buscar municipio</label>
                            <input type="search" id="buscar-municipio" class="map-search"
                                placeholder="Buscar municipio...">
                            <p class="map-search-status" aria-live="polite"></p>
                        </div>
                        <div class="map-item-list" role="list">
                            @foreach ($municipios as $municipio)
                                <article class="leaderboard__profile" id="municipio-{{ $municipio->id }}"
                                    data-id="{{ $municipio->id }}" role="button" tabindex="0" aria-pressed="false">
                                    <img src="{{ asset('Municipios/iconos/' . $municipio->id . '.webp') }}" loading="lazy"
                                        alt="Figura con la forma del municipio de {{ $municipio->nombre }}"
                                        title="{{ $municipio->nombre }}" class="leaderboard__picture">
                                    <span class="leaderboard__name">{{ $municipio->id }}. {{ $municipio->nombre }}</span>
                                    <span class="map-item-count" aria-label="{{ $municipio->planes_publicados_count }} planes publicados">
                                        {{ $municipio->planes_publicados_count }} PMD
                                    </span>
                                </article>
                            @endforeach
                        </div>
                    </article>
                </div>
                <div class="col-md-8 map-map-column" id="main-content-area" data-map-panel="map">
                    <div class="mapa-wrapper">
                        <div id="map-loader" class="loader-overlay d-flex" role="status" aria-live="polite">
                            <div class="spinner"></div>
                            <p data-loader-message>Cargando mapa...</p>
                            <button type="button" class="map-retry-button d-none" data-map-retry>Reintentar</button>
                        </div>

                        <div id="mapa" class="mapa" role="region" aria-label="Mapa interactivo de municipios"
                            data-geojson-url="{{ asset('geojson/municipios.geojson') }}"
                            data-planes-url="{{ url('/obtener_planes') }}"></div>

                        <div class="controles-flotantes">
                            <div class="botonera-vertical">
                                <button class="btn-info" id="btnInfo"
                                    type="button" aria-label="Mostrar instrucciones"
                                    title="Seleccione un municipio de la lista o haga clic en el mapa">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                                <button class="btn-reset" id="btnResetMap" type="button"
                                    aria-label="Restablecer vista del mapa" title="Restablecer vista">
                                    <i class="fa-solid fa-arrow-rotate-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="container-results" tabindex="-1" aria-live="polite"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/mapa_planesmunicipales.js') }}"></script>
    {{-- <script src="{{ asset('web/js/mostrar-municipios.js') }}"></script> --}}
@endsection
