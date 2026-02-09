<x-app-layout>
    @section('title', 'Marco Jurídico: Inicio')
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
            <h2>Documentos de Marco Jurídico</h2>
            <p class="text-white">
                Aquí puedes ver los documentos relacionados al
                <a href="{{ url('/marco-juridico') }}" class="text-white">
                    Marco Júridico
                </a> que rige al portal.
            </p>
            <strong>
                Para subir uno nuevo, pulsa el botón de Subir documento situado debajo de esta tarjeta.
            </strong>
        </div>
        <div class="container d-flex justify-content-end">
            <a href="{{ route('panel-marco-juridico.create') }}" class="btn btn-custom-primary mt-3 mb-3 ml-3">
                Subir documento
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
                    @foreach ($documentos as $documento)
                        <tr>
                            <td class="d-flex flex-start flex-row">
                                <img src="{{ asset('portadas-marcojuridico/' . $documento->portada) }}"
                                    class="img-thumbnail mx-2 imagen-lista">
                                <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                    {{ $documento->nombre }}
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ asset('marco-juridico/' . $documento->ruta_documento) }}" target="_blank"
                                    title="Ver documento {{ $documento->nombre }}">
                                    <i class="fa-solid fa-file-pdf fs-2 "></i>
                                </a>
                            </td>
                            <td class="text-center" style="width: 150px;">
                                @if (Auth::user()->validador)
                                    <form action="{{ route('update-publicado', $documento->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="publicado" class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                            <option value="1" {{ $documento->publicado ? 'selected' : '' }}>
                                                Publicado
                                            </option>
                                            <option value="0" {{ !$documento->publicado ? 'selected' : '' }}>
                                                Borrador
                                            </option>
                                        </select>
                                    </form>
                                @else
                                    <span class="badge {{ $documento->publicado ? 'bg-success' : 'bg-warning' }}">
                                        {{ $documento->publicado ? 'Publicado' : 'Borrador' }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($documento->publicado == 1)
                                            @if (Auth::user()->validador)
                                                <a href="{{ route('panel-marco-juridico.edit', $documento->id) }}"
                                                    class="btn btn-outline-secondary" title="Editar elemento">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                            @else
                                                <span>
                                                    <i class="fa-solid fa-ban"></i>
                                                </span>
                                            @endif
                                        @else
                                            <a href="{{ route('panel-marco-juridico.edit', $documento->id) }}"
                                                class="btn btn-outline-secondary" title="Editar elemento">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                        @endif

                                        @if (Auth::user()->validador)
                                            <div>
                                                <form
                                                    action="{{ route('panel-marco-juridico.destroy', $documento->id) }}"
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
