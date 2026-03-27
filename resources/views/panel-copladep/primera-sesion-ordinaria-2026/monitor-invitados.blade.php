<x-app-layout>
    @section('title', 'Registro de asistencia de sesión ordinaria de COPLADEP: Monitor')

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.bootstrap5.min.css">
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @endpush
    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3">
            <h2>Listado de invitados registrados</h2>
            <p class="text-white">
                Aquí ver las personas que han llegado para la
                <a href="{{ url('/copladep/primera-sesion-ordinaria') }}" class="text-white">primera sesión ordinaria
                    2026</a>.
            </p>
            <strong>
                Para registrar un nuevo invitado, pulsa el botón de Nuevo invitado situado debajo de esta tarjeta.
            </strong>
        </div>

        <div class="container d-flex justify-content-end">
            
            <a href="{{ route('copladep-registro.index') }}" class="">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                    Volver al listado
                </button>
            </a>
            <a href="{{ route('copladep-registro.create') }}" class="mx-2">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                    Nuevo registro
                </button>
            </a>
        </div>
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-3 border-bottom pb-2">
                <div>
                    <h4 class="fw-bold mb-0">Estatus de Ocupación</h4>
                    <small class="text-danger"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>En
                        vivo</small>
                </div>
                <div class="d-flex gap-2 text-center">
                    <div class="bg-light px-3 py-1 border rounded">
                        <span class="d-block text-muted"
                            style="font-size: 0.6rem; text-transform: uppercase;">Esperados</span>
                        <strong class="fs-5">{{ $total }}</strong>
                    </div>
                    <div class="bg-success text-white px-3 py-1 border border-success rounded shadow-sm">
                        <span class="d-block text-white-50" style="font-size: 0.6rem; text-transform: uppercase;">En
                            Sala</span>
                        <strong class="fs-5">{{ $asistencias }}</strong>
                    </div>
                    <div class="bg-white px-3 py-1 border rounded">
                        <span class="d-block text-muted"
                            style="font-size: 0.6rem; text-transform: uppercase;">Faltan</span>
                        <strong class="fs-5 text-secondary">{{ $faltantes }}</strong>
                    </div>
                </div>
            </div>

            <div class="grid-asientos">
                @foreach($invitados as $invitado)
                    @php
                        $yaLlego = $invitado->check_in_express;
                        $claseAsiento = $yaLlego ? 'llegado shadow' : 'faltante shadow-sm';

                        $partesNombre = explode(' ', trim($invitado->nombre_completo));
                        $nombreCorto = count($partesNombre) >= 2
                            ? $partesNombre[0] . ' ' . $partesNombre[1]
                            : $invitado->nombre_completo;

                        $nombreMunicipio = $invitado->municipio->nombre_municipio ?? 'N/A';
                        $tooltipText = "{$invitado->nombre_completo} | Cargo: {$invitado->cargo} | Municipio: {$nombreMunicipio}";
                    @endphp

                    <div class="asiento {{ $claseAsiento }}" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="{{ $tooltipText }}">
                        <div class="nombre-truncado">
                            {{ $nombreCorto }}
                        </div>

                        @if($yaLlego)
                            <i class="bi bi-check-circle-fill mb-1" style="font-size: 0.85rem;"></i>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });

                setTimeout(function () {
                    window.location.reload();
                }, 5000);
            });
        </script>
    @endpush
</x-app-layout>