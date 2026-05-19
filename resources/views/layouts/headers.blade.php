<header class="site-header">
    <div class="header-top">
        <div class="header-logos">
            <a href="{{ url('/') }}"><img src="{{ asset('img/Logos-SPFA_.png') }}" alt="Logo Gobierno de Puebla"></a>
        </div>

        <button class="hamburger-menu" id="hamburger-menu" aria-label="Abrir menú de navegación">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>
    </div>

    <nav class="main-nav" id="main-nav">
        <div class="header-branding-bar"></div>

        <div class="navbar">
            <div class="nav-brand-line"></div>
            <ul class="nav-links">
                <li>
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                        Inicio
                    </a>
                </li>
                <li>
                    <a href="{{ url('/marcojuridico') }}" class="{{ request()->is('marcojuridico') ? 'active' : '' }}">
                        Marco Jurídico
                    </a>
                </li>
                <li>
                    <a href="{{ url('/regionalizacion') }}"
                        class="{{ request()->is('regionalizacion') ? 'active' : '' }}">
                        Regionalización
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#"
                        class="{{ request()->is('ped', 'ped-programas', 'copladep', 'subcomites*', 'programas-estatales', 'copladep/primera-sesion-ordinaria', 'ped-programas/capacitacion', 'herramientas-planeacion') ? 'active' : '' }}">
                        Planeación Estatal &#9662;</a>
                    <ul class="dropdown-content">
                        <li class="{{ request()->is('ped') ? 'active' : '' }}">
                            <a href="{{ url('/ped') }}">
                                Plan Estatal
                                de Desarrollo
                            </a>
                        </li>
                        <li class="{{ request()->is('ped-programas') ? 'active' : '' }}">
                            <a href="{{ url('/ped-programas') }}">
                                Programas Derivados</a>
                        </li>
                        <li class="{{ request()->is('ped-programas/capacitacion') ? 'active' : '' }}">
                            <a href="{{ url('/ped-programas/capacitacion') }}">
                                Capacitacion Programas Derivados
                            </a>
                        </li>
                        <li class="{{ request()->is('copladep') ? 'active' : '' }}">
                            <a href="{{ url('/copladep') }}">
                                COPLADEP
                            </a>
                        </li>
                        <li class="{{ request()->is('copladep/primera-sesion-ordinaria') ? 'active' : '' }}">
                            <a href="{{ url('/copladep/primera-sesion-ordinaria') }}">
                                Primera sesión ordinaria
                            </a>
                        </li>
                        <li class="{{ request()->is('programas-estatales') ? 'active' : '' }}">
                            <a href="{{ url('/programas-estatales') }}">
                                Programas Estatales
                            </a>
                        </li>
                        <li class="{{ request()->is('subcomites*') ? 'active' : '' }}">
                            <a href="{{ url('/subcomites') }}">
                                Subcomités
                            </a>
                        </li>
                        <li class="{{ request()->is('herramientas-planeacion') ? 'active' : '' }}">
                            <a href="{{ url('/herramientas-planeacion') }}">
                                Herramientas de Planeación
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#"
                        class="{{ request()->is('planesmunicipales', 'coplademun', 'capacitacion-municipal', 'documentos-metodologicos') ? 'active' : '' }}">Planeación
                        Municipal &#9662;</a>
                    <ul class="dropdown-content">
                        <li class="{{ request()->is('planesmunicipales') ? 'active' : '' }}">
                            <a href="{{ url('/planesmunicipales') }}">
                                Planes Municipales de Desarrollo
                            </a>
                        </li>
                        <li class="{{ request()->is('coplademun') ? 'active' : '' }}">
                            <a href="{{ url('/coplademun') }}">
                                COPLADEMUN
                            </a>
                        </li>
                        <li class="{{ request()->is('capacitacion-municipal') ? 'active' : '' }}">
                            <a href="{{ url('/capacitacion-municipal') }}">
                                Capacitación municipal
                            </a>
                        </li>
                        <li class="{{ request()->is('documentos-metodologicos') ? 'active' : '' }}">
                            <a href="{{ url('/documentos-metodologicos') }}">
                                Documentos metodológicos
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('/contacto') }}" class="{{ request()->is('contacto') ? 'active' : '' }}">
                        Contacto
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
