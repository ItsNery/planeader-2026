<x-app-layout>
    @section('title', 'Fechas bloqueadas de agenda')

    @if ($message = Session::get('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({ icon: 'success', title: @json($message) });
            });
        </script>
    @endif

    <div class="container py-3">
        <div class="tarjeta-admin p-4 rounded-3 bg-white">
            <div class="form-header py-3 mb-4">
                <h2 class="fw-bold m-0">Fechas no disponibles</h2>
                <p class="text-white mb-0 small opacity-75">Evita que el público solicite una fecha por decisión administrativa.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>Revisa la información capturada.</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="alert alert-light border mb-4">
                <i class="fa-solid fa-circle-info me-1"></i>
                El bloqueo solo impide solicitudes públicas. El personal autorizado podrá seguir registrando eventos desde el panel.
            </div>

            <form action="{{ route('panel-eventos.fechas-bloqueadas-agenda.store') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="fecha_evento" class="form-label fw-bold">Fecha *</label>
                        <input type="date" id="fecha_evento" name="fecha_evento" min="{{ now()->format('Y-m-d') }}"
                            class="form-control @error('fecha_evento') is-invalid @enderror" value="{{ old('fecha_evento') }}" required>
                    </div>
                    <div class="col-md-5">
                        <label for="motivo" class="form-label fw-bold">Motivo interno</label>
                        <input type="text" id="motivo" name="motivo" maxlength="500" class="form-control"
                            value="{{ old('motivo') }}" placeholder="Ej. Evento institucional">
                    </div>
                    <div class="col-md-3 d-grid">
                        <button type="submit" class="btn btn-custom-primary"><i class="fa-solid fa-ban me-1"></i> Bloquear fecha</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="tarjeta-admin p-4 rounded-3 bg-white mt-4">
            <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                <div>
                    <h3 class="h4 mb-1">Fechas bloqueadas</h3>
                    <p class="text-muted mb-0">Al liberar una fecha, volverá a mostrarse según su capacidad y horarios disponibles.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('panel-eventos.capacidades-agenda.index') }}" class="btn btn-outline-secondary">Capacidad por fecha</a>
                    <a href="{{ route('panel-agenda-eventos.index') }}" class="btn btn-outline-secondary">Volver a agenda</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th>Fecha</th><th>Motivo</th><th class="text-center">Acción</th></tr></thead>
                    <tbody>
                        @forelse ($fechasBloqueadas as $fechaBloqueada)
                            <tr>
                                <td>{{ $fechaBloqueada->fecha_evento->locale('es')->translatedFormat('d \d\e F \d\e Y') }}</td>
                                <td>{{ $fechaBloqueada->motivo ?: 'Sin motivo registrado' }}</td>
                                <td class="text-center">
                                    <form action="{{ route('panel-eventos.fechas-bloqueadas-agenda.destroy', $fechaBloqueada) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Liberar esta fecha para solicitudes públicas?')">Liberar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-4">No hay fechas bloqueadas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
