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
    <main id="#" class="">
        <section class="planes_mun">
            <div class="container-fluid bg-breadcrumb-plamesmun">
                <div class="container text-center py-5" style="max-width: 900px;">
                    <h3 class="text-black display-3 mb-4 wow fadeInDown" data-wow-delay="0.1s">Planes Municipales de
                        Desarrollo</h1>
                        <ol class="breadcrumb justify-content-center text-white mb-0 wow fadeInDown" data-wow-delay="0.3s">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-black">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="#" class="text-black">Planes Municipales de
                                    Desarrollo</a></li>
                        </ol>
                </div>
            </div>
            <div class="container py-5">
                <div class="container text-center text-white py-5">
                    Documentos rectores que estableces los principios básicos sobre los cuales se llevará a cabo la
                    Planeación del Desarrollo Municipal y que orientan el funcionamiento de la Administración Pública
                    Municipal.
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <article class="leaderboard">
                            <header class="encabezado-municipios">
                                <img src="{{ asset('Regiones/mapas/Mapa_puebla_gris.png') }}" width="20%"
                                    style="padding-left:40px; padding-top:10px;" title="Mapa de Puebla en Gris"
                                    title="Mapa de Puebla en Gris">
                                <h2 class="leaderboard__title"><span class="leaderboard__title--top">Municipios</span></h2>
                            </header>
                            <table class="table"
                                style="border-spacing: 0 !important; border-collapse: collapse !important;">
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
                                                    <img src="{{ asset('Municipios/iconos/' . $municipio->id . '.png') }}"
                                                        width="100%" alt="{{ $municipio->nombre }}"
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
                    <div class="col-md-8" id="mapa">
                        <div class="container">
                            Seleccione un municipio de la lista o de clic en el mapa
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12 d-flex justify-content-center">
                                <img title="Mapa de Puebla con división municipal"
                                    alt="Mapa de Puebla con división municipal" class="img-fluid"
                                    src="{{ asset('Municipios/Mapa-municipios.png') }}" width="70%" id="mapa_general" />
                                @for ($i = 1; $i <= 217; $i++)
                                    <img loading="lazy" title="Imagen del municipio" alt="Imagen del municipio"
                                        class="img-fluid" src="{{ asset('Municipios/mapas/' . $i . '.png') }}"
                                        width="70%" id="mapa_{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                                        style="display:none;" />
                                @endfor
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-md-8" id="container-results">
                    </div>
                </div>
                <div class="row">

                    <div class="container pt-4">
                        <div class="tarjeta">
                            <div class="card-body">
                                <h5 class="card-title text-white">Nota</h5>
                                <p class="card-text text-white text-justify">La información presentada es responsabilidad
                                    de
                                    los Ayuntamientos y se pone a disposición en acuerdo con el artículo 15 fracción XXIII
                                    del Reglamento Interior de la Secretaría de Planeación y Finanzas que establece la
                                    facultad de recabar de los diferentes niveles de gobierno, la información relativa a los
                                    planes y programas que se deriven de los instrumentos rectores del desarrollo, y
                                    difundirla en el marco del Sistema Estatal de Planeación Democrática.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/mapa_planesmunicipales.js') }}"></script>
    {{-- <script src="{{ asset('web/js/mostrar-municipios.js') }}"></script> --}}

    <script>
        const $leaderboardProfile = document.querySelectorAll('.leaderboard__profile')
        const $mapa = document.getElementById('mapa')

        $leaderboardProfile.forEach(el => {
            el.addEventListener('click', function(e) {
                let idMun = this.dataset.id
                fetch('/obtener_planes/' + idMun)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('La solicitud ha fallado');
                        }
                        return response.text();
                    })
                    .then(data => {
                        $mapa.classList.add('d-none')
                        const $containerResults = document.getElementById('container-results')
                        $containerResults.innerHTML = data;
                    })

                .catch(error => {
                    console.error('Error:', error);
                });
            })
        });
    </script>
    <script>
        document.getElementById('buscar-municipio').addEventListener('input', function() {
            let inputText = this.value.toLowerCase();
            let municipios = document.querySelectorAll('.leaderboard__profile');

            municipios.forEach(function(municipio) {
                let nombreMunicipio = municipio.querySelector('.leaderboard__name').textContent
                    .toLowerCase();
                let tdMunicipio = municipio.closest('td'); // Obtener el <td> que contiene el municipio

                if (nombreMunicipio.includes(inputText)) {
                    tdMunicipio.style.display = 'table-cell'; // Mostrar el <td> si coincide con la búsqueda
                } else {
                    tdMunicipio.style.display = 'none'; // Ocultar el <td> si no coincide con la búsqueda
                }
            });
        });
    </script>
@endsection
