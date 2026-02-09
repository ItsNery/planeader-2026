<x-app-layout>
    @section('title', 'Documentos de Subcomités: Inicio')
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
            <h2>Documentos de subcomités</h2>
            <p class="text-white">
                Aquí ver los documentos relacionados algún
                <a href="{{ route('panel-subcomites.index') }}" class="text-white">subcomité</a>, recuerda primero crear
                el subcomité.
            </p>
            <strong>
                Para subir uno nuevo, pulsa el botón de Subir documento situado debajo de esta tarjeta.
            </strong>
        </div>
        <div class="container d-flex justify-content-end">
            <a href="{{ route('panel-documentos-subcomites.create') }}" class="">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                    Subir documento
                </button>
            </a>
        </div>
        <div class="container table-responsive">
            <table id="myTable" class="table w-100 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Información del documento</th>
                        <th>Documento</th>
                        <th>Subcomité</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($DocumentoSubcomites as $DocumentoSubcomite)
                        <tr>
                            <td>
                                <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                    {{ $DocumentoSubcomite->nombre }}
                                </div>

                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    <span class="text-muted fw-bold me-2 small">
                                        <i class="fa-regular fa-calendar me-1"></i>{{ $DocumentoSubcomite->anio }}
                                    </span>

                                    <span class="badge bg-light text-dark border">
                                        {{ $DocumentoSubcomite->tipo_documento }}
                                    </span>

                                    @if ($DocumentoSubcomite->tipo_acta && $DocumentoSubcomite->tipo_acta != 'No aplica')
                                        <span
                                            class="badge rounded-pill bg-primary-subtle text-primary border border-primary-integration">
                                            <i
                                                class="fa-solid fa-file-lines me-1"></i>{{ $DocumentoSubcomite->tipo_acta }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ asset('documentosubcomites/' . $DocumentoSubcomite->ruta_documento) }}"
                                    target="_blank" title="Ver documento {{ $DocumentoSubcomite->nombre }}">
                                    <i class="fa-solid fa-file-pdf fs-2"></i>
                                </a>
                            </td>
                            <td>
                                <small class="text-muted d-block text-uppercase fw-semibold"
                                    style="font-size: 0.7rem;">Pertenece al:</small>
                                <span class="text-secondary">{{ $DocumentoSubcomite->subcomite->nombre }}</span>
                            </td>
                            <td class="text-center" style="width: 150px;">
                                @if (Auth::user()->validador)
                                    <form
                                        action="{{ route('update-publicado-documento-subcomite', $DocumentoSubcomite->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="publicado" class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                            <option value="1"
                                                {{ $DocumentoSubcomite->publicado ? 'selected' : '' }}>Publicado
                                            </option>
                                            <option value="0"
                                                {{ !$DocumentoSubcomite->publicado ? 'selected' : '' }}>Borrador
                                            </option>
                                        </select>
                                    </form>
                                @else
                                    <span
                                        class="badge {{ $DocumentoSubcomite->publicado ? 'bg-success' : 'bg-warning' }}">
                                        {{ $DocumentoSubcomite->publicado ? 'Publicado' : 'Borrador' }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($DocumentoSubcomite->publicado == 1)
                                            @if (Auth::user()->validador)
                                                <a href="{{ route('panel-documentos-subcomites.edit', $DocumentoSubcomite->id) }}"
                                                    class="">
                                                    <button class="btn btn-outline-secondary" title="Editar elemento">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                </a>
                                            @else
                                                <span>
                                                    <i class="fa-solid fa-ban"></i>
                                                </span>
                                            @endif
                                        @else
                                            <a href="{{ route('panel-documentos-subcomites.edit', $DocumentoSubcomite->id) }}"
                                                class="">
                                                <button class="btn btn-outline-secondary" title="Editar elemento">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                            </a>
                                        @endif
                                        @if (Auth::user()->validador)
                                            <form
                                                action="{{ route('panel-documentos-subcomites.destroy', $DocumentoSubcomite->id) }}"
                                                method="POST" class="formEliminar ms-1">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger" title="Eliminar elemento">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Subcomité</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        {{-- <div>
                    {{ $DocumentoSubcomites->links() }}
            </div> --}}
    </div>
</x-app-layout>
