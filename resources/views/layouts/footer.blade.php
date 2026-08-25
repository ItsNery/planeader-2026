{{-- @extends('publico.index') --}}
<footer>
    <div class="container-fluid bg-dark text-white-50 py-5 px-sm-3 px-lg-5 footer-1">
        <div class="row pt-5">
            <div class="col-lg-3 col-md-6 mb-5">
                <a href="{{ url('/') }}" class="navbar-brand" rel="noopener">
                    <h2>
                        <span class="text-white">PLANEA</span>DER
                    </h2>
                </a>
                <p>
                    Portal de Planeación para el Desarrollo del Estado de Puebla.
                </p>
                <h6 class="text-white text-uppercase mt-4 mb-3 h6_planeader">
                    Síguenos
                </h6>
                <div class="d-flex justify-content-start">
                    <a title="X/Twitter de la Secretaría de Planeación y Finanzas"
                        class="btn btn-outline-primary btn-square mr-2" href="https://x.com/finanzasgobpue"
                        rel="noopener" target="_blank">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a title="Facebook de la Secretaría de Planeación y Finanzas"
                        class="btn btn-outline-primary btn-square mr-2" href="https://www.facebook.com/finanzasgobpue"
                        rel="noopener" target="_blank">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                </div>
                <div class="container pt-3">
                    <div id="evaluationDiv" class="evaluation-container">
                        <h5 class="text-dark text-uppercase mb-4 h5_planeader">
                            Evaluación del sitio
                        </h5>
                        <p class="text-black">
                            ¡Ayúdanos a mejorar! Por favor, evalúa la utilidad del sitio:
                        </p>
                        <div class="emoji-container">
                            <span class="emoji big-emoji cursor-pointer" onclick="submitEvaluation(3)">
                                😊
                            </span>
                            <span class="emoji big-emoji cursor-pointer" onclick="submitEvaluation(2)">
                                😐
                            </span>
                            <span class="emoji big-emoji cursor-pointer" onclick="submitEvaluation(1)">
                                😞
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="text-white text-uppercase mb-4">
                    Mapa de sitio
                </h5>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white-50 mb-2" href="{{ url('/') }}">
                        <i class="fa fa-home mr-2" rel="noopener"></i>
                        Inicio
                    </a>
                    <a class="text-white-50 mb-2" href="{{ url('/marcojuridico') }}">
                        <i class="fa fa-gavel mr-2" rel="noopener"></i>
                        Marco Jurídico
                    </a>
                    <a class="text-white-50 mb-2" href="#" data-bs-toggle="collapse"
                        data-bs-target="#planeacionEstatalSubMenu" aria-expanded="false"
                        aria-controls="planeacionEstatalSubMenu" rel="noopener">
                        <i class="fa fa-sitemap mr-2"></i>
                        Planeación Estatal
                    </a>
                    <div class="collapse" id="planeacionEstatalSubMenu">
                        <a class="text-white-50 ml-4 mb-2" href="{{ url('/ped') }}" rel="noopener">
                            <i class="fa fa-angle-right mr-2"></i>
                            Plan Estatal de Desarrollo
                        </a>
                        <br>
                        <a class="text-white-50 ml-4 mb-2" href="{{ url('/ped-programas') }}" rel="noopener">
                            <i class="fa fa-angle-right mr-2"></i>
                            Programas Derivados
                        </a>
                        <br>
                        <a class="text-white-50 ml-4 mb-2" href="{{ url('/copladep') }}" rel="noopener">
                            <i class="fa fa-angle-right mr-2"></i>
                            COPLADEP
                        </a>
                        <br>
                        <a class="text-white-50 ml-4 mb-2" href="{{ url('/subcomites') }}" rel="noopener">
                            <i class="fa fa-angle-right mr-2"></i>
                            Subcomités
                        </a>
                        <br>
                        <a class="text-white-50 ml-4 mb-2" href="{{ url('/herramientas-planeacion') }}" rel="noopener">
                            <i class="fa fa-angle-right mr-2"></i>
                            Herramientas de Planeación
                        </a>
                        <br>
                        <a class="text-white-50 ml-4 mb-2" href="{{ url('/programas-estatales') }}" rel="noopener">
                            <i class="fa fa-angle-right mr-2"></i>
                            Programas Estatales
                        </a>
                        <br>
                    </div>
                    <a class="text-white-50 mb-2" href="#" data-bs-toggle="collapse"
                        data-bs-target="#planeacionMunicipalSubMenu" aria-expanded="false"
                        aria-controls="planeacionMunicipalSubMenu" rel="noopener">
                        <i class="fa fa-sitemap mr-2"></i>
                        Planeación Municipal
                    </a>
                    <div class="collapse" id="planeacionMunicipalSubMenu">
                        <a class="text-white-50 ml-4 mb-2" href="{{ url('/planesmunicipales') }}" rel="noopener">
                            <i class="fa fa-angle-right mr-2"></i>
                            Planes Municipales de
                            Desarrollo
                        </a>
                        <br>
                        <a class="text-white-50 ml-4 mb-2" href="{{ url('/coplademun') }}" rel="noopener">
                            <i class="fa fa-angle-right mr-2"></i>
                            COPLADEMUN
                        </a>
                        <br>
                        <a class="text-white-50 ml-4 mb-2" href="{{ url('/capacitacion-municipal') }}"
                            rel="noopener">
                            <i class="fa fa-angle-right mr-2"></i>
                            Capacitación Municipal
                        </a>
                        <br>
                        <a class="text-white-50 ml-4 mb-2" href="{{ url('/documentos-metodologicos') }}"
                            rel="noopener">
                            <i class="fa fa-angle-right mr-2"></i>
                            Documentos metodológicos
                        </a>
                        <br>
                    </div>
                    <a class="text-white-50 mb-2" href="{{ url('/regionalizacion') }}">
                        <i class="fa fa-globe mr-2" rel="noopener"></i>
                        Regionalización
                    </a>
                    <a class="text-white-50 mb-2" href="{{ url('/contacto') }}" rel="noopener">
                        <i class="fa-solid fa-address-book"></i>
                        Contacto
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="text-white text-uppercase mb-4">
                    Sitios de interés
                </h5>
                <div class="d-flex flex-column justify-content-start">
                    <a target="_blank" class="text-white-50 mb-2" href="https://www.gob.mx/" rel="noopener">
                        <i class="fa fa-angle-right mr-2"></i>
                        Gobierno
                        de los Estados Unidos Mexicanos
                    </a>
                    <a target="_blank" class="text-white-50 mb-2" href="https://www.puebla.gob.mx/" rel="noopener">
                        <i class="fa fa-angle-right mr-2"></i>
                        Gobierno
                        del Estado de
                        Puebla
                    </a>
                    <a target="_blank" class="text-white-50 mb-2" href="https://spf.puebla.gob.mx/" rel="noopener">
                        <i class="fa fa-angle-right mr-2"></i>
                        Secretaría
                        de Planeación, Finanzas y Administración
                    </a>
                    <a target="_blank" class="text-white-50 mb-2" href="https://agenda2030.puebla.gob.mx/"
                        rel="noopener">
                        <i class="fa fa-angle-right mr-2"></i>
                        Agenda
                        2030
                    </a>
                    <a target="_blank" class="text-white-50 mb-2" href="https://ceigep.puebla.gob.mx/"
                        rel="noopener">
                        <i class="fa fa-angle-right mr-2"></i>
                        CEIGEP
                    </a>
                    <a target="_blank" class="text-white-50 mb-2" href="https://evaluacion.puebla.gob.mx/"
                        rel="noopener">
                        <i class="fa fa-angle-right mr-2"></i>
                        Evaluación
                    </a>
                    <a target="_blank" class="text-white-50 mb-2" href="https://sped.puebla.gob.mx/" rel="noopener">
                        <i class="fa fa-angle-right mr-2"></i>
                        SPED
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="text-white text-uppercase mb-4">
                    Contáctanos
                </h5>
                <p>
                    <i class="fa fa-map-marker-alt mr-2"></i>
                    Av. Cúmulo de Virgo 1358, Reserva Territorial Atlixcáyotl, Puebla, Pue.
                </p>
                <p>
                    <i class="fa fa-phone-alt mr-2"></i>
                    <a class="no_s text-inherit" href="tel:2222297000">
                        222 229
                        7000 Ext. 5014
                    </a>
                </p>
                <p>
                    <i class="fa fa-envelope mr-2"></i>
                    <a class="no_s text-inherit" href="mailto:planeacion@puebla.gob.mx">
                        planeacion@puebla.gob.mx
                    </a>
                </p>
                <h6 class="text-white text-uppercase mt-4 mb-3 h6_planeader sm-d-none">
                    Ubicación
                </h6>
                <div class="w-100 sm-d-none">
                    <iframe id="mapIframe" title="Iframe de Mapas" class="iframe-footer"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d235.74991801338356!2d-98.23562714550607!3d19.019779470285457!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cfc70067539479%3A0xf49b8ffba2f7d28e!2sSecretar%C3%ADa%20de%20Finanzas%20-%20Nueva%20Sede%20(en%20construcci%C3%B3n)!5e0!3m2!1sen!2smx!4v1779210197938!5m2!1sen!2smx"
                        allowfullscreen="">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark text-white border-top py-4 px-sm-3 px-md-5 footer-2">
        <div class="row">
            <div class="col-lg-6 text-center text-md-left mb-3 mb-md-0">
                <p class="m-0 text-white-50">
                    <a href="https://spf.puebla.gob.mx" target="_blank" rel="noopener">Secretaría de Planeación,
                        Finanzas y Administración</a>
                    <a href="https://creativecommons.org/licenses/by/4.0/deed.es" rel="noopener" target="_blank">
                        <img src="{{ asset('imagen/cc.xlarge.png') }}" class="w-20px" alt="Logo de Creative Commons"
                            title="Logo de Creative Commons">
                        <img src="{{ asset('imagen/by.xlarge.png') }}" class="w-20px" alt="Logo de Creative Commons"
                            title="Logo de Creative Commons"></a>
                    Se autoriza la reproducción parcial o total del contenido, siempre que se cite y referencie la
                    fuente.
                </p>
            </div>
            <div class="col-lg-6 text-center text-md-right">
                <p class="m-0 text-white-50">
                    Diseñado por la
                    <a target="_blank" href="https://planeacion.puebla.gob.mx" rel="noopener">Subsecretaría de
                        Planeación</a>
                </p>
                <p class="m-0 text-white-50">
                    <a target="_blank" href="{{ url('/login') }}" rel="noopener">Iniciar sesión</a>
                </p>
            </div>
        </div>
    </div>
</footer>
<script>
    function submitEvaluation(satisfaccion) {
        // Obtener el token CSRF de la página
        var token = $('meta[name="csrf-token"]').attr('content');

        // Realizar una solicitud AJAX para enviar la evaluación al controlador
        $.ajax({
            url: '/guardar-respuesta',
            type: 'POST',
            data: {
                satisfaccion: satisfaccion,
                _token: token // Incluir el token CSRF en los datos de la solicitud
            },
            success: function(response) {
                // Manejar la respuesta del servidor si es necesario
                console.log('La evaluación se ha enviado correctamente.');
                $('#evaluationDiv').hide();
            },
            error: function(xhr, status, error) {
                // Manejar errores si los hay
                console.error('Error al enviar la evaluación:', error);
            }
        });
    }
</script>
