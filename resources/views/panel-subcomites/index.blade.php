<x-app-layout>
    @section('title', 'Subcomités: Inicio')
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
            <h2>Subcomités</h2>
            <p class="text-white">
                Aquí puedes ver los subcomités relacionados a algún
                <a href="{{ route('panel-planes-estatales.index') }}" class="text-white">
                    Plan
                    Estatal de Desarrollo
                </a>.
                <br>
                <strong>
                    Para crear uno nuevo, pulsa el botón de Crear subcomité situado debajo de esta tarjeta.
                </strong>
            </p>
        </div>
        <div class="container d-flex justify-content-end">
            <a href="{{ route('panel-subcomites.create') }}" class="text-decoration-none">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                    Crear subcomité
                </button>
            </a>
        </div>
        <div class="container table-responsive">
            <table id="myTable" class="table w-100 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Información del subcomité</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($subcomites)
                        @foreach ($subcomites as $subcomite)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('icono_subcomites/' . $subcomite->icono) }}"
                                            class="img-thumbnail mx-2 imagen-lista">
                                        <div>
                                            <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                                {{ $subcomite->nombre }}
                                            </div>
                                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                                <span class="badge bg-light text-dark border">
                                                    {{ $subcomite->tipo_subcomite }}
                                                </span>
                                                <span
                                                    class="badge rounded-pill bg-primary-subtle text-primary border border-primary-integration">
                                                    <i
                                                        class="fa-solid fa-file-lines me-1"></i>{{ $subcomite->planestatal->nombre }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center" style="width: 150px;">
                                    @if (Auth::user()->validador)
                                        <form action="{{ route('update-publicado-subcomite', $subcomite->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="publicado" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                <option value="1" {{ $subcomite->publicado ? 'selected' : '' }}>
                                                    Publicado
                                                </option>
                                                <option value="0" {{ !$subcomite->publicado ? 'selected' : '' }}>
                                                    Borrador
                                                </option>
                                            </select>
                                        </form>
                                    @else
                                        {{ $subcomite->publicado ? 'Sí' : 'No' }}
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            @if ($subcomite->publicado == 1)
                                                @if (Auth::user()->validador)
                                                    <a href="{{ route('panel-subcomites.edit', $subcomite->id) }}"
                                                        class="text-decoration-none">
                                                        <button class="btn btn-outline-secondary"
                                                            title="Editar elemento">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </button>
                                                    </a>
                                                @else
                                                    <span>
                                                        <i class="fa-solid fa-ban"></i>
                                                    </span>
                                                @endif
                                            @else
                                                <a href="{{ route('panel-subcomites.edit', $subcomite->id) }}"
                                                    class="text-decoration-none">
                                                    <button class="btn btn-outline-secondary" title="Editar elemento">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                </a>
                                            @endif
                                            @if (Auth::user()->validador)
                                                <form action="{{ route('panel-subcomites.destroy', $subcomite->id) }}"
                                                    method="POST" class="formEliminar ms-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th>Información del subcomité</th>
                        <th>Conformacion</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-app-layout>
<script>
    function mostrarImagenGrande(subcomiteId) {
        // Mostrar el contenedor de la imagen grande
        var imagenGrande = document.getElementById('imagen-' + subcomiteId);
        imagenGrande.style.display = 'block';

        // Deshabilitar el desplazamiento de la página
        document.body.style.overflow = 'hidden';

        // Agregar un evento de clic para cerrar la imagen grande
        imagenGrande.addEventListener('click', function() {
            imagenGrande.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
    }
</script>
