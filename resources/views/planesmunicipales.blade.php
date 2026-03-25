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
    <style>
        .table>:not(caption)>*>* {
            padding: .1rem .1rem !important;
        }
    </style>
    <script>
        function cerrarInfoMunicipio() {
            document.getElementById('informacion-municipio').style.display = 'none';
            document.getElementById('mapa').style.display = 'block';
            $mapa.classList.remove('d-none')
        }
    </script>
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
            <div class="row">
                <div class="col-md-4">
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
                        <table class="table" style="border-spacing: 0 !important; border-collapse: collapse !important;">
                            <div class="container">
                                <input type="text" id="buscar-municipio" placeholder="Buscar municipio..."
                                    style="margin-top: 3%; margin-bottom:0; margin-left:1%">
                            </div>
                            <tbody>
                                @foreach ($municipios as $municipio)
                                    <tr>
                                        <td>
                                            <article class="leaderboard__profile" id="{{ $municipio->id }}"
                                                data-id="{{ $municipio->id }}">
                                                <img src="{{ asset('Municipios/iconos/' . $municipio->id . '.webp') }}" loading="lazy"
                                                    alt="Figura con la forma del municipios de {{ $municipio->nombre }}"
                                                    title="{{ $municipio->nombre }}" class="leaderboard__picture">
                                                <span class="leaderboard__name">{{ $municipio->id }}.
                                                    {{ $municipio->nombre }}</span>
                                            </article>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </article>
                </div>
                <div class="col-md-8" id="main-content-area">
                    <div class="mapa-wrapper">
                        <div id="map-loader" class="loader-overlay d-flex">
                            <div class="spinner"></div>
                            <p>Cargando mapa...</p>
                        </div>

                        <div id="mapa" class="mapa"></div>

                        <div class="controles-flotantes"
                            style="position: absolute; bottom: 10px; left: 10px; z-index: 1000; pointer-events: none;">
                            <div class="botonera-vertical" style="pointer-events: auto;">
                                <button class="btn-info" id="btnInfo"
                                    title="Seleccione un municipio de la lista o haga clic en el mapa">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="container-results"></div>
                </div>
            </div>
        </div>
        <div id="myModal" class="modal-planeader">
            <div class="modal-content">
                <button class="close-btn" aria-label="Cerrar">
                    &times;
                </button>
                <h3 id="modalTitle"></h3>
                <iframe id="modalIframe" src="" width="100%" height="100%"></iframe>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/mapa_planesmunicipales.js') }}"></script>
    {{-- <script src="{{ asset('web/js/mostrar-municipios.js') }}"></script> --}}
@endsection
