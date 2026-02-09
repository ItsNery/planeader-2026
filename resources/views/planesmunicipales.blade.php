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
                            <img src="{{ asset('Regiones/mapas/Mapa_puebla_gris.png') }}" width="20%"
                                style="padding-left:40px; padding-top:10px;" title="Mapa de Puebla en Gris"
                                title="Mapa de Puebla en Gris">
                            <h2 class="leaderboard__title"><span class="leaderboard__title--top">Municipios</span></h2>
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
                        <a href="https://geoportal.puebla.gob.mx/" target="_blank"
                            class="btn btn-outline-secondary btn-sm text-black"
                            style="position: absolute; top: 41rem; left: 10px;">
                            Con la tecnología del Geoportal SEI
                        </a>
                    </div>
                </div>
                <div class="col-md-8" id="container-results">
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
    <script>
        /**
         * Función unificada para cerrar el modal.
         */
        function closeModal() {
            const modal = document.getElementById('myModal');
            if (modal) {
                modal.style.display = 'none';
            }

            const modalIframe = document.getElementById('modalIframe');
            if (modalIframe) {
                modalIframe.src = '';
            }
        }

        // Se ejecuta cuando la página ha cargado completamente.
        document.addEventListener('DOMContentLoaded', function() {

            // --- Referencias a los elementos del DOM ---
            const modal = document.getElementById('myModal');
            const modalIframe = document.getElementById('modalIframe');
            const modalTitle = document.getElementById('modalTitle');
            const closeButton = document.querySelector('#myModal .close-btn');

            // --- LÓGICA PARA ABRIR EL MODAL (CON DELEGACIÓN DE EVENTOS) ---

            // 1. Añadimos un solo listener al documento.
            document.addEventListener('click', function(event) {

                // 2. Verificamos si el elemento clickeado (o su padre más cercano) es un botón para abrir el modal.
                const openButton = event.target.closest('.js-open-modal');

                // 3. Si encontramos un botón, ejecutamos la lógica.
                if (openButton) {
                    // Prevenimos cualquier comportamiento por defecto si el botón fuera un enlace <a>
                    event.preventDefault();

                    // Obtenemos la info desde los data-attributes del botón encontrado.
                    const docUrl = openButton.dataset.src;
                    const docTitle = openButton.dataset.title;

                    if (docUrl) {
                        // Llenamos el modal con la información
                        modalTitle.textContent = docTitle;
                        modalIframe.src = docUrl;

                        // Mostramos el modal
                        modal.style.display = 'block';
                    }
                }
            });


            // --- Lógica para CERRAR el modal (esta no cambia) ---

            // 1. Clic en el botón de cierre (X)
            if (closeButton) {
                closeButton.addEventListener('click', closeModal);
            }

            // 2. Clic en el fondo (overlay)
            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    closeModal();
                }
            });

            // 3. Presionar la tecla "Escape"
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && modal.style.display === 'block') {
                    closeModal();
                }
            });
        });
    </script>
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
