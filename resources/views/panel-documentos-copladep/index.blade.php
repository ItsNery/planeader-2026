<x-app-layout>
    @section('title', 'Documentos del COPLADEP: Inicio')
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
            <h2>Documentos de COPLADEP</h2>
            <p class="text-white">
                Aquí puedes ver los documentos relacionados al
                <a href="{{ url('/copladep') }}" class="text-white">COPLADEP</a>, tales como Actas, Informes, y Programas Anuales.
            </p>
            <strong>
                Para subir uno nuevo, pulsa el botón de Subir documento situado debajo de esta tarjeta.
            </strong>
        </div>
        <div class="container d-flex justify-content-end">
            <a href="{{ route('panel-documentos-copladep.create') }}" class="text-decoration-none">
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
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($documentosCopladep)
                        @foreach ($documentosCopladep as $documentoCopladep)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                        {{ $documentoCopladep->nombre }}
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 align-items-center">
                                        <span class="text-muted fw-bold me-2 small">
                                            <i class="fa-regular fa-calendar me-1"></i>{{ $documentoCopladep->anio }}
                                        </span>

                                        <span class="badge bg-light text-dark border">
                                            {{ $documentoCopladep->tipo_documento }}
                                        </span>

                                        @if ($documentoCopladep->tipo_acta && $documentoCopladep->tipo_acta != 'No aplica')
                                            <span
                                                class="badge rounded-pill bg-primary-subtle text-primary border border-primary-integration">
                                                <i
                                                    class="fa-solid fa-file-lines me-1"></i>{{ $documentoCopladep->tipo_acta }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ asset('documentocopladep/' . $documentoCopladep->ruta_documento) }}"
                                        target="_blank" title="Ver documento {{ $documentoCopladep->nombre }}">
                                        <i class="fa-solid fa-file-pdf fs-2"></i>
                                    </a>
                                </td>
                                <td class="text-center" style="width: 150px;">
                                    @if (Auth::user()->validador)
                                        <form
                                            action="{{ route('update-publicado-documentos-copladep', $documentoCopladep->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="publicado" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                <option value="1"
                                                    {{ $documentoCopladep->publicado ? 'selected' : '' }}>Publicado
                                                </option>
                                                <option value="0"
                                                    {{ !$documentoCopladep->publicado ? 'selected' : '' }}>Borrador
                                                </option>
                                            </select>
                                        </form>
                                    @else
                                        <span
                                            class="badge {{ $documentoCopladep->publicado ? 'bg-success' : 'bg-warning' }}">
                                            {{ $documentoCopladep->publicado ? 'Publicado' : 'Borrador' }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            @if ($documentoCopladep->publicado == 1)
                                                @if (Auth::user()->validador)
                                                    <a href="{{ route('panel-documentos-copladep.edit', $documentoCopladep->id) }}"
                                                        class="">
                                                        <button class="btn btn-outline-secondary"
                                                            title="Editar elemento">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </button></a>
                                                @else
                                                    <span>
                                                        <i class="fa-solid fa-ban"></i>
                                                    </span>
                                                @endif
                                            @else
                                                <a href="{{ route('panel-documentos-copladep.edit', $documentoCopladep->id) }}"
                                                    class="">
                                                    <button class="btn btn-outline-secondary" title="Editar elemento">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button></a>
                                            @endif
                                            @if (Auth::user()->validador)
                                                <form
                                                    action="{{ route('panel-documentos-copladep.destroy', $documentoCopladep->id) }}"
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
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th>Información del documento</th>
                        <th>Documento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-app-layout>
