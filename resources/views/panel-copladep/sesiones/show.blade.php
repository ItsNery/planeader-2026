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
            <section class="sesion-documentos" aria-labelledby="documentos-title">
                <div class="sesion-documentos__header">
                    <div><h2 id="documentos-title">Documentos de referencia</h2><p>Comparte los documentos PDF disponibles para esta sesión.</p></div>
                    <span class="sesion-documentos__count">{{ $sesion->documentosReferencia->count() }} {{ $sesion->documentosReferencia->count() === 1 ? 'documento' : 'documentos' }}</span>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                @endif
                <form method="POST" action="{{ route('panel-copladep-sesiones.documentos.store', $sesion) }}" enctype="multipart/form-data" class="sesion-documentos__upload">
                    @csrf
                    <div class="sesion-documentos__field"><label for="nombre-documento" class="form-label">Nombre del documento</label><input id="nombre-documento" name="nombre" class="form-control" value="{{ old('nombre') }}" maxlength="255" placeholder="Ej. Presentación de la sesión" required></div>
                    <div class="sesion-documentos__field"><label for="archivo-documento" class="form-label">Archivo PDF</label>
                        <input id="archivo-documento" name="archivo" type="file" accept=".pdf,application/pdf" class="form-control sesion-documentos__file" aria-describedby="archivo-ayuda" required>
                        <small id="archivo-ayuda">Selecciona un PDF de hasta 50 MB.</small>
                    </div>
                    <button class="btn btn-custom-primary sesion-documentos__submit" type="submit"><i class="fa-solid fa-upload me-2" aria-hidden="true"></i>Subir documento</button>
                </form>
                <div class="sesion-documentos__list">
                    @forelse ($sesion->documentosReferencia as $documento)
                        <div class="sesion-documentos__item">
                            <span class="sesion-documentos__icon" aria-hidden="true"><i class="fa-regular fa-file-pdf"></i></span>
                            <div class="sesion-documentos__name"><a href="{{ route('copladep-sesiones.documentos.ver', [$sesion, $documento]) }}" target="_blank" rel="noopener">{{ $documento->nombre }}</a><span>PDF</span></div>
                            <form method="POST" action="{{ route('panel-copladep-sesiones.documentos.destroy', [$sesion, $documento]) }}" class="formEliminar">
                                @csrf @method('DELETE') <button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Eliminar {{ $documento->nombre }}"><i class="fa-regular fa-trash-can me-1" aria-hidden="true"></i> Eliminar</button>
                            </form>
                        </div>
                    @empty
                        <div class="sesion-documentos__empty"><i class="fa-regular fa-folder-open" aria-hidden="true"></i><p>Todavía no hay documentos de referencia.</p><span>Los documentos que subas aparecerán aquí.</span></div>
                    @endforelse
                </div>
            </section>
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
