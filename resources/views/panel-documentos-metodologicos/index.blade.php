<x-app-layout>
    @section('title', 'Documentos Metodológicos')
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
            <h2>Documentos Metodológicos</h2>
            <p class="text-white">
                Aquí puedes ver los documentos que van en la sección de
                <a href="{{ url('/documentos-metodologicos') }}" class="text-white">
                    Metodológicos
                </a> tales como guías.
            </p>
            <strong>
                Para subir uno nuevo, pulsa el botón de Subir documento situado debajo de esta tarjeta.
            </strong>
        </div>
        <div class="container d-flex justify-content-end">
            <a href="{{ route('panel-documentos-metodologicos.create') }}" class="btn btn-custom-primary mt-3 mb-3 ml-3">
                <i class="fas fa-plus"></i> Subir Documento
            </a>
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
                    @foreach ($documentos as $doc)
                        <tr>
                            <td class="d-flex flex-row flex-start">
                                <span>
                                    {{ $doc->orden }}
                                </span>
                                @if ($doc->imagen)
                                    <img src="{{ asset('imagen/metodologicos/' . $doc->imagen) }}"
                                        class="img-thumbnail mx-2 imagen-lista">
                                @else
                                    <span class="text-muted">Sin imagen</span>
                                @endif
                                <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                    {{ $doc->titulo }}
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ asset('documentos/metodologicos/' . $doc->ruta_documento) }}"
                                    target="_blank" title="Ver documento {{ $doc->titulo }}">
                                    <i class="fa-solid fa-file-pdf fs-2"></i>
                                </a>
                            </td>
                            <td class="text-center" style="width: 150px;">
                                @if (Auth::user()->validador)
                                    <form action="{{ route('update-publicado-documentos-metodologicos', $doc->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="publicado" class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                            <option value="1" {{ $doc->publicado ? 'selected' : '' }}>
                                                Publicado
                                            </option>
                                            <option value="0" {{ !$doc->publicado ? 'selected' : '' }}>
                                                Borrador
                                            </option>
                                        </select>
                                    </form>
                                @else
                                    <span class="badge {{ $doc->publicado ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $doc->publicado ? 'Publicado' : 'Borrador' }}
                                    </span>
                                @endif

                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($doc->publicado == 1)
                                            @if (Auth::user()->validador)
                                                <a href="{{ route('panel-documentos-metodologicos.edit', $doc->id) }}"
                                                    class="btn btn-outline-secondary" title="Editar elemento">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                            @else
                                                <span>
                                                    <i class="fa-solid fa-ban"></i>
                                                </span>
                                            @endif
                                        @else
                                            <a href="{{ route('panel-documentos-metodologicos.edit', $doc->id) }}"
                                                class="btn btn-outline-secondary" title="Editar elemento">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                        @endif
                                        @if (Auth::user()->validador)
                                            <div>
                                                <form
                                                    action="{{ route('panel-documentos-metodologicos.destroy', $doc->id) }}"
                                                    method="POST" class="formEliminar ms-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger"
                                                        title="Eliminar elemento">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejar eliminación con SweetAlert
            document.addEventListener('click', function(e) {
                if (e.target && e.target.closest('.formEliminar')) {
                    const form = e.target.closest('.formEliminar');
                    if (e.target.type === 'submit') {
                        e.preventDefault();
                        Swal.fire({
                            title: '¿Confirma la eliminación del registro?',
                            text: "Esta acción no se puede deshacer",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    }
                }
            });
        });
    </script>
</x-app-layout>
