<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Administración: Portal de Planeación para el Desarrollo</title>

    <!-- Fonts -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.3/datatables.min.css" rel="stylesheet">
    <!-- <script src="https://kit.fontawesome.com/30136daf60.js" crossorigin="anonymous" defer></script> -->
    <script src="{{ asset('js/fontAwesome.js') }}"></script>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos_admin.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
</head>

<body class="font-sans antialiased bg-light">
    @livewire('navigation-menu')

    <main class="container my-5">
        {{ $slot }}
    </main>

    @stack('modals')

    @livewireScripts
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.3/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Inicialización de DataTable
            const tableElement = document.querySelector('#myTable');
            if (tableElement) {
                new DataTable(tableElement, {
                    pagingType: "simple_numbers",
                    order: [],
                    language: {
                        search: "Buscar:",
                        lengthMenu: "Mostrar _MENU_ entradas",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                        paginate: {
                            previous: "Anterior",
                            next: "Siguiente"
                        }
                    }
                });
            }

            // 2. Manejo Global de Eliminación (Delegación de eventos)
            document.addEventListener('submit', (event) => {
                // Buscamos si el formulario tiene la clase 'formEliminar'
                const form = event.target.closest('.formEliminar');

                if (form) {
                    event.preventDefault(); // Detenemos el envío inicial

                    Swal.fire({
                        title: '¿Confirmar eliminación?',
                        text: "Esta acción no se puede deshacer.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fa-regular fa-trash-can me-2"></i>Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: false // Pone el botón de cancelar a la izquierda
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Si el usuario confirma, enviamos el formulario programáticamente
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>