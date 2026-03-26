<x-app-layout>
    @section('title', 'Registro de asistencia de sesión ordinaria de COPLADEP: Listado')

    @push('styles')
        <style>
            .ts-dropdown {
                z-index: 1060 !important;
            }
        </style>
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.bootstrap5.min.css">
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @endpush
    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3">
            <h2>Listado de invitados registrados</h2>
            <p class="text-white">
                Aquí ver las personas invitadas para la
                <a href="{{ url('/copladep/primera-sesion-ordinaria') }}" class="text-white">primera sesión ordinaria
                    2026</a>.
            </p>
            <strong>
                Para registrar un nuevo invitado, pulsa el botón de Nuevo invitado situado debajo de esta tarjeta.
            </strong>
        </div>

        <div class="container d-flex justify-content-end">
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
                        <th>Cargo</th>
                        <th>Municipio</th>
                        <th>Sexo</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invitados as $invitado)
                        <tr>
                            <td>{{ $invitado->id }}</td>
                            <td class="fw-bold">{{ $invitado->nombre_completo }}</td>
                            <td>{{ $invitado->cargo }}</td>
                            <td>{{ $invitado->municipio->nombre_municipio ?? 'N/A' }}</td>
                            <td>{{ $invitado->sexo }}</td>
                            <td class="text-center d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-warning btn-sm btn-editar text-dark"
                                    data-id="{{ $invitado->id }}" data-nombre="{{ $invitado->nombre_completo }}"
                                    data-cargo="{{ $invitado->cargo }}" data-sexo="{{ $invitado->sexo }}"
                                    data-municipio="{{ $invitado->municipio_id }}" title="Editar Invitado">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <form action="{{ route('copladep-registro-invitados.destroy', $invitado->id) }}"
                                    method="POST" class="formEliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar Invitado">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="modalAgregarInvitado" tabindex="-1" aria-labelledby="modalAgregarInvitadoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-black">
                        <h5 class="modal-title" id="modalAgregarInvitadoLabel">
                            <i class="bi bi-person-plus-fill me-2"></i>Agregar invitado
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('copladep-registro-invitados.store') }}" method="POST">
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
                                    <label for="sexo_invitado" class="form-label fw-bold">Sexo</label>
                                    <select class="form-select" id="sexo_invitado" name="sexo" required>
                                        <option value="" selected disabled>Seleccionar...</option>
                                        <option value="Hombre">Hombre</option>
                                        <option value="Mujer">Mujer</option>
                                        <option value="Otro">Otro</option>
                                    </select>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar e Integrar a la Lista</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalEditarInvitado" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
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
                                    <label for="edit_sexo" class="form-label fw-bold">Sexo</label>
                                    <select class="form-select" id="edit_sexo" name="sexo" required>
                                        <option value="Hombre">Hombre</option>
                                        <option value="Mujer">Mujer</option>
                                    </select>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Actualizar Datos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
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
                    language: {
                        "search": "Buscar invitado:",
                        "lengthMenu": "Mostrar _MENU_ invitados",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ invitados",
                        "emptyTable": "No hay invitados registrados aún",
                        "paginate": { "previous": "Anterior", "next": "Siguiente" }
                    },
                    order: [[0, 'asc']]
                });

                // 2. Inicializar Tom Selects
                new TomSelect("#municipio_id_invitado", {
                    create: false,
                    sortField: { field: "text", direction: "asc" }
                });

                let selectEditMunicipio = new TomSelect("#edit_municipio_id", {
                    create: false,
                    sortField: { field: "text", direction: "asc" }
                });

                // 3. Delegación de eventos con Vanilla JS para el botón de Editar
                const tablaInvitados = document.getElementById('invitadosTable');

                tablaInvitados.addEventListener('click', function (event) {
                    // Buscamos si el clic provino de un elemento con la clase '.btn-editar' o un hijo de este (como el ícono)
                    const botonEditar = event.target.closest('.btn-editar');

                    // Si no se hizo clic en el botón de editar, detenemos la ejecución aquí
                    if (!botonEditar) return;

                    // Recuperamos los datos usando la propiedad nativa 'dataset'
                    const id = botonEditar.dataset.id;
                    const nombre = botonEditar.dataset.nombre;
                    const cargo = botonEditar.dataset.cargo;
                    const sexo = botonEditar.dataset.sexo;
                    const municipioId = botonEditar.dataset.municipio;

                    // 1. Armamos la ruta dinámica hacia el controlador
                    const formEditar = document.getElementById('formEditarInvitado');
                    formEditar.action = "{{ url('/copladep/primera-sesion-ordinaria/invitados') }}/" + id;

                    // 2. Llenamos los campos normales
                    document.getElementById('edit_nombre_completo').value = nombre;
                    document.getElementById('edit_cargo').value = cargo;
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