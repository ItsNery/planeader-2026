<x-app-layout>
    @section('title', 'Programas Estatales: Inicio')
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
        <div class="form-header py-3 px-3">
            <h2>Programas Estatales</h2>
            <p class="text-white">
                Aquí puedes ver los programas estatales que se muestran en la sección pública de
                <a href="{{ url('programas-estatales') }}" class="text-white">
                    Programas Estatales
                </a>.
                <br>
                <strong>
                    Para crear uno nuevo de manera individual, pulsa el botón de Crear programa situado debajo de esta
                    tarjeta.
                </strong>
            </p>
        </div>
        <div class="container d-flex justify-content-end">
            <a href="{{ route('panel-programas-estatales.create') }}" class="text-decoration-none">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3 ms-1">
                    Crear programa
                </button>
            </a>
        </div>
        <div class="container table-responsive">
            <table id="myTable" class="table w-100 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Información del programa</th>
                        <th>Documento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($programas)
                        @foreach ($programas as $programaEstatal)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('img/portadas-programas-estatales/' . $programaEstatal->portada) }}"
                                            class="img-thumbnail mx-2 imagen-lista">
                                        <div>
                                            <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                                {{ $programaEstatal->nombre }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ asset('programasEstatales/' . $programaEstatal->ruta_documento) }}"
                                        target="_blank" title="Ver documento {{ $programaEstatal->nombre }}">
                                        <i class="fa-solid fa-file-pdf fs-2"></i>
                                    </a>
                                </td>
                                <td class="text-center" style="width: 150px;">
                                    @if (Auth::user()->validador)
                                        <form
                                            action="{{ route('update-publicado-programa-estatal', $programaEstatal->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="publicado" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                <option value="1"
                                                    {{ $programaEstatal->publicado ? 'selected' : '' }}>
                                                    Publicado
                                                </option>
                                                <option value="0"
                                                    {{ !$programaEstatal->publicado ? 'selected' : '' }}>
                                                    Borrador
                                                </option>
                                            </select>
                                        </form>
                                    @else
                                        <!-- Mostrar texto estático si el usuario no es validador -->
                                        {{ $programaEstatal->publicado ? 'Sí' : 'No' }}
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            @if ($programaEstatal->publicado == 1)
                                                @if (Auth::user()->validador)
                                                    <a href="{{ route('panel-programas-estatales.edit', $programaEstatal->id) }}"
                                                        class="">
                                                        <button class="btn btn-outline-secondary"
                                                            title="Editar elemento">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </button>
                                                    </a>
                                                @else
                                                    <span>No disponible</span>
                                                @endif
                                            @else
                                                <a href="{{ route('panel-programas-estatales.edit', $programaEstatal->id) }}"
                                                    class="">
                                                    <button class="btn btn-outline-secondary" title="Editar elemento">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                </a>
                                            @endif
                                            @if (Auth::user()->validador)
                                                <form
                                                    action="{{ route('panel-programas-estatales.destroy', $programaEstatal->id) }}"
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
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-app-layout>
