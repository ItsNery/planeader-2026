<x-app-layout>
    @section('title', 'Planes Municipales: Inicio')
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
            <h2>Planes Municipales de Desarrollo</h2>
            <p class="text-white">
                Aquí puedes ver los documentos que van en la sección de
                <a href="{{ url('/planesmunicipales') }}" class="text-white">
                    Planes Municipales
                </a>, al igual que consultar los anteriores.
                <br>
                <strong>
                    Para subir uno nuevo, pulsa el botón de Subir documento situado debajo de esta tarjeta.
                </strong>
            </p>
        </div>
        <div class="container d-flex justify-content-end">
            <a href="{{ route('panel-planes-municipales.create') }}" class="text-decoration-none">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                    Subir
                    documento
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
                    @if ($planesMun)
                        @foreach ($planesMun as $planMun)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                                {{ $planMun->nombre }}
                                            </div>
                                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                                <span class="text-muted fw-bold small">
                                                    <i class="fa-regular fa-calendar me-1"></i>
                                                    {{ $planMun->periodo }}
                                                </span>
                                                <span class="badge bg-light text-dark border">
                                                    {{ $planMun->municipio->nombre }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ asset('planesmun/' . $planMun->ruta_documento) }}" target="_blank"
                                        title="Ver documento {{ $planMun->nombre }}">
                                        <i class="fa-solid fa-file-pdf fs-2"></i>
                                    </a>
                                </td>
                                <td class="text-center" style="width: 150px;">
                                    @if (Auth::user()->validador)
                                        <form action="{{ route('update-publicado-plan-municipal', $planMun->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="publicado" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                <option value="1" {{ $planMun->publicado ? 'selected' : '' }}>
                                                    Publicado
                                                </option>
                                                <option value="0" {{ !$planMun->publicado ? 'selected' : '' }}>
                                                    Borrador
                                                </option>
                                            </select>
                                        </form>
                                    @else
                                        <!-- Mostrar texto estático si el usuario no es validador -->
                                        {{ $planMun->publicado ? 'Sí' : 'No' }}
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            @if ($planMun->publicado == 1)
                                                @if (Auth::user()->validador)
                                                    <a href="{{ route('panel-planes-municipales.edit', $planMun->id) }}"
                                                        class="">
                                                        <button class="btn btn-outline-secondary"
                                                            title="Editar elemento">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </button>
                                                    </a>
                                                @else
                                                    <span><i class="fa-solid fa-ban"></i></span>
                                                @endif
                                            @else
                                                <a href="{{ route('panel-planes-municipales.edit', $planMun->id) }}"
                                                    class="">
                                                    <button class="btn btn-outline-secondary" title="Editar elemento">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                            @endif
                                            @if (Auth::user()->validador)
                                                <form
                                                    action="{{ route('panel-planes-municipales.destroy', $planMun->id) }}"
                                                    method="POST" class="formEliminar">
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
