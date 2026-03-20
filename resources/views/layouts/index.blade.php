<!DOCTYPE html>
<html>

<head>
    {{-- <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'> --}}
    <!-- Favicon -->
    {{-- <link href="{{ asset('img/favicon.png') }}" rel="icon" /> --}}
    @yield('page_css')
    {{-- <script src="{{ asset('web/js/sienna.min.js') }}" defer></script> --}}

    <!-- Librerías de hojas de estilo de Owl Carousel -->
    {{-- <link rel="stylesheet" href="{{ asset('web/css/owl.carousel.css') }}"
        integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('web/css/owl.theme.default.min.css') }}"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

    <!-- Librerias de AOS -->
    {{-- <link href="{{ asset('web/css/aos.css') }}" rel="stylesheet" /> --}}

    <!-- Hojas de estilos de Bootstrap  -->
    {{-- <link href="{{ asset('web/css/bootstrap.min.css') }}" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" /> --}}

    {{-- <link href="{{ asset('web/css/bootstrap-icons.css') }}" rel="stylesheet" /> --}}

    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{ asset('web/css/all.min.css') }}" integrity="sha512-..................."
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <!-- Template CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('web/css/estilos.css') }}"> --}}

    @yield('page_css')

    @yield('css')
</head>

<body>

</body>


<!-- Template JS File -->

@yield('scripts')
{{-- <script src="{{ asset('web/js/bootstrap.bundle.min.js') }}"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>
<script src="{{ asset('web/js/jquery-3.4.1.min.js') }}"></script> --}}
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script> --}}
{{-- <script src="{{ asset('web/js/aos.js') }}"></script>
<script src="{{ asset('web/js/owl.carousel.min.js') }}"
    integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
{{-- <script>
    $(".owl-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        dots: true,
        center: true,
        loop: true,
        margin: 10,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
            },
            600: {
                items: 3,
                nav: false,
            },
            1000: {
                items: 3,
                nav: false,
                loop: true,
            },
        },
    });
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 1500, 'easeInOutExpo');
        return false;
    });
</script> --}}
{{-- <script>
    /* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>
<script>
    AOS.init();
</script> --}}
<script>
    $(document).ready(function () {
            // Inicializa el carrusel de Bootstrap
            $('#header-carousel').carousel();
        });
</script>
</html>
