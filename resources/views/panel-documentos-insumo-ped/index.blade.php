<x-app-layout>
    @section('title', 'Insumos del PED: Inicio')
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
            <h2>Insumos del Plan Estatal de Desarrollo</h2>
            <p class="text-white">
                Aquí puedes gestionar los documentos de insumos del PED:
                <strong>Árboles de problemas</strong> y <strong>Fichas de indicadores</strong>.
                <br>
                <strong>
                    Para subir uno nuevo, pulsa el botón de Subir documento situado debajo de esta tarjeta.
                </strong>
            </p>
        </div>
        <div class="container d-flex justify-content-end">
            <a href="{{ route('panel-documentos-insumo-ped.create') }}" class="text-decoration-none">
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
                        <th>Tipo</th>
                        <th>Formato</th>
                        <th>¿Publicado?</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($documentos)
                        @foreach ($documentos as $documento)
                            <tr>
                                <td>
                                    <div>
                                        <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                            {{ $documento->titulo }}
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <span class="text-muted fw-bold small">
                                                <i class="fa-regular fa-calendar me-1"></i>
                                                {{ $documento->created_at->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($documento->tipo === 'arbol-problemas')
                                        <span class="badge bg-info text-dark">Árbol de Problemas</span>
                                    @else
                                        <span class="badge bg-success text-white">Fichas de Indicadores</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($documento->formato === 'pdf')
                                        <span class="badge bg-danger text-white">PDF</span>
                                    @else
                                        <span class="badge bg-success text-white">Excel</span>
                                    @endif
                                </td>
                                <td class="text-center" style="width: 150px;">
                                    @if (Auth::user()->validador)
                                        <form action="{{ route('update-publicado-documento-insumo-ped', $documento->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="publicado" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                <option value="1" {{ $documento->publicado ? 'selected' : '' }}>
                                                    Publicado
                                                </option>
                                                <option value="0"
                                                    {{ !$documento->publicado ? 'selected' : '' }}>
                                                    Borrador
                                                </option>
                                            </select>
                                        </form>
                                    @else
                                        <span
                                            class="badge {{ $documento->publicado ? 'bg-success' : 'bg-warning' }}">
                                            {{ $documento->publicado ? 'Publicado' : 'Borrador' }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            @if ($documento->publicado == 1)
                                                @if (Auth::user()->validador)
                                                    <a
                                                        href="{{ route('panel-documentos-insumo-ped.edit', $documento->id) }}">
                                                        <button class="btn btn-outline-secondary"
                                                            title="Editar elemento">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </button>
                                                    </a>
                                                @else
                                                    <span><i class="fa-solid fa-ban"></i></span>
                                                @endif
                                            @else
                                                <a href="{{ route('panel-documentos-insumo-ped.edit', $documento->id) }}">
                                                    <button class="btn btn-outline-secondary" title="Editar elemento">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                </a>
                                            @endif

                                            @if (Auth::user()->validador)
                                                <form
                                                    action="{{ route('panel-documentos-insumo-ped.destroy', $documento->id) }}"
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
                        <th>Tipo</th>
                        <th>Formato</th>
                        <th>¿Publicado?</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-app-layout>
