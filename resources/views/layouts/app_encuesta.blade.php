<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta name="theme-color" content="#5f1b2d">
    <meta name="msapplication-TileColor" content="#5f1b2d">

    <title> Encuesta PED 2024-2030 | @yield('title') </title>

    <meta name="description" content="Este cuestionario tiene como objetivo conocer su opinión sobre diversos aspectos del estado de Puebla relacionados con sus problemas y su desarrollo para los próximos años. Su opinión es de gran importancia para construir un mejor futuro para Puebla. Sus respuestas serán confidenciales. ¡Gracias por participar!">
    <meta name="google-site-verification" content="SqonXYfmVQHShjVZynKkL9mNRhYQfCm97J8zW2fYiyc" />
    <link rel="canonical" href="{{ url('') }}">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="Este cuestionario tiene como objetivo conocer su opinión sobre diversos aspectos del estado de Puebla relacionados con sus problemas y su desarrollo para los próximos años. Su opinión es de gran importancia para construir un mejor futuro para Puebla. Sus respuestas serán confidenciales. ¡Gracias por participar!">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('') }}">
    <meta property="og:image" content="{{ asset('img/portada-consulta.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title')">
    <meta name="twitter:description" content="Este cuestionario tiene como objetivo conocer su opinión sobre diversos aspectos del estado de Puebla relacionados con sus problemas y su desarrollo para los próximos años. Su opinión es de gran importancia para construir un mejor futuro para Puebla. Sus respuestas serán confidenciales. ¡Gracias por participar!">
    <meta name="twitter:image" content="{{ asset('img/portada-consulta.png') }}">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Carlos Emmanuel Méndez Calderón">
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/escudo-armas.svg') }}">
    <link rel="favicon" href="{{ asset('img/escudo-armas.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/escudo-armas.svg') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles_encuesta.css') }}?v={{ rand() }}" />
    @yield('css')

    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    {!! NoCaptcha::renderJs() !!}
</head>

<body>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZCCNT2GY0F"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-ZCCNT2GY0F');
    </script>
    @if ($message = Session::get('success_encuesta'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ $message }}',
            html: `
                    <p>Todas las respuestas serán tratadas de manera confidencial de uso exclusivo para el proyecto.</p>
                    <small class="fs-6">Este ejercicio es ajeno a cualquier partido político. Queda prohibido el uso para fines distintos a los establecidos.</small>
                `,
        }).then((result) => {
            window.location.href = '/consultaciudadana2025';
        });
    </script>
    @endif

    <main>
        @yield('content')
    </main>

    <script src="{{ asset('js/scripts_encuesta.js') }}?v={{ rand() }}"></script>
    @yield('js')

</body>

</html>