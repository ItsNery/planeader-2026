<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Portal de Planeación para el Desarrollo</title>
    <meta content='width=device-width, initial-scale=1' name='viewport'>
    <meta name="description" content="@yield('meta-description', 'Página informativa del Sistema Estatal de Planeación Democrática del Estado de Puebla')">
    <meta name="keywords" content="@yield('keywords', 'Planeación Democrática, Plan Estatal de Desarrollo, Puebla, PLANEADER, Gobierno, Estado de Puebla, Planeación Democrática, Sistema Estatal, Desarrollo Estatal, Planeación del Desarrollo, Gobierno de Puebla, Plan Estatal de Desarrollo, Sistema de Planeación, Planeación en Puebla, Desarrollo en Puebla, Política Pública, Gestión Pública, Administración Estatal, Planeación Estratégica, Participación Ciudadana, Transparencia, Rendición de Cuentas')">
    <meta name="author" content="Ing. Nery Pozos">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="google" content="notranslate">
    <meta name="googlebot" content="index, follow">
    <meta name="google-site-verification" content="SqonXYfmVQHShjVZynKkL9mNRhYQfCm97J8zW2fYiyc" />
    <meta name="bingbot" content="index, follow">
    <meta name="referrer" content="no-referrer-when-downgrade">
    <meta name="format-detection" content="telephone=no">
    <meta name="HandheldFriendly" content="True">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#a0153e">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta property="og:title" content="@yield('og-title', 'Portal de Planeación para el Desarrollo - Gobierno del Estado de Puebla')">
    <meta property="og:description" content="@yield('og-description', 'Página Informativa del Portal de Planeación para el Desarrollo del Gobierno del Estado de Puebla')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="@yield('og:url', 'https://planeader.puebla.gob.mx')">
    <meta property="og:image" content="@yield('og:image', 'https://planeader.puebla.gob.mx/baners/Banners-PLANEADER-portada%20(1)_20240522223737.jpg')">
    <meta property="og:site_name" content="Portal de Planeación para el Desarrollo del Gobierno del Estado de Puebla">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter-title', 'Portal de Planeación para el Desarrollo del Gobierno del Estado de Puebla')">
    <meta name="twitter:description" content="@yield('twitter-description', 'Página Informativa del Portal de Planeación para el Desarrollo del Gobierno del Estado de Puebla')">
    <meta name="twitter:image" content="@yield('twitter:image', 'https://planeader.puebla.gob.mx/baners/Banners-PLANEADER-portada%20(1)_20240522223737.jpg')">
    <link rel="canonical" href="@yield('canonical-url', 'https://planeader.puebla.gob.mx')">
    <!-- Favicon -->
    <link href="{{ asset('imagen/favicon.ico') }}" rel="icon">
    <link rel="shortcut icon" href="{{ asset('imagen/favicon.ico') }}" type="image/x-icon">
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

    @yield('page_css')
    <script src="{{ asset('js/sienna.min.js') }}" defer></script>

    <!-- Librerías de hojas de estilo de Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">

    <!-- Librerias de AOS -->
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet">

    <!-- Hojas de estilos de Bootstrap  -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <!-- Font Awesome por Defecto -->
    <link rel="stylesheet" href="{{ asset('fontAwesome/css/all.min.css') }}">
    {{-- <script src="https://kit.fontawesome.com/30136daf60.js" crossorigin="anonymous" defer></script> --}}

    <!-- Font Awesome de respaldo por si se agota el anterior -->
    {{-- <script src="https://kit.fontawesome.com/ac09196313.js" crossorigin="anonymous" defer></script> --}}

    <!-- Template CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('css/estilos.css') }}?v={{ rand() }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/estilos_nuevo.css') }}?v={{ rand() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    @yield('page_css')
    @yield('jss')
    <script src="{{ asset('js/nuevos-scripts.js') }}"></script>
    @yield('css')
</head>

<body>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-D6EBV94D3Y"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-D6EBV94D3Y');
    </script>
    <div class="loader-section">
        <span class="loader"></span>
    </div>
    @auth
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        {{ __('Panel') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    @endauth

    <main>
        {{-- @include('layouts.headers') --}}
        @include('layouts.headers-nuevo')
        <!-- Modal del Buscador -->
        {{-- <div id="customSearchModal" class="custom-modal-search">
                <div class="custom-modal-content">
                    <div class="custom-modal-header">
                        <span class="custom-close" onclick="closeSearchModal()">&times;</span>
                        <h5 class="custom-modal-title">Buscar con Google</h5>
                    </div>
                    <div class="custom-modal-body">
                        <script async src="https://cse.google.com/cse.js?cx=c698ccbd0dcc64e6f"></script>
                        <div class="gcse-searchbox-only"></div>
                    </div>
                </div>
            </div> --}}
        @yield('content')
        @include('layouts.carrusel_sitios_nuevo')
        @include('layouts.footer')
        <button id="scrollTopBtn" title="Volver arriba">
            <svg width="100%" height="100%" viewBox="0 0 40 40">
                <g class="progress-ring-wrapper">
                    <circle class="progress-ring__bg" cx="20" cy="20" r="18" />
                    <circle class="progress-ring__circle" cx="20" cy="20" r="18" />
                </g>
                <polyline class="arrow-up" points="16,22 20,18 24,22" />
            </svg>
        </button>
    </main>


    @yield('scripts')
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/aos.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="{{ asset('js/scripts.js') }}"></script> --}}
</body>

</html>
