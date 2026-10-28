<x-app-layout>
    @section('title', 'Registro de asistencia de sesión ordinaria de COPLADEP: Listado')

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.bootstrap5.min.css">
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @endpush
    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3">
            <h2>Listado de invitados registrados</h2>
            <p class="text-white">
                Aquí se muestran las personas invitadas para la
                <a href="{{ $sesion->ruta_publica ?: route('copladep-sesiones.registro.create', $sesion) }}" class="text-white">{{ $sesion->nombre }}</a>.
            </p>
            <strong>
                Para registrar un nuevo invitado, pulsa el botón de Nuevo invitado situado debajo de esta tarjeta.
            </strong>
        </div>

        <div class="container d-flex flex-wrap justify-content-end gap-2">
            <a href="{{ route('panel-copladep-sesiones.invitados.csv', $sesion) }}" class="btn btn-outline-secondary mt-3 mb-3">Exportar CSV</a>
            @can('ver-listado-registro-copladep')
                <a href="{{ route('panel-copladep-sesiones.show', $sesion) }}" class="btn btn-outline-secondary mt-3 mb-3">Volver a la sesión</a>
            @endcan
            @can('crear-invitado-copladep')
                <a href="{{ route('panel-copladep-sesiones.invitados.importar.form', $sesion) }}" class="btn btn-outline-secondary mt-3 mb-3">Importar invitados</a>
            @endcan
            <a href="{{ route('panel-copladep-sesiones.invitados.monitor', $sesion) }}" class="mx-2">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                    Ver monitor
                </button>
            </a>
            <button type="button" class="btn btn-custom-primary mt-3 mb-3 ml-3" data-bs-toggle="modal"
                data-bs-target="#modalAgregarInvitado">
                Nuevo invitado
            </button>
        </div>
        <div class="container table-responsive">
            <table id="invitadosTable" class="table w-100 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Municipio</th>
                        <th>Estatus</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invitados as $invitado)
                        <tr>
                            <td>{{ $invitado->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                            {{ $invitado->nombre_completo }}
                                        </div>
                                         <div class="d-flex flex-wrap gap-2 align-items-center">
                                             <span class="badge bg-light text-dark border">
                                                 {{ $invitado->cargo }}
                                             </span>
                                              @if ($invitado->dependenciaCopladep)
                                                  <span class="badge bg-light text-dark border">
                                                  {{ $invitado->dependenciaCopladep->nombre }}
                                                 </span>
                                             @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-black">
                                    {{ $invitado->municipio->nombre_municipio ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $estado = $invitado->estadoAsistencia($sesion->fecha_evento);
                                    $claseEstado = $estado === 'Falta' ? 'bg-secondary' : ($estado === 'Asistencia con retardo' ? 'bg-warning text-dark' : 'bg-success');
                                @endphp
                                <span class="badge {{ $claseEstado }}" id="badge-status-{{ $invitado->id }}">{{ $estado }}</span>
                                @foreach ($invitado->ingresosQr as $ingreso)
                                    <small class="d-block mt-1">QR: {{ $ingreso->nombre_completo }}@if ($ingreso->tipo_asistente === 'representante') (representante)@endif</small>
                                @endforeach
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button"
                                            class="btn btn-express {{ $invitado->check_in_express ? 'btn-success' : 'btn-outline-success' }} me-4 px-3 shadow-sm rounded"
                                            data-id="{{ $invitado->id }}" title="Activar o retirar asistencia manual" aria-label="Activar o retirar asistencia manual de {{ $invitado->nombre_completo }}">
                                            <i class="bi bi-person-check-fill"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-editar"
                                             data-id="{{ $invitado->id }}" data-nombre="{{ $invitado->nombre_completo }}"
                                             data-cargo="{{ $invitado->cargo }}" data-dependencia="{{ $invitado->dependencia_id }}" data-modalidad="{{ $invitado->modalidad }}" data-sexo="{{ $invitado->sexo }}"
                                            data-municipio="{{ $invitado->municipio_id }}" title="Editar Invitado">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Municipio</th>
                        <th>Estatus</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="modal fade" id="modalAgregarInvitado" tabindex="-1" aria-labelledby="modalAgregarInvitadoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-black">
                        <h5 class="modal-title" id="modalAgregarInvitadoLabel">
                            Agregar invitado
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('panel-copladep-sesiones.invitados.store', $sesion) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="nombre_completo" class="form-label fw-bold">Nombre completo
                                        (Titular)</label>
                                    <input type="text" class="form-control" id="nombre_completo" name="nombre_completo"
                                        required placeholder="Ej. Juan Pérez López">
                                </div>

                                 <div class="col-md-6 mb-3">
                                     <label for="cargo_invitado" class="form-label fw-bold">Cargo</label>
                                     <input type="text" class="form-control" id="cargo_invitado" name="cargo" required
                                         placeholder="Ej. Secretario de Infraestructura">
                                 </div>

                                 <div class="col-md-6 mb-3">
                                      <label for="dependencia_invitado" class="form-label fw-bold">Dependencia</label>
                                      <select class="form-select" id="dependencia_invitado" name="dependencia_id"><option value="">Seleccionar...</option>@foreach ($dependencias as $dependencia)<option value="{{ $dependencia->id }}">{{ $dependencia->nombre }}</option>@endforeach</select>
                                      <button type="button" class="btn btn-link btn-sm px-0 mt-1" data-bs-toggle="modal" data-bs-target="#modalNuevaDependencia">Nueva dependencia</button>
                                 </div>

                                 <div class="col-md-6 mb-3">
                                     <label for="sexo_invitado" class="form-label fw-bold">Sexo</label>
                                     <select class="form-select" id="sexo_invitado" name="sexo" required>
                                        <option value="" selected disabled>Seleccionar...</option>
                                        <option value="Hombre">Hombre</option>
                                        <option value="Mujer">Mujer</option>
                                        <option value="Otro">Otro</option>
                                     </select>
                                 </div>

                                 <div class="col-md-6 mb-3">
                                     <label for="modalidad_invitado" class="form-label fw-bold">Modalidad</label>
                                     <select class="form-select" id="modalidad_invitado" name="modalidad"><option value="">Por definir</option><option value="presencial">Presencial</option><option value="virtual">Virtual</option></select>
                                 </div>

                                <div class="col-md-12 mb-3">
                                    <label for="municipio_id_invitado" class="form-label fw-bold">Municipio</label>
                                    <select class="form-select" id="municipio_id_invitado" name="municipio_id" required>
                                        <option value="">Buscar o seleccionar municipio...</option>
                                        @foreach ($municipios as $municipio)
                                            <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary px-4"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-custom-primary px-5 shadow-sm">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalEditarInvitado" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-dark">
                        <h5 class="modal-title">
                            Editar datos del invitado
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formEditarInvitado" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="edit_nombre_completo" class="form-label fw-bold">Nombre completo</label>
                                    <input type="text" class="form-control" id="edit_nombre_completo"
                                        name="nombre_completo" required>
                                </div>

                                 <div class="col-md-6 mb-3">
                                     <label for="edit_cargo" class="form-label fw-bold">Cargo</label>
                                     <input type="text" class="form-control" id="edit_cargo" name="cargo" required>
                                 </div>

                                 <div class="col-md-6 mb-3">
                                      <label for="edit_dependencia" class="form-label fw-bold">Dependencia</label>
                                      <select class="form-select" id="edit_dependencia" name="dependencia_id"><option value="">Seleccionar...</option>@foreach ($dependencias as $dependencia)<option value="{{ $dependencia->id }}">{{ $dependencia->nombre }}</option>@endforeach</select>
                                 </div>

                                 <div class="col-md-6 mb-3">
                                    <label for="edit_sexo" class="form-label fw-bold">Sexo</label>
                                    <select class="form-select" id="edit_sexo" name="sexo" required>
                                        <option value="Hombre">Hombre</option>
                                        <option value="Mujer">Mujer</option>
                                    </select>
                                 </div>

                                 <div class="col-md-6 mb-3">
                                     <label for="edit_modalidad" class="form-label fw-bold">Modalidad</label>
                                     <select class="form-select" id="edit_modalidad" name="modalidad"><option value="">Por definir</option><option value="presencial">Presencial</option><option value="virtual">Virtual</option></select>
                                 </div>

                                <div class="col-md-12 mb-3">
                                    <label for="edit_municipio_id" class="form-label fw-bold">Municipio</label>
                                    <select class="form-select" id="edit_municipio_id" name="municipio_id" required>
                                        <option value="">Buscar o seleccionar municipio...</option>
                                        @foreach ($municipios as $municipio)
                                            <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary px-4"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-custom-primary px-5 shadow-sm">Actualizar
                                Datos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalNuevaDependencia" tabindex="-1" aria-labelledby="modalNuevaDependenciaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form id="formNuevaDependencia" class="modal-content">
                    <div class="modal-header"><h2 class="h5 modal-title" id="modalNuevaDependenciaLabel">Nueva dependencia</h2><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button></div>
                    <div class="modal-body">
                        <label for="nueva_dependencia_nombre" class="form-label">Nombre</label><input class="form-control mb-3" id="nueva_dependencia_nombre" name="nombre" required maxlength="255">
                        <label for="nueva_dependencia_siglas" class="form-label">Siglas</label><input class="form-control" id="nueva_dependencia_siglas" name="siglas" maxlength="30">
                        <div id="errorNuevaDependencia" class="alert alert-danger d-none mt-3 mb-0"></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-custom-primary">Guardar dependencia</button></div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#0d6efd',
                        timer: 3000,
                        timerProgressBar: true
                    });
                @endif

                    @if ($errors->any())
                        let errores = '';
                        @foreach ($errors->all() as $error)
                            errores += '• {{ $error }}\n';
                        @endforeach

                        Swal.fire({
                            icon: 'error',
                            title: '¡Revisa los datos!',
                            text: errores,
                            confirmButtonColor: '#dc3545'
                        });
                    @endif

                // 1. Inicializar DataTables usando Vanilla JS
                // (En DataTables v1.11+ ya puedes usar 'new DataTable' en lugar del viejo '$().DataTable')
                new DataTable('#invitadosTable', {
                    responsive: true,
                    dom: 'Bfrtip', // Habilita los botones
                    buttons: [
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="bi bi-file-earmark-pdf"></i> Exportar a PDF',
                            className: 'btn btn-danger btn-sm text-white mb-3',
                            title: 'Pase de Lista - COPLADEP',
                            exportOptions: { columns: [0, 1, 2, 3] } // No exportamos la columna de botones
                        },
                        {
                            extend: 'print',
                            text: '<i class="bi bi-printer"></i> Imprimir Lista',
                            className: 'btn btn-secondary btn-sm text-white mb-3 ms-2',
                            title: 'Pase de Lista - COPLADEP',
                            exportOptions: { columns: [0, 1, 2, 3] }
                        }
                    ],
                    order: [[0, 'asc']]
                });

                // 2. Inicializar Tom Selects
                new TomSelect("#municipio_id_invitado", {
                    create: false,
                    sortField: { field: "text", direction: "asc" }
                });

                let selectDependencia = new TomSelect("#dependencia_invitado", {
                    create: false,
                    sortField: { field: "text", direction: "asc" },
                    placeholder: "Buscar dependencia..."
                });

                let selectEditMunicipio = new TomSelect("#edit_municipio_id", {
                    create: false,
                    sortField: { field: "text", direction: "asc" }
                });

                let selectEditDependencia = new TomSelect("#edit_dependencia", {
                    create: false,
                    sortField: { field: "text", direction: "asc" },
                    placeholder: "Buscar dependencia..."
                });

                const modalAgregarInvitado = document.getElementById('modalAgregarInvitado');
                const modalNuevaDependencia = document.getElementById('modalNuevaDependencia');
                modalNuevaDependencia.addEventListener('show.bs.modal', () => {
                    bootstrap.Modal.getInstance(modalAgregarInvitado)?.hide();
                });
                modalNuevaDependencia.addEventListener('hidden.bs.modal', () => {
                    bootstrap.Modal.getOrCreateInstance(modalAgregarInvitado).show();
                });

                document.getElementById('formNuevaDependencia').addEventListener('submit', async function (event) {
                    event.preventDefault();
                    const error = document.getElementById('errorNuevaDependencia');
                    error.classList.add('d-none');
                    const response = await fetch('{{ route('panel-copladep-dependencias.store-quick') }}', {
                        method: 'POST',
                        headers: {'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        body: new FormData(this)
                    });
                    const data = await response.json();
                    if (!response.ok) {
                        error.textContent = data.errors?.nombre?.[0] || 'No fue posible guardar la dependencia.';
                        error.classList.remove('d-none');
                        return;
                    }
                    const option = {value: data.id, text: data.nombre};
                    selectDependencia.addOption(option);
                    selectEditDependencia.addOption(option);
                    selectDependencia.setValue(data.id);
                    this.reset();
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('modalNuevaDependencia')).hide();
                });

                // 3. Delegación de eventos con Vanilla JS para el botón de Editar
                const tablaInvitados = document.getElementById('invitadosTable');

                tablaInvitados.addEventListener('click', function (event) {
                    const btnExpress = event.target.closest('.btn-express');

                    if (btnExpress) {
                        const id = btnExpress.dataset.id;
                        const url = `{{ url('/panel-copladep/sesiones/' . $sesion->clave . '/invitados') }}/${id}/toggle-express`;

                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // 1. Cambiamos el color del botón
                                    if (data.estado_actual) {
                                        btnExpress.classList.remove('btn-outline-success');
                                        btnExpress.classList.add('btn-success');
                                    } else {
                                        btnExpress.classList.remove('btn-success');
                                        btnExpress.classList.add('btn-outline-success');
                                    }

                                    // 2. Actualizamos la etiqueta (Badge) con lo que dictó el servidor
                                    let badge = document.getElementById('badge-status-' + id);
                                    if (badge) {
                                        // Limpiamos las clases anteriores y ponemos las nuevas
                                        badge.className = 'badge ' + data.estado_clase;
                                        badge.textContent = data.estado_texto;
                                    }

                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        icon: 'success',
                                        title: data.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                } else {
                                    Swal.fire('Atención', data.message, 'info');
                                }
                            })
                            .catch(error => console.error('Error:', error));

                        return;
                    }
                    // Buscamos si el clic provino de un elemento con la clase '.btn-editar' o un hijo de este (como el ícono)
                    const botonEditar = event.target.closest('.btn-editar');

                    // Si no se hizo clic en el botón de editar, detenemos la ejecución aquí
                    if (!botonEditar) return;

                    // Recuperamos los datos usando la propiedad nativa 'dataset'
                    const id = botonEditar.dataset.id;
                    const nombre = botonEditar.dataset.nombre;
                    const cargo = botonEditar.dataset.cargo;
                    const dependencia = botonEditar.dataset.dependencia;
                    const modalidad = botonEditar.dataset.modalidad;
                    const sexo = botonEditar.dataset.sexo;
                    const municipioId = botonEditar.dataset.municipio;

                    // 1. Armamos la ruta dinámica hacia el controlador
                    const formEditar = document.getElementById('formEditarInvitado');
                    formEditar.action = "{{ url('/panel-copladep/sesiones/' . $sesion->clave . '/invitados') }}/" + id;

                    // 2. Llenamos los campos normales
                    document.getElementById('edit_nombre_completo').value = nombre;
                    document.getElementById('edit_cargo').value = cargo;
                    selectEditDependencia.setValue(dependencia);
                    document.getElementById('edit_modalidad').value = modalidad;
                    document.getElementById('edit_sexo').value = sexo;

                    // 3. Llenamos el Tom Select
                    selectEditMunicipio.setValue(municipioId);

                    // 4. Mostramos el Modal usando la API nativa de Bootstrap 5
                    const modalElement = document.getElementById('modalEditarInvitado');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                    modalInstance.show();
                });

            });
        </script>
    @endpush
</x-app-layout>
