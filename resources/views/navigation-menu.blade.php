<nav class="navbar navbar-expand-md navbar-light bg-white border-bottom sticky-top">
    <div class="container">
        {{-- local --}}
        <!-- Logo -->
        <a class="navbar-brand me-4" href="/">

            <img src="{{ asset('img/icon-black.ico') }}" alt="" width="100px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Inicio') }}
                </x-nav-link>

                <!-- Documentos Dropdown -->
                @canany(['ver-doc-subcomite', 'ver-doc-copladep', 'ver-marco-juridico', 'ver-doc-apoyo',
                    'ver-doc-metodologico', 'ver-doc-sesion', 'ver-listado-registro-copladep'])
                    <x-dropdown id="docsDropdown" :active="request()->routeIs([
                        'panel-documentos-subcomites*',
                        'panel-documentos-copladep*',
                        'panel-marco-juridico*',
                        'panel-documentos-apoyo-coplademun*',
                        'panel-documentos-metodologicos*',
                        'copladep-registro.index'
                        // 'panel-documentos-sesiones*',
                    ])">
                        <x-slot name="trigger">
                            {{ __('Documentos') }}
                        </x-slot>
                        <x-slot name="content">
                            @can('ver-doc-subcomite')
                                <x-dropdown-link href="{{ route('panel-documentos-subcomites.index') }}">
                                    {{ __('Docs. Subcomités') }}
                                </x-dropdown-link>
                            @endcan
                            @can('ver-doc-copladep')
                                <x-dropdown-link href="{{ route('panel-documentos-copladep.index') }}">
                                    {{ __('Docs. Copladep') }}
                                </x-dropdown-link>
                            @endcan
                            @can('ver-marco-juridico')
                                <x-dropdown-link href="{{ route('panel-marco-juridico.index') }}">
                                    {{ __('Marco Jurídico') }}
                                </x-dropdown-link>
                            @endcan
                            @can('ver-doc-apoyo')
                                <x-dropdown-link href="{{ route('panel-documentos-apoyo-coplademun.index') }}">
                                    {{ __('Apoyo Coplademun') }}
                                </x-dropdown-link>
                            @endcan
                            @can('ver-doc-metodologico')
                                <x-dropdown-link href="{{ route('panel-documentos-metodologicos.index') }}">
                                    {{ __('Metodológicos') }}
                                </x-dropdown-link>
                            @endcan
                            @can('ver-listado-registro-copladep')
                                <x-dropdown-link href="{{ route('copladep-registro.index') }}">
                                    {{ __('Sesión COPLADEP') }}
                                </x-dropdown-link>
                            @endcan
                            {{-- @can('ver-doc-sesion')
                                <x-dropdown-link href="{{ route('panel-documentos-sesiones.index') }}">
                                    {{ __('Docs. Sesiones') }}
                                </x-dropdown-link>
                            @endcan --}}
                            @can('ver-documento-insumo-ped')
                                <x-dropdown-link href="{{ route('panel-documentos-insumo-ped.index') }}">
                                    {{ __('Insumos PED') }}
                                </x-dropdown-link>
                            @endcan
                        </x-slot>
                    </x-dropdown>
                @endcanany

                <!-- Planeación Dropdown -->
                @canany(['ver-plan-estatal', 'ver-plan-municipal', 'ver-herramienta', 'ver-capacitacion',
                    'ver-subcomite'])
                    <x-dropdown id="planeacionDropdown" :active="request()->routeIs([
                        'panel-planes-estatales*',
                        'panel-planes-municipales*',
                        'panel-herramientas*',
                        'capacitaciones*',
                        'panel-subcomites*',
                    ])">
                        <x-slot name="trigger">
                            {{ __('Planeación') }}
                        </x-slot>
                        <x-slot name="content">
                            @can('ver-plan-estatal')
                                <x-dropdown-link href="{{ route('panel-planes-estatales.index') }}">
                                    {{ __('Planes Estatales') }}
                                </x-dropdown-link>
                            @endcan
                            @can('ver-plan-municipal')
                                <x-dropdown-link href="{{ route('panel-planes-municipales.index') }}">
                                    {{ __('Planes Municipales') }}
                                </x-dropdown-link>
                            @endcan
                            @can('ver-herramienta')
                                <x-dropdown-link href="{{ route('panel-herramientas.index') }}">
                                    {{ __('Herramientas de planeación') }}
                                </x-dropdown-link>
                            @endcan
                            @can('ver-capacitacion')
                                <x-dropdown-link href="{{ route('capacitaciones.index') }}">
                                    {{ __('Capacitaciones municipales') }}
                                </x-dropdown-link>
                            @endcan
                            @can('ver-subcomite')
                                <x-dropdown-link href="{{ route('panel-subcomites.index') }}">
                                    {{ __('Subcomités') }}
                                </x-dropdown-link>
                            @endcan
                        </x-slot>
                    </x-dropdown>
                @endcanany

                <!-- Programas Dropdown -->
                @canany(['ver-programa-derivado', 'ver-programa-estatales'])
                    <x-dropdown id="programasDropdown" :active="request()->routeIs(['panel-programas-derivados*', 'panel-programas-estatales*'])">
                        <x-slot name="trigger">
                            {{ __('Programas') }}
                        </x-slot>
                        <x-slot name="content">
                            @can('ver-programa-derivado')
                                <x-dropdown-link href="{{ route('panel-programas-derivados.index') }}">
                                    {{ __('Derivados') }}
                                </x-dropdown-link>
                            @endcan
                            @can('ver-programa-estatales')
                                <x-dropdown-link href="{{ route('panel-programas-estatales.index') }}">
                                    {{ __('Estatales') }}
                                </x-dropdown-link>
                            @endcan

                        </x-slot>
                    </x-dropdown>
                @endcanany

                <!-- Gestión Dropdown -->
                @canany(['ver-banner', 'ver-contacto', 'ver-usuario'])
                    <x-dropdown id="gestionDropdown" :active="request()->routeIs([
                        'panel-banners*',
                        'panel-contacto*',
                        'panel-admin*',
                        'panel-roles*',
                    ])">
                        <x-slot name="trigger">
                            {{ __('Gestión') }}
                        </x-slot>
                        <x-slot name="content">
                            @can('ver-banner')
                                <x-dropdown-link href="{{ route('panel-banners.index') }}">
                                    {{ __('Banners') }}
                                </x-dropdown-link>
                            @endcan
                            @can('ver-contacto')
                                <x-dropdown-link href="{{ route('panel-contacto.index') }}">
                                    {{ __('Mensajes de contacto') }}
                                </x-dropdown-link>
                            @endcan
                            @can('ver-usuario')
                                <x-dropdown-link href="{{ route('panel-admin.index') }}">
                                    {{ __('Usuarios') }}
                                </x-dropdown-link>
                            @endcan
                            @can('ver-rol')
                                <x-dropdown-link href="{{ route('panel-roles.index') }}">
                                    {{ __('Roles y Permisos') }}
                                </x-dropdown-link>
                            @endcan
                        </x-slot>
                    </x-dropdown>
                @endcanany
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav align-items-baseline">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <x-dropdown id="teamManagementDropdown">
                        <x-slot name="trigger">
                            {{ Auth::user()->currentTeam->name }}

                            <svg class="ms-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Team Management -->
                            <h6 class="dropdown-header">
                                {{ __('Manage Team') }}
                            </h6>

                            <!-- Team Settings -->
                            <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                {{ __('Team Settings') }}
                            </x-dropdown-link>

                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-dropdown-link href="{{ route('teams.create') }}">
                                    {{ __('Create New Team') }}
                                </x-dropdown-link>
                            @endcan

                            <hr class="dropdown-divider">

                            <!-- Team Switcher -->
                            <h6 class="dropdown-header">
                                {{ __('Switch Teams') }}
                            </h6>

                            @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team" />
                            @endforeach
                        </x-slot>
                    </x-dropdown>
                @endif

                <!-- Settings Dropdown -->
                @auth
                    <x-dropdown id="settingsDropdown">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <img class="rounded-circle" width="32" height="32"
                                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            @else
                                {{ Auth::user()->name }}

                                <svg class="ms-2" width="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <h6 class="dropdown-header small text-muted">
                                {{ __('Gestionar cuenta') }}
                            </h6>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Perfil') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <hr class="dropdown-divider">

                            <!-- Authentication -->
                            <x-dropdown-link href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                {{ __('Cerrar sesión') }}
                            </x-dropdown-link>
                            <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                @csrf
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </ul>
        </div>
    </div>
</nav>
