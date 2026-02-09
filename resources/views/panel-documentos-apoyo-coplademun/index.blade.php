<x-app-layout>
    @section('title', 'Documentos de Apoyo COPLADEMUN')

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
            <h2>Documentos de Apoyo del COPLADEMUN</h2>
            <p class="text-white">
                Aquí puedes ver los documentos de apoyo al
                <a href="{{ url('/coplademun') }}" class="text-white">
                    COPLADEMUN
                </a> tales como plantillas de actas.
            </p>
            <strong>
                Para subir uno nuevo, pulsa el botón de Subir documento situado debajo de esta tarjeta.
            </strong>
        </div>
        <div class="container d-flex justify-content-end">
            <a href="{{ route('panel-documentos-apoyo-coplademun.create') }}"
                class="btn btn-custom-primary mt-3 mb-3 ml-3">
                <i class="fas fa-plus"></i> Subir documento
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
                            <td class="d-flex justify-contente-center flex-row">
                                <img src="{{ asset('imagen/apoyo-coplademun/' . $doc->imagen) }}"
                                    class="img-thumbnail mx-2 imagen-lista">
                                <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                    {{ $doc->titulo }}
                                </div>
                            </td>

                            <td class="text-center">
                                <a href="{{ asset('documentos/apoyo-coplademun/' . $doc->ruta_documento) }}"
                                    target="_blank" title="Ver documento {{ $doc->titulo }}">
                                    <i class="fa-solid fa-file-pdf fs-2"></i>
                                </a>
                            </td>
                            <td class="text-center" style="width: 150px;">
                                @if (Auth::user()->validador)
                                    <form action="{{ route('update-publicado-documentos-apoyo-coplademun', $doc->id) }}"
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
                                    <span class="badge {{ $doc->publicado ? 'bg-success' : 'bg-warning' }}">
                                        {{ $doc->publicado ? 'Publicado' : 'Borrador' }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($doc->publicado == 1)
                                            @if (Auth::user()->validador)
                                                <a href="{{ route('panel-documentos-apoyo-coplademun.edit', $doc->id) }}"
                                                    class="btn btn-outline-secondary" title="Editar elemento">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                            @else
                                                <span>
                                                    <i class="fa-solid fa-ban"></i>
                                                </span>
                                            @endif
                                        @else
                                            <a href="{{ route('panel-documentos-apoyo-coplademun.edit', $doc->id) }}"
                                                class="btn btn-outline-secondary" title="Editar elemento">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                        @endif
                                        @if (Auth::user()->validador)
                                            <div>
                                                <form
                                                    action="{{ route('panel-documentos-apoyo-coplademun.destroy', $doc->id) }}"
                                                    method="POST" class="formEliminar ms-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">
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
