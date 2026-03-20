<x-app-layout>
    @section('title', 'Anexos del ' . $planEstatal->nombre)
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
            <h2>Anexos del {{ $planEstatal->nombre }}</h2>
            <p class="text-white">
                Aquí puedes ver anexos del Plan Estatal de Desarrollo, que van en la sección de
                <a href="{{ url('/ped') }}" class="text-white">
                    Plan Estatal
                </a>.
                <br>
                <strong>
                    Para subir uno nuevo, pulsa el botón de Agregar anexo situado debajo de esta tarjeta.
                </strong>
            </p>
        </div>
        <div class="container d-flex justify-content-end gap-2">
            <a href="{{ route('panel-planes-estatales-anexos.create', $planEstatal->id) }}" class="text-decoration-none">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                    Agregar
                    anexo
                </button>
            </a>
            <a href="{{ route('panel-planes-estatales.index') }}" class="text-decoration-none">
                <button class="btn btn-custom-secondary mt-3 mb-3 ml-3">
                    Volver a Planes
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
                    @foreach ($anexos as $anexo)
                        <tr>
                            <td class="d-flex align-items-center">
                                <span>
                                    {{ $anexo->orden }}
                                </span>
                                <img src="{{ asset('img/ped/anexos/' . $anexo->imagen) }}?v={{ $anexo->updated_at->timestamp }})"
                                    class="img-thumbnail mx-2 imagen-lista">
                                <div>
                                    <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                        {{ $anexo->titulo }}
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                @if ($anexo->es_enlace)
                                    <a href="{{ $anexo->ruta_documento }}" target="_blank">
                                        <i class="fa-solid fa-up-right-from-square fs-2"></i>
                                    </a>
                                @else
                                    <a href="{{ asset('documentos/planesest/anexos/' . $anexo->ruta_documento) }}?v={{ $anexo->updated_at->timestamp }}"
                                        target="_blank">
                                        <i class="fa-solid fa-file-pdf fs-2"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="text-center" style="width: 150px;">
                                @if (Auth::user()->validador)
                                    <form action="{{ route('update-publicado-plan-estatal-anexo', $anexo->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="publicado" class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                            <option value="1" {{ $anexo->publicado ? 'selected' : '' }}>
                                                Publicado
                                            </option>
                                            <option value="0" {{ !$anexo->publicado ? 'selected' : '' }}>
                                                Borrador
                                            </option>
                                        </select>
                                    </form>
                                @else
                                    <span class="badge {{ $anexo->publicado ? 'bg-success' : 'bg-warning' }}">
                                        {{ $anexo->publicado ? 'Publicado' : 'Borrador' }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($anexo->publicado == 1)
                                            @if (Auth::user()->validador)
                                                <a href="{{ route('panel-planes-estatales-anexos.edit', [$planEstatal->id, $anexo->id]) }}"
                                                    class="btn btn-outline-secondary" title="Editar elemento">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                            @else
                                                <span><i class="fa-solid fa-ban"></i></span>
                                            @endif
                                        @else
                                            <a href="{{ route('panel-planes-estatales-anexos.edit', [$planEstatal->id, $anexo->id]) }}"
                                                class="btn btn-outline-secondary" title="Editar elemento">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                        @endif
                                        @if (Auth::user()->validador)
                                            <form
                                                action="{{ route('panel-planes-estatales-anexos.destroy', [$planEstatal->id, $anexo->id]) }}"
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
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
