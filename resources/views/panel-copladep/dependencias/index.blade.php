<x-app-layout>
    @section('title', 'Dependencias invitadas COPLADEP')

    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3 px-3">
            <h1 class="h2 mb-1">Dependencias invitadas</h1>
            <p class="text-white mb-0">Catálogo reutilizable para las invitaciones de todas las sesiones COPLADEP.</p>
        </div>
        <div class="p-3">
            @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if ($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
            <form action="{{ route('panel-copladep-dependencias.store') }}" method="POST" class="row g-2 align-items-end mb-4">
                @csrf
                <div class="col-md-7"><label class="form-label">Nombre</label><input class="form-control" name="nombre" required></div>
                <div class="col-md-3"><label class="form-label">Siglas</label><input class="form-control" name="siglas"></div>
                <div class="col-md-2"><button class="btn btn-custom-primary w-100">Agregar</button></div>
            </form>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead><tr><th>Dependencia</th><th>Siglas</th><th>Invitados históricos</th><th>Estatus</th><th class="text-end">Acciones</th></tr></thead>
                    <tbody>
                        @forelse ($dependencias as $dependencia)
                            <tr>
                                <td>{{ $dependencia->nombre }}</td><td>{{ $dependencia->siglas ?: '—' }}</td><td>{{ $dependencia->invitados_count }}</td><td><span class="badge {{ $dependencia->activo ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $dependencia->activo ? 'Activa' : 'Inactiva' }}</span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editar-{{ $dependencia->id }}">Editar</button>
                                    @if (! $dependencia->invitados_count)<form class="d-inline" method="POST" action="{{ route('panel-copladep-dependencias.destroy', $dependencia) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar dependencia?')">Eliminar</button></form>@endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-muted text-center py-4">No hay dependencias registradas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @foreach ($dependencias as $dependencia)
                <div class="modal fade" id="editar-{{ $dependencia->id }}" tabindex="-1">
                    <div class="modal-dialog"><form method="POST" action="{{ route('panel-copladep-dependencias.update', $dependencia) }}" class="modal-content">@csrf @method('PUT')
                        <div class="modal-header"><h2 class="h5 modal-title">Editar dependencia</h2><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body"><label class="form-label">Nombre</label><input class="form-control mb-3" name="nombre" value="{{ $dependencia->nombre }}" required><label class="form-label">Siglas</label><input class="form-control mb-3" name="siglas" value="{{ $dependencia->siglas }}"><div class="form-check"><input class="form-check-input" type="checkbox" name="activo" value="1" id="activo-{{ $dependencia->id }}" @checked($dependencia->activo)><label class="form-check-label" for="activo-{{ $dependencia->id }}">Activa</label></div></div>
                        <div class="modal-footer"><button class="btn btn-custom-primary">Guardar</button></div>
                    </form></div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
