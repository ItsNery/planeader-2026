<x-app-layout>
    @section('title', 'Sesiones COPLADEP')

    <div class="tarjeta-admin overflow-hidden">
        <div class="form-header px-4 py-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h1 class="h2 mb-2">Sesiones COPLADEP</h1>
                <p class="mb-0 text-white">Administre las sesiones, invitados, registros y asistencia desde un solo módulo.</p>
            </div>
            <a href="{{ route('panel-copladep-sesiones.create') }}" class="btn btn-light">Nueva sesión</a>
        </div>

        <div class="p-3 p-md-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="list-group list-group-flush border-top border-bottom">
                @forelse ($sesiones as $sesion)
                    <div class="list-group-item px-0 py-4">
                        <div class="row align-items-center g-3">
                            <div class="col-lg-7">
                                <div class="d-flex align-items-start gap-3">
                                    <span class="rounded-circle bg-light text-primary border d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 2.75rem; height: 2.75rem;" aria-hidden="true">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </span>
                                    <div>
                                        <h2 class="h4 mb-1">{{ $sesion->nombre }}</h2>
                                        <p class="mb-2 text-muted">{{ $sesion->descripcion ?: ucfirst($sesion->tipo) . ' ' . $sesion->anio }}</p>
                                        <span class="badge text-bg-secondary">{{ ucfirst($sesion->estado) }}</span>
                                        <span class="small text-muted ms-2">{{ $sesion->invitados_count }} invitados · {{ $sesion->registros_count }} registros</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="d-flex flex-column flex-sm-row justify-content-lg-end gap-2">
                                    <a href="{{ route('panel-copladep-sesiones.show', $sesion) }}" class="btn btn-custom-primary">Ver detalle</a>
                                    <a href="{{ route('panel-copladep-sesiones.registros.index', $sesion) }}" class="btn btn-outline-secondary">Registros</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="list-group-item py-4 text-muted">No hay sesiones registradas.</div>
                @endforelse
            </div>
            <div class="mt-4">
                <a href="{{ route('panel-copladep-dependencias.index') }}" class="btn btn-outline-secondary">Catálogo de dependencias</a>
            </div>
        </div>
    </div>
</x-app-layout>
