<x-app-layout>
    @section('title', 'Capacitaciones municipales: Inicio')
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
            <h2>Capacitaciones municipales</h2>
            <p class="text-white">
                Aquí puedes ver los documentos que van en la sección de
                <a href="{{ url('/capacitacion-municipal') }}" class="text-white">
                    Capacitaciones municipales</a>.
                <br>
                <strong>
                    Para subir una nueva, pulsa el botón de Subir capacitación situado debajo de esta tarjeta.
                </strong>
            </p>
        </div>
        <div class="container d-flex justify-content-end">
            <a href="{{ route('capacitaciones.create') }}" class="text-decoration-none">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                    Subir capacitación
                </button>
            </a>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container table-responsive">
            <table id="myTable" class="table w-100 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Información de la capacitación</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($capacitaciones as $capacitacion)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{ $capacitacion->id }}
                                    <img src="{{ asset('documentos/capacitacion-municipal/' . $capacitacion->imagen_programa) }}"
                                        class="img-thumbnail mx-2 imagen-lista">
                                    <div>
                                        <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                            {{ $capacitacion->nombre }}
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <span class="badge bg-light text-dark border">
                                                {{ count($capacitacion->documentos) }} Documentos
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center" style="width: 150px;">
                                @if (Auth::user()->validador)
                                    <form action="{{ route('update-publicado-capacitacion', $capacitacion->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="publicado" class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                            <option value="1" {{ $capacitacion->publicado ? 'selected' : '' }}>
                                                Publicado
                                            </option>
                                            <option value="0" {{ !$capacitacion->publicado ? 'selected' : '' }}>
                                                Borrador
                                            </option>
                                        </select>
                                    </form>
                                @else
                                    {{ $capacitacion->publicado ? 'Sí' : 'No' }}
                                @endif
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($capacitacion->publicado == 1)
                                            @if (Auth::user()->validador)
                                                <a href="{{ route('capacitaciones.edit', $capacitacion) }}"
                                                    class="text-decoration-none">
                                                    <button class="btn btn-outline-secondary" title="Editar elemento">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                </a>
                                            @else
                                                <span><i class="fa-solid fa-ban"></i></span>
                                            @endif
                                        @else
                                            <a href="{{ route('capacitaciones.edit', $capacitacion) }}"
                                                class="text-decoration-none">
                                                <button class="btn btn-outline-secondary" title="Editar elemento">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                            </a>
                                        @endif
                                        @if (Auth::user()->validador)
                                            <form action="{{ route('capacitaciones.destroy', $capacitacion) }}"
                                                method="POST" class="formEliminar ms-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"
                                                    title="Eliminar elemento">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay capacitaciones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
