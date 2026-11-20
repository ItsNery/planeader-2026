<x-app-layout>
    @section('title', $sesion->nombre)

    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3 px-3 d-flex flex-column flex-md-row justify-content-between gap-3">
            <div><h1 class="h2 mb-1">{{ $sesion->nombre }}</h1><p class="text-white mb-0">{{ $sesion->descripcion }}</p></div>
            <a href="{{ route('panel-copladep-sesiones.edit', $sesion) }}" class="btn btn-light align-self-md-center">Editar sesi√≥n</a>
        </div>
        <div class="p-3">
            @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-lg-3"><div class="border rounded p-3 h-100"><span class="text-muted d-block small">Invitados</span><strong class="fs-3">{{ $sesion->invitados_count }}</strong></div></div>
                <div class="col-sm-6 col-lg-3"><div class="border rounded p-3 h-100"><span class="text-muted d-block small">Registros</span><strong class="fs-3">{{ $sesion->registros_count }}</strong></div></div>
                <div class="col-sm-6 col-lg-3"><div class="border rounded p-3 h-100"><span class="text-muted d-block small">Presenciales / check-in</span><strong class="fs-3">{{ $metricas['presenciales'] }} / {{ $metricas['checkins'] }}</strong></div></div>
                <div class="col-sm-6 col-lg-3"><div class="border rounded p-3 h-100"><span class="text-muted d-block small">Virtuales / sin modalidad</span><strong class="fs-3">{{ $metricas['virtuales'] }} / {{ $metricas['sin_modalidad'] }}</strong></div></div>
            </div>
            <section class="mt-4 mb-4" aria-labelledby="documentos-title">
                <h2 class="h4" id="documentos-title">Documentos de referencia</h2>
                @if ($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                @endif
                <form method="POST" action="{{ route('panel-copladep-sesiones.documentos.store', $sesion) }}" enctype="multipart/form-data" class="row g-2 align-items-end mb-3">
                    @csrf
                    <div class="col-md-5"><label for="nombre-documento" class="form-label">Nombre del documento</label><input id="nombre-documento" name="nombre" class="form-control" value="{{ old('nombre') }}" maxlength="255" required></div>
                    <div class="col-md-5"><label for="archivo-documento" class="form-label">Archivo PDF (m·ximo 50 MB)</label><input id="archivo-documento" name="archivo" type="file" accept=".pdf,application/pdf" class="form-control" required></div>
                    <div class="col-md-2"><button class="btn btn-custom-primary" type="submit">Subir PDF</button></div>
                </form>
                @forelse ($sesion->documentosReferencia as $documento)
                    <div class="d-flex flex-wrap align-items-center gap-2 border-bottom py-2">
                        <a href="{{ route('copladep-sesiones.documentos.ver', [$sesion, $documento]) }}" target="_blank" rel="noopener">{{ $documento->nombre }}</a>
                        <span class="badge bg-danger">PDF</span>
                        <form method="POST" action="{{ route('panel-copladep-sesiones.documentos.destroy', [$sesion, $documento]) }}" class="ms-auto" onsubmit="return confirm('øEliminar este documento?')">
                            @csrf @method('DELETE') <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </div>
                @empty
                    <p class="text-muted">TodavÌa no hay documentos de referencia.</p>
                @endforelse
            </section>
            <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-custom-primary" href="{{ route('panel-copladep-sesiones.invitados.index', $sesion) }}">Invitados</a>
                <a class="btn btn-outline-secondary" href="{{ route('panel-copladep-sesiones.registros.index', $sesion) }}">Registros</a>
                <a class="btn btn-outline-secondary" href="{{ route('panel-copladep-sesiones.scanner', $sesion) }}">Check-in QR</a>
                <a class="btn btn-outline-secondary" href="{{ route('panel-copladep-sesiones.invitados.monitor', $sesion) }}">Monitor</a>
                <a class="btn btn-outline-secondary" href="{{ route('copladep-sesiones.registro.create', $sesion) }}" target="_blank" rel="noopener">Registro p√∫blico</a>
            </div>
        </div>
    </div>
</x-app-layout>
