<x-app-layout>
    @section('title', 'Eventos: Inicio')
    @if ($message = Session::get('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '{{ $message }}'
                });
            });
        </script>
    @endif
    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3">
            <h2>Eventos</h2>
            <p class="text-white mb-0">
                Aquí puedes ver y gestionar los eventos del calendario de planeación.
                <br>
                <strong>
                    Para registrar uno nuevo, pulsa el botón de Crear evento situado debajo de esta tarjeta.
                </strong>
            </p>
        </div>

        @if (Auth::user()->validador)
            <div class="container d-flex justify-content-end">
                <a href="{{ route('panel-eventos.create') }}" class="text-decoration-none">
                    <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                        Crear evento
                    </button>
                </a>
            </div>
        @endif

        <div class="container table-responsive">
            <table id="myTable" class="table w-100 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Título</th>
                        <th class="text-center">Ícono</th>
                        <th>Fecha del Evento</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($eventos as $evento)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark" style="font-size: 1.05rem;">
                                    {{ $evento->titulo }}
                                </div>
                            </td>
                            <td class="text-center">
                                @if ($evento->icono_evento)
                                    <img src="{{ asset('imagen-eventos/' . $evento->icono_evento) }}"
                                        alt="Ícono de {{ $evento->titulo }}" class="img-thumbnail imagen-lista" style="max-height: 50px;">
                                @else
                                    <span class="text-muted">Sin ícono</span>
                                @endif
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($evento->fecha_evento)->locale('es')->translatedFormat('d \d\e F \d\e Y') }}
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if (Auth::user()->validador)
                                            <a href="{{ route('panel-eventos.edit', $evento->id) }}"
                                                class="text-decoration-none">
                                                <button class="btn btn-outline-secondary" title="Editar elemento">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                            </a>
                                            <form action="{{ route('panel-eventos.destroy', $evento->id) }}"
                                                method="POST" class="formEliminar ms-1 d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"
                                                    title="Eliminar elemento">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-light text-muted">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No hay eventos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th>Título</th>
                        <th class="text-center">Ícono</th>
                        <th>Fecha del Evento</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-app-layout>
