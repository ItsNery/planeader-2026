<x-app-layout>
    @section('title', 'Herramientas de Planeación: Inicio')
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
            <h2>Herramientas de Planeación</h2>
            <p class="text-white">
                Aquí puedes ver los documentos que van en la sección de
                <a href="{{ url('/herramientas-planeacion') }}" class="text-white">
                    Herramientas de Planeación</a>.
                <br>
                <strong>
                    Para subir una nueva, pulsa el botón de Subir herramienta situado debajo de esta tarjeta.
                </strong>
            </p>
        </div>
        <div class="container d-flex justify-content-end flex-wrap gap-2">
            @can('editar-herramienta')
                <a href="{{ route('panel-herramientas.orden') }}" class="btn btn-outline-secondary mt-3 mb-3">
                    <i class="fa-solid fa-arrow-down-up-across-line me-1"></i>Reordenar herramientas
                </a>
            @endcan
            @can('crear-herramienta')
                <a href="{{ route('panel-herramientas.create') }}" class="btn btn-custom-primary mt-3 mb-3">
                    <i class="fa-solid fa-upload me-1"></i>Subir herramienta
                </a>
            @endcan
        </div>
        <div class="container table-responsive">
            <table id="myTable" class="table w-100 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Información del documento</th>
                        <th>Documento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($herramientas as $herramienta)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{ $herramienta->orden }}
                                    <img src="{{ asset('imagen/herramientas/' . $herramienta->imagen) }}"
                                        class="img-thumbnail mx-2 imagen-lista">
                                    <div>
                                        <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                            {{ $herramienta->titulo }}
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <span class="badge bg-light text-dark border">
                                                {{ $herramienta->anexos_count }} Anexos
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ asset('documentos/herramientas/' . $herramienta->archivo) }}"
                                    target="_blank" title="Ver documento {{ $herramienta->titulo }}">
                                    <i class="fa-solid fa-file-pdf fs-2"></i>
                                </a>
                            </td>
                            <td class="text-center" style="width: 150px;">
                                @if (Auth::user()->validador)
                                    <form
                                        action="{{ route('update-publicado-herramienta-planeacion', $herramienta->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="publicado" class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                            <option value="1" {{ $herramienta->publicado ? 'selected' : '' }}>
                                                Publicado
                                            </option>
                                            <option value="0" {{ !$herramienta->publicado ? 'selected' : '' }}>
                                                Borrador
                                            </option>
                                        </select>
                                    </form>
                                @else
                                    {{ $herramienta->publicado ? 'Sí' : 'No' }}
                                @endif
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($herramienta->publicado == 1)
                                            @if (Auth::user()->validador)
                                                <a href="{{ route('panel-herramientas.edit', $herramienta->id) }}"
                                                    class="text-decoration-none">
                                                    <button class="btn btn-outline-secondary" title="Editar elemento">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                </a>
                                            @else
                                                <span><i class="fa-solid fa-ban"></i></span>
                                            @endif
                                        @else
                                            <a href="{{ route('panel-herramientas.edit', $herramienta->id) }}"
                                                class="text-decoration-none">
                                                <button class="btn btn-outline-secondary" title="Editar elemento">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                            </a>
                                        @endif
                                        @if (Auth::user()->validador)
                                            <form action="{{ route('panel-herramientas.destroy', $herramienta->id) }}"
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
                                <div class="flex justify-center rounded-lg text-lg" role="group">


                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
