<!DOCTYPE html>
<html lang="es">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="UTF-8">
    <title>Consulta Ciudadana para la Elaboración del Plan Estatal de Desarrollo 2024-2030</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Consulta Ciudadana para la elaboración del Plan Estatal de Desarrollo 2024-2030. Participa activamente en el diseño del futuro de nuestro estado.">
    <meta name="keywords"
        content="Consulta Ciudadana, Plan Estatal de Desarrollo, Desarrollo 2024-2030, Participación Ciudadana, Gobierno, Sociedad">
    <meta name="author" content="Ing. Nery Pozos">
    <meta name="robots" content="index, follow">
    <meta name="google-site-verification" content="SqonXYfmVQHShjVZynKkL9mNRhYQfCm97J8zW2fYiyc" />

    <!-- Meta para redes sociales (Open Graph) -->
    <meta property="og:title" content="Consulta Ciudadana para el Plan Estatal de Desarrollo 2024-2030">
    <meta property="og:description"
        content="Participa en la consulta ciudadana para diseñar el futuro de nuestro estado. Haz escuchar tu voz en el Plan Estatal de Desarrollo 2024-2030.">
    <meta property="og:image" content="{{ asset('assets-consulta/images/logo-gobierno-1.png') }}">
    <meta property="og:url" content="https://planeader.puebla.gob.mx/consultaciudadana2025">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_MX">

    <!-- Meta para Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Consulta Ciudadana para el Plan Estatal de Desarrollo 2024-2030">
    <meta name="twitter:description"
        content="Participa en la consulta ciudadana para diseñar el futuro de nuestro estado. Haz escuchar tu voz en el Plan Estatal de Desarrollo 2024-2030.">
    <meta name="twitter:image" content="{{ asset('assets-consulta/images/logo-gobierno-1.png') }}">
    <meta name="twitter:site" content="@Gob_Puebla">

    <!-- Favicon -->
    <link href="{{ asset('assets-consulta/images/logo-gobierno-1.png') }}" rel="icon">

    <!--font-awesome icons link-->
    <link href="{{ asset('assets-consulta/css/fontAwesome/css/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-consulta/css/fontAwesome/css/brands.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-consulta/css/fontAwesome/css/solid.css') }}" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets-consulta/css/bootstrap.min.css') }}">

    <!--main style file-->
    <link rel="stylesheet" href="{{ asset('assets-consulta/css/style.css') }}?v={{ random_int(100000, 999999) }}">
    <script src="{{ asset('js/sienna.min.js') }}" defer></script>
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="5">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZCCNT2GY0F"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-ZCCNT2GY0F');
    </script>

    <div class="loder">
        <div class="cube-wrapper">
            <div class="cube-folding">
                <span class="leaf1"></span>
                <span class="leaf2"></span>
                <span class="leaf3"></span>
                <span class="leaf4"></span>
            </div>
            <span class="loading" data-name="Loading">Cargando</span>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container">
            <a class='navbar-brand' href='#'>
                <img src="{{ asset('assets-consulta/images/logo-spf-negativo.png') }}?v={{ random_int(100000, 999999) }}"
                    alt="Logos de Gobierno en negativo" title="Gobierno del Estado de Puebla" class="w-50">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>

            <div class="collapse navbar-collapse menu-main" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto menu-item">
                    <li class="nav-item">
                        <a class="nav-link" href="#banner">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#encuesta">Encuesta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#foros">Foros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#propuesta">Propuestas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#acerca">Acerca de</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="banner" id="banner">
        <div class="imagen-banner">
            <img src="{{ asset('assets-consulta/images/banner-1.png') }}?v={{ random_int(100000, 999999) }}"
                alt="Banner principal de la Consulta" title="Consulta Ciudadana " class="w-100">
        </div>
    </section>

    <section id="acerca">
        <div class=" backtotop">
            <a href="#"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
        </div>
        <div class="container">
            <div class="row titulo">
                <div class="col-lg-12 header-text about-header">
                    <h3>Bienvenido a la <span>Consulta</span></h3>
                </div>
            </div>
            <br>
            <div class="container desc">
                <p class="text-justify">
                    El Plan Estatal de Desarrollo (PED) 2024-2030 busca definir las metas del gobierno con la
                    colaboración activa de la sociedad.
                </p>
                <p class="text-justify">
                    A través de consultas, foros y encuestas, el PED 2024-2030 escucha las voces de quienes viven y
                    trabajan en Puebla, colocando a las personas en el centro de las decisiones para garantizar su
                    bienestar.
                </p>


                {{-- <p class="text-justify">
                    La participación ciudadana es el pilar fundamental para la construcción de políticas públicas efectivas y alineadas con las necesidades reales de la población. En este contexto, el Plan Estatal de Desarrollo (PED) se concibe como un instrumento estratégico que no solo define las metas y prioridades del gobierno, sino que también involucra de manera activa a la ciudadanía en su formulación, diseño, implementación y evaluación.
                </p>
                <p class="text-justify">
                    El bienestar colectivo depende de la colaboración entre los diferentes actores sociales, incluidos los ciudadanos, organizaciones civiles, instituciones académicas, empresas y el sector público. Por ello, se ha establecido un enfoque participativo que fomenta el diálogo, la inclusión y el empoderamiento de los diversos sectores de la sociedad para garantizar que las decisiones tomadas respondan a las verdaderas aspiraciones de la comunidad.
                </p>
                <p class="text-justify">
                    A través de mecanismos de consulta, foros de debate, encuestas y otras formas de interacción directa, el PED 2024-2030 busca integrar las voces de quienes viven, trabajan y se desarrollan en el estado de Puebla, promoviendo los principios del Humanismo Mexicano y de la Bioética Social, con el fin de colocar al ser humano en el centro de las políticas públicas, reconociendo su valor intrínseco, su dignidad y su bienestar integral.
                </p>
                <p class="text-justify">
                    El compromiso con la participación activa de todos los actores sociales es, por tanto, una garantía de que el PED 2024-2030 será un reflejo de las verdaderas necesidades y expectativas de la sociedad poblana, asegurando procesos inclusivos y éticamente responsables.
                </p> --}}
            </div>
            <div class="row titulo">
                <div class="col-lg-12 secondary-header">
                    <h3 class="">¿Qué es el <span>Plan Estatal de Desarrollo?</span></h3>
                </div>
            </div>
            <div class="container desc">
                {{-- <p class="text-justify">
                    Es el instrumento rector del poder Ejecutivo Estatal que con base en la Ley de Planeación
                    consolidará el Segundo Piso de la Cuarta Transformación, mediante la materialización de los
                    sentimientos, demandas, necesidades y exigencias de las y los poblanos. Con términos y acciones
                    inclusivas se buscará mejorar su calidad de vida, con fortalecimiento de las instituciones
                    gubernamentales, construcción de una economía circular, reconstrucción del tejido social, en un
                    ambiente sustentable, permitiendo el libre y pleno desarrollo del individuo con programas,
                    estrategias y acciones medibles que se puedan evaluar con una estructura programática y asignación
                    presupuestal. Por amor a Puebla.
                </p> --}}
                <p class="text-justify">
                    Es el instrumento rector del poder Ejecutivo Estatal para mejorar la calidad de vida de la población
                    en los próximos años y consolidará el Segundo Piso de la Cuarta Transformación, mediante la
                    materialización de los sentimientos, demandas, necesidades y exigencias de las y los poblanos.
                </p>
            </div>

            <div class="d-flex justify-content-center">
                <img src="{{ asset('assets-consulta/images/Ejes.png') }}?v={{ random_int(100000, 999999) }}"
                    alt="Esquema Ejes" class="w-100 cursor-pointer" title="Esquema de los Ejes del PED">
            </div>


        </div>
    </section>

    <section id="encuesta">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 header-text ht-2">
                    <h3 class="text-white">Encuesta <span>Ciudadana</span></h3>
                </div>
            </div>
            <div class="container text-center">
                <p class="my-4 text-justify text-white">
                    Recopilar información precisa y representativa sobre las opiniones, necesidades, y percepciones de
                    la población, con la finalidad de estructurar un diagnóstico integral y representativo.
                </p>
                <p class="my-4 text-justify text-white">
                    ¡Por Amor a Puebla! Tu opinión es muy importante para construir el segundo piso de la Cuarta
                    Transformación
                </p>

                <button class="btn btn-lg boton-encuesta">
                    ¡Gracias por participar!
                </button>
            </div>
        </div>
    </section>

    <section id="foros">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 header-text ht-2">
                    <h3>Foros<span> Presenciales</span></h3>
                </div>
            </div>
            <div class="container">
                <p class="mt-3 text-justify">
                    Fomentar un espacio de diálogo abierto y constructivo que promueva el intercambio de opiniones,
                    ideas y perspectivas entre los participantes, fortaleciendo la libertad de expresión y la
                    colaboración ciudadana.
                </p>
                <p class="my-3 text-justify">
                    ¡Tú participación es muy importante! Participa en la construcción del segundo piso de la Cuarta
                    Transformación
                </p>
                <h3 class="text-center mb-4 calendario">Calendario</h3>
                <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active pills-foros" id="pills-foro1-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-foro1" type="button" role="tab" aria-controls="pills-foro1"
                            aria-selected="true">
                            Foro 1
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link pills-foros" id="pills-foro2-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-foro2" type="button" role="tab" aria-controls="pills-foro2"
                            aria-selected="false">
                            Foro 2
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link pills-foros" id="pills-foro3-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-foro3" type="button" role="tab" aria-controls="pills-foro3"
                            aria-selected="false">
                            Foro 3
                        </button>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link pills-foros" id="pills-foro4-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-foro4" type="button" role="tab" aria-controls="pills-foro4"
                            aria-selected="false">
                            Foro 4
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link pills-foros" id="pills-foro5-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-foro5" type="button" role="tab" aria-controls="pills-foro5"
                            aria-selected="false">
                            Foro 5
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link pills-foros" id="pills-foro6-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-foro6" type="button" role="tab" aria-controls="pills-foro6"
                            aria-selected="false">
                            Foro 6
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link pills-foros" id="pills-foro7-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-foro7" type="button" role="tab" aria-controls="pills-foro7"
                            aria-selected="false">
                            Foro 7
                        </button>
                    </li>
                    </li>
                </ul>
                <div class="tab-content pb-5" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-foro1" role="tabpanel"
                        aria-labelledby="pills-foro1-tab">
                        <div class="card">
                            <div class="card-body">
                                <!-- Título del foro -->
                                <h2 class="card-title text-center fw-bold titulo-foros">
                                    Foro Ciudadano de Consulta 1
                                </h2>

                                <!-- Datos principales -->
                                <p><strong>Fecha:</strong> 14 de enero de 2025</p>
                                <p><strong>Hora:</strong> 09:00 a 13:00 horas</p>
                                <p><strong>Sede:</strong> Instituto Tecnológico Superior de Huauchinango</p>

                                <!-- Temáticas -->
                                <div class="container mt-4">
                                    <h4 class="text-center my-3 text-white py-2"
                                        style="background-color: #920B32; border-radius: 8px; font-size: 1.4rem; font-weight: 600;">
                                        Temáticas de las mesas de trabajo
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-heart"></i>
                                                    </div>
                                                    <h6 class="card-title">Humanismo con bienestar</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-chart-line"></i>
                                                    </div>
                                                    <h6 class="card-title">Prosperidad y economía</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-handshake"></i>
                                                    </div>
                                                    <h6 class="card-title">Gobierno Incluyente</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-shield-alt"></i>
                                                    </div>
                                                    <h6 class="card-title">Seguridad y paz social</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-leaf"></i>
                                                    </div>
                                                    <h6 class="card-title">Desarrollo sustentable y sostenible</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mapa -->
                                <div class="ratio ratio-21x9 mt-4">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3745.331222732934!2d-98.04480702404108!3d20.161929981279343!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d089f6df6152d7%3A0x30e0fe3628115e97!2sInstituto%20Tecnol%C3%B3gico%20Superior%20de%20Huauchinango!5e0!3m2!1ses-419!2smx!4v1736374124871!5m2!1ses-419!2smx"
                                        allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-foro2" role="tabpanel" aria-labelledby="pills-foro2-tab">
                        <div class="card">
                            <div class="card-body">
                                <!-- Título del foro -->
                                <h2 class="card-title text-center fw-bold titulo-foros">
                                    Foro Ciudadano de Consulta 2
                                </h2>

                                <!-- Datos principales -->
                                <p><strong>Fecha:</strong> 17 de enero de 2025</p>
                                <p><strong>Hora:</strong> 09:00 a 13:00 horas</p>
                                <p><strong>Ubicación:</strong> Instituto Tecnológico Superior de Teziutlán</p>

                                <!-- Temáticas -->
                                <div class="container mt-4">
                                    <h4 class="text-center my-3 text-white py-2"
                                        style="background-color: #920B32; border-radius: 8px; font-size: 1.4rem; font-weight: 600;">
                                        Temáticas de las mesas de trabajo
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-heart"></i>
                                                    </div>
                                                    <h6 class="card-title">Humanismo con bienestar</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-chart-line"></i>
                                                    </div>
                                                    <h6 class="card-title">Prosperidad y economía</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-handshake"></i>
                                                    </div>
                                                    <h6 class="card-title">Gobierno Incluyente</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-shield-alt"></i>
                                                    </div>
                                                    <h6 class="card-title">Seguridad y paz social</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-leaf"></i>
                                                    </div>
                                                    <h6 class="card-title">Desarrollo sustentable y sostenible</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mapa -->
                                <div class="ratio ratio-21x9 mt-4">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3751.989348240186!2d-97.39563102404709!3d19.88267168149514!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85daeb9dcac8978f%3A0x113530f496e336f9!2sInstituto%20Tecnol%C3%B3gico%20Superior%20de%20Teziutl%C3%A1n!5e0!3m2!1ses-419!2smx!4v1736374230843!5m2!1ses-419!2smx"
                                        allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-foro3" role="tabpanel" aria-labelledby="pills-foro3-tab">
                        <div class="card">
                            <div class="card-body">
                                <!-- Título del foro -->
                                <h2 class="card-title text-center fw-bold titulo-foros">
                                    Foro Ciudadano de Consulta 3
                                </h2>

                                <!-- Datos principales -->
                                <p><strong>Fecha:</strong> 20 de enero de 2025</p>
                                <p><strong>Hora:</strong> 09:00 a 13:00 horas</p>
                                <p><strong>Ubicación:</strong> Instituto Tecnológico Superior de Acatlán</p>

                                <!-- Temáticas -->
                                <div class="container mt-4">
                                    <h4 class="text-center my-3 text-white py-2"
                                        style="background-color: #920B32; border-radius: 8px; font-size: 1.4rem; font-weight: 600;">
                                        Temáticas de las mesas de trabajo
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-heart"></i>
                                                    </div>
                                                    <h6 class="card-title">Humanismo con bienestar</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-chart-line"></i>
                                                    </div>
                                                    <h6 class="card-title">Prosperidad y economía</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-handshake"></i>
                                                    </div>
                                                    <h6 class="card-title">Gobierno Incluyente</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-shield-alt"></i>
                                                    </div>
                                                    <h6 class="card-title">Seguridad y paz social</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-leaf"></i>
                                                    </div>
                                                    <h6 class="card-title">Desarrollo sustentable y sostenible</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mapa -->
                                <div class="ratio ratio-21x9 mt-4">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3789.666415572617!2d-98.04143582408126!3d18.22524698281191!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cf4182fb37cc4f%3A0xf1a9691f53f1acf!2sInstituto%20Tecnol%C3%B3gico%20Superior%20de%20Acatl%C3%A1n%20de%20Osorio!5e0!3m2!1ses-419!2smx!4v1736374260157!5m2!1ses-419!2smx"
                                        allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-foro4" role="tabpanel" aria-labelledby="pills-foro4-tab">
                        <div class="card">
                            <div class="card-body">
                                <!-- Título del foro -->
                                <h2 class="card-title text-center fw-bold titulo-foros">
                                    Foro Ciudadano de Consulta 4
                                </h2>

                                <!-- Datos principales -->
                                <p><strong>Fecha:</strong> 21 de enero de 2025</p>
                                <p><strong>Hora:</strong> 09:00 a 13:00 horas</p>
                                <p>
                                    <strong>Ubicación:</strong> Complejo Regional Mixteca Campus Izúcar de Matamoros
                                    BUAP
                                </p>

                                <!-- Temáticas -->
                                <div class="container mt-4">
                                    <h4 class="text-center my-3 text-white py-2"
                                        style="background-color: #920B32; border-radius: 8px; font-size: 1.4rem; font-weight: 600;">
                                        Temáticas de las mesas de trabajo
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-heart"></i>
                                                    </div>
                                                    <h6 class="card-title">Humanismo con bienestar</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-chart-line"></i>
                                                    </div>
                                                    <h6 class="card-title">Prosperidad y economía</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-handshake"></i>
                                                    </div>
                                                    <h6 class="card-title">Gobierno Incluyente</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-shield-alt"></i>
                                                    </div>
                                                    <h6 class="card-title">Seguridad y paz social</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-leaf"></i>
                                                    </div>
                                                    <h6 class="card-title">Desarrollo sustentable y sostenible</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mapa -->
                                <div class="ratio ratio-21x9 mt-4">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3780.673067918136!2d-98.47185052407305!3d18.633769082481816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cfaab966b3ad17%3A0xac58d7e73afb4a5d!2sComplejo%20Cultural%20de%20la%20Mixteca%20secci%C3%B3n%20Iz%C3%BAcar%20de%20Matamoros!5e0!3m2!1ses-419!2smx!4v1736374294980!5m2!1ses-419!2smx"
                                        allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-foro5" role="tabpanel" aria-labelledby="pills-foro5-tab">
                        <div class="card">
                            <div class="card-body">
                                <!-- Título del foro -->
                                <h2 class="card-title text-center fw-bold titulo-foros">
                                    Foro Ciudadano de Consulta 5
                                </h2>

                                <!-- Datos principales -->
                                <p><strong>Fecha:</strong> 23 de enero de 2025</p>
                                <p><strong>Hora:</strong> 09:00 a 13:00 horas</p>
                                <p><strong>Ubicación:</strong> Complejo Regional Nororiental Campus Libres BUAP</p>

                                <!-- Temáticas -->
                                <div class="container mt-4">
                                    <h4 class="text-center my-3 text-white py-2"
                                        style="background-color: #920B32; border-radius: 8px; font-size: 1.4rem; font-weight: 600;">
                                        Temáticas de las mesas de trabajo
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-heart"></i>
                                                    </div>
                                                    <h6 class="card-title">Humanismo con bienestar</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-chart-line"></i>
                                                    </div>
                                                    <h6 class="card-title">Prosperidad y economía</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-handshake"></i>
                                                    </div>
                                                    <h6 class="card-title">Gobierno Incluyente</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-shield-alt"></i>
                                                    </div>
                                                    <h6 class="card-title">Seguridad y paz social</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-leaf"></i>
                                                    </div>
                                                    <h6 class="card-title">Desarrollo sustentable y sostenible</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mapa -->
                                <div class="ratio ratio-21x9 mt-4">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3761.2865369818733!2d-97.6722788!3d19.4863043!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85daad247aa41c6b%3A0xc5dedcf3ac786660!2sBUAP%20COMPLEJO%20NORORIENTAL%20LIBRES%20PUEBLA!5e0!3m2!1ses-419!2smx!4v1737645604808!5m2!1ses-419!2smx"
                                        allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-foro6" role="tabpanel" aria-labelledby="pills-foro6-tab">
                        <div class="card">
                            <div class="card-body">
                                <!-- Título del foro -->
                                <h2 class="card-title text-center fw-bold titulo-foros">
                                    Foro Ciudadano de Consulta 6
                                </h2>

                                <!-- Datos principales -->
                                <p><strong>Fecha:</strong> 24 de enero de 2025</p>
                                <p><strong>Hora:</strong> 09:00 a 13:00 horas</p>
                                <p><strong>Ubicación:</strong> Complejo Regional Sur Campus Tehuacán BUAP</p>

                                <!-- Temáticas -->
                                <div class="container mt-4">
                                    <h4 class="text-center my-3 text-white py-2"
                                        style="background-color: #920B32; border-radius: 8px; font-size: 1.4rem; font-weight: 600;">
                                        Temáticas de las mesas de trabajo
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-heart"></i>
                                                    </div>
                                                    <h6 class="card-title">Humanismo con bienestar</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-chart-line"></i>
                                                    </div>
                                                    <h6 class="card-title">Prosperidad y economía</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-handshake"></i>
                                                    </div>
                                                    <h6 class="card-title">Gobierno Incluyente</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-shield-alt"></i>
                                                    </div>
                                                    <h6 class="card-title">Seguridad y paz social</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fas fa-leaf"></i>
                                                    </div>
                                                    <h6 class="card-title">Desarrollo sustentable y sostenible</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mapa -->
                                <div class="ratio ratio-21x9 mt-4">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3785.459910396478!2d-97.36702092407745!3d18.41741598265627!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85c5bc6511dcd087%3A0xbbc021e69ff7e690!2sComplejo%20Regional%20Sur%20BUAP!5e0!3m2!1ses-419!2smx!4v1736374328822!5m2!1ses-419!2smx"
                                        allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-foro7" role="tabpanel" aria-labelledby="pills-foro7-tab">
                        <div class="card">
                            <div class="card-body">
                                <!-- Título del foro -->
                                <h2 class="card-title text-center fw-bold titulo-foros">
                                    Foro Ciudadano de Consulta 7
                                </h2>

                                <!-- Datos principales -->
                                <p><strong>Fecha:</strong> 28 de enero de 2025</p>
                                <p><strong>Hora:</strong> 09:00 a 13:00 horas</p>
                                <p><strong>Ubicación:</strong> Complejo Cultural Universitario BUAP</p>

                                <!-- Temáticas -->
                                <div class="container mt-4">
                                    <h4 class="text-center my-3 text-white py-2"
                                        style="background-color: #920B32; border-radius: 8px; font-size: 1.4rem; font-weight: 600;">
                                        Temáticas de las mesas de trabajo
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fa-solid fa-child-reaching"></i>
                                                    </div>
                                                    <h6 class="card-title">Niñas, Niños y Adolescentes</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fa-solid fa-person-walking"></i>
                                                    </div>
                                                    <h6 class="card-title">Jóvenes y comunidad LGBTIQ+</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fa-solid fa-people-carry-box"></i>
                                                    </div>
                                                    <h6 class="card-title">Migrantes</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fa-solid fa-person-dress"></i>
                                                    </div>
                                                    <h6 class="card-title">Mujeres</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fa-brands fa-accessible-icon"></i>
                                                    </div>
                                                    <h6 class="card-title">Personas con discapacidad</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fa-solid fa-users-rays"></i>
                                                    </div>
                                                    <h6 class="card-title">Población indígena y afromexicana</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fa-solid fa-person-walking-with-cane"></i>
                                                    </div>
                                                    <h6 class="card-title">Personas adultas mayores</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card text-center border-0 shadow">
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <i class="fa-solid fa-building-user"></i>
                                                    </div>
                                                    <h6 class="card-title">Sector empresarial</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mapa -->
                                <div class="ratio ratio-21x9 mt-4">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3771.992905522103!2d-98.24265072406521!3d19.020034282172976!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cfc742407551ef%3A0x93dc3db3e62b8694!2sComplejo%20Cultural%20Universitario%20BUAP!5e0!3m2!1ses-419!2smx!4v1736374362648!5m2!1ses-419!2smx"
                                        allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="propuesta">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 header-text ht-2">
                    <h3>Propuestas<span> Ciudadanas</span></h3>
                </div>
            </div>
            <div class="container desc">
                <p class="my-5">
                    Identifica tu problemática y realiza una propuesta de solución.
                </p>
                <p class="my-5">
                    ¡Por Amor a Puebla!
                </p>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-center">
                <button class="btn btn-lg boton-encuesta-nocolor">
                    ¡Gracias por participar!
                </button>
            </div>
        </div>

    </section>

    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets-consulta/images/logofooter2.png') }}"
                            alt="Logo del gobierno en el footer" title="Gobierno del Estado de Puebla"
                            class="w-50">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="m-auto text-center">
                        <div class="footer-icon">
                            <a href="#"><i class="fa-brands fa-facebook"></i></a>
                            <a href="#"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa-brands fa-youtube" aria-hidden="true"></i></a>
                        </div>
                        <div class="footer-menu">
                            <a href="#acerca">Acerca de</a>
                            <a href="#encuesta">Encuesta</a>
                            <a href="#foros">Foros</a>
                            <a href="#propuesta">Propuesta</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <img src="{{ asset('assets-consulta/images/footer-2.svg') }}" alt="Textura del footer"
            title="Gobierno del Estado de Puebla" class="w-100">
    </footer>


    <!-- Optional JavaScript -->
    <script src="{{ asset('assets-consulta/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets-consulta/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets-consulta/js/custom.js') }}"></script>
</body>

</html>
