<header>
    <div class="encabezado">
        <div class="logo-box">
            <img loading="lazy" src="{{ asset('img/logo_gobierno.png') }}" alt="Logo de Gobierno" title="Logo del Gobierno del Estado de Puebla">
            <!-- <img loading="lazy" src="{{ asset('img/logo_spf.png') }}" alt="Logo de secretaría" title="Logo de la SPF"> -->
        </div>
    </div>
</header>


<header class="header_section">
    <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container">
            <a class="navbar-brand" href="inicio" title="Inicio"> </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="s-1"> </span>
                <span class="s-2"> </span>
                <span class="s-3"> </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
                    <ul class="navbar-nav">
                        <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/') }}">Inicio</a>
                        </li>
                        <li class="nav-item {{ request()->is('marcojuridico') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/marcojuridico') }}">Marco Jurídico</a>
                        </li>
                        <li class="nav-item {{ request()->is('regionalizacion') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/regionalizacion') }}">Regionalización</a>
                        </li>
                        <li
                            class="nav-item dropdown {{ request()->is('ped', 'ped-programas', 'copladep', 'subcomites*', 'herramientas-planeacion', 'programas-estatales') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="#" id="recursosDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Planeación Estatal
                            </a>
                            <div class="dropdown-menu" aria-labelledby="recursosDropdown2">
                                <a class="dropdown-item" href="{{ url('/ped') }}">Plan Estatal de Desarrollo</a>
                                <a class="dropdown-item" href="{{ url('/ped-programas') }}">Programas Derivados</a>
                                <a class="dropdown-item" href="{{ url('/programas-estatales') }}">Programas Estatales</a>
                                <a class="dropdown-item" href="{{ url('/copladep') }}">COPLADEP</a>
                                <a class="dropdown-item" href="{{ url('/subcomites') }}">Subcomités</a>
                                <a class="dropdown-item" href="{{ url('/herramientas-planeacion') }}">Herramientas de Planeación</a>
                            </div>
                        </li>
                        <li
                            class="nav-item dropdown {{ request()->is('planesmunicipales', 'coplademun', 'capacitaciones', 'documentos-metodologicos') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="#" id="recursosDropdown2" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Planeación Municipal
                            </a>
                            <div class="dropdown-menu" aria-labelledby="recursosDropdown">
                                <a class="dropdown-item" href="{{ url('/planesmunicipales') }}">Planes Municipales de
                                    Desarrollo </a>
                                <a class="dropdown-item" href="{{ url('/coplademun') }}">COPLADEMUN</a>
                                <a class="dropdown-item" href="{{ url('/capacitacion-municipal') }}">Capacitación
                                    municipal</a>
                                <a class="dropdown-item" href="{{ url('/documentos-metodologicos') }}">Documentos
                                    metodológicos</a>
                            </div>
                        </li>
                        <li class="nav-item {{ request()->is('contacto') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/contacto') }}">Contacto</a>
                        </li>
                        <!-- Icono de Lupa -->
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="openSearchModal()">
                                <i class="fas fa-search"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </nav>
    </div>
</header>
<!-- Modal del Buscador -->
<div id="customSearchModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <span class="custom-close" onclick="closeSearchModal()">&times;</span>
            <h5 class="custom-modal-title">Buscar</h5>
        </div>
        <div class="custom-modal-body">
            {{-- <script async src="https://cse.google.com/cse.js?cx=c698ccbd0dcc64e6f"></script>
            <div class="gcse-search"></div> --}}
            <script async src="https://cse.google.com/cse.js?cx=c698ccbd0dcc64e6f"></script>
            <div class="gcse-searchbox-only"></div>
        </div>
    </div>
</div>
<script>
    function openSearchModal() {
        document.getElementById("customSearchModal").style.display = "block";
    }

    function closeSearchModal() {
        document.getElementById("customSearchModal").style.display = "none";
    }

    // Cerrar el modal cuando el usuario haga clic fuera del modal
    window.onclick = function(event) {
        if (event.target == document.getElementById("customSearchModal")) {
            document.getElementById("customSearchModal").style.display = "none";
        }
    }
</script>

<script>
    window.addEventListener('load', function() {
        if (window.location.hash && window.location.hash.startsWith('#gsc.tab=0')) {
            window.location.hash = '';
        }
    });
</script>
