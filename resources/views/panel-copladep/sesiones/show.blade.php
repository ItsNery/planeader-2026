<x-app-layout>
    @section('title', $sesion->nombre)

    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3 px-3 d-flex flex-column flex-md-row justify-content-between gap-3">
            <div><h1 class="h2 mb-1">{{ $sesion->nombre }}</h1><p class="text-white mb-0">{{ $sesion->descripcion }}</p></div>
            <a href="{{ route('panel-copladep-sesiones.edit', $sesion) }}" class="btn btn-light align-self-md-center">Editar sesión</a>
        </div>
        <div class="p-3">
            @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-lg-3"><div class="border rounded p-3 h-100"><span class="text-muted d-block small">Invitados</span><strong class="fs-3">{{ $sesion->invitados_count }}</strong></div></div>
                <div class="col-sm-6 col-lg-3"><div class="border rounded p-3 h-100"><span class="text-muted d-block small">Registros</span><strong class="fs-3">{{ $sesion->registros_count }}</strong></div></div>
                <div class="col-sm-6 col-lg-3"><div class="border rounded p-3 h-100"><span class="text-muted d-block small">Presenciales / check-in</span><strong class="fs-3">{{ $metricas['presenciales'] }} / {{ $metricas['checkins'] }}</strong></div></div>
                <div class="col-sm-6 col-lg-3"><div class="border rounded p-3 h-100"><span class="text-muted d-block small">Virtuales / sin modalidad</span><strong class="fs-3">{{ $metricas['virtuales'] }} / {{ $metricas['sin_modalidad'] }}</strong></div></div>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-custom-primary" href="{{ route('panel-copladep-sesiones.invitados.index', $sesion) }}">Invitados</a>
                <a class="btn btn-outline-secondary" href="{{ route('panel-copladep-sesiones.registros.index', $sesion) }}">Registros</a>
                <a class="btn btn-outline-secondary" href="{{ route('panel-copladep-sesiones.scanner', $sesion) }}">Check-in QR</a>
                <a class="btn btn-outline-secondary" href="{{ route('panel-copladep-sesiones.invitados.monitor', $sesion) }}">Monitor</a>
                <a class="btn btn-outline-secondary" href="{{ route('copladep-sesiones.registro.create', $sesion) }}" target="_blank" rel="noopener">Registro público</a>
            </div>
        </div>
    </div>
</x-app-layout>
