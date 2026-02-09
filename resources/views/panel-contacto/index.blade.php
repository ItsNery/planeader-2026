<x-app-layout>
    @section('title', 'Formularios de Contacto: Inicio')
    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3">
            <h2>Mensajes de contacto</h2>
            <p class="text-white">
                Aquí puedes ver los mensajes que se han enviado desde el formulario de <a href="{{ url('/contacto') }}"
                    class="text-white">contacto</a>.
                <br>
                <strong>
                    Para eliminar uno, pulsa el botón de Borrar situado en la columna de Acciones, del registro que
                    desees eliminar.
                </strong>
            </p>
        </div>
        <table id="myTable" class="table w-100 table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Información</th>
                    <th>Correo</th>

                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mensajes as $mensaje)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                        {{ $mensaje->nombre }}
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 align-items-center">
                                        <span class="badge bg-light text-dark border">
                                            {{ $mensaje->asunto }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="mailto:{{ $mensaje->correo }}">{{ $mensaje->correo }}</a>
                        </td>

                        <td>
                            <div class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <!-- botón ver -->
                                    <button type="button" class="btn btn-outline-primary" title="Ver mensaje"
                                        data-bs-toggle="modal" data-bs-target="#modalVerMensaje"
                                        data-nombre="{{ $mensaje->nombre }}" data-correo="{{ $mensaje->correo }}"
                                        data-telefono="{{ $mensaje->telefono }}" data-asunto="{{ $mensaje->asunto }}"
                                        data-mensaje="{{ $mensaje->mensaje }}">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>

                                    <!-- botón borrar -->
                                    @if (Auth::user()->validador)
                                        <form action="{{ route('formulariocontacto.destroy', $mensaje->id) }}"
                                            method="POST" class="formEliminar ms-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Borrar">
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
                    <th>Información</th>
                    <th>Correo</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Modal Ver Mensaje -->
    <div class="modal fade" id="modalVerMensaje" tabindex="-1" aria-labelledby="modalVerMensajeLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVerMensajeLabel">Detalles del Mensaje</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold">Nombre:</label>
                            <p id="modal-nombre"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Correo:</label>
                            <p id="modal-correo"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold">Teléfono:</label>
                            <p id="modal-telefono"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Asunto:</label>
                            <p id="modal-asunto"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="fw-bold">Mensaje:</label>
                            <div class="p-3 bg-light rounded shadow-sm">
                                <p id="modal-mensaje" class="mb-0" style="white-space: pre-wrap;"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modalVerMensaje = document.getElementById('modalVerMensaje');
                modalVerMensaje.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var nombre = button.getAttribute('data-nombre');
                    var correo = button.getAttribute('data-correo');
                    var telefono = button.getAttribute('data-telefono');
                    var asunto = button.getAttribute('data-asunto');
                    var mensaje = button.getAttribute('data-mensaje');

                    modalVerMensaje.querySelector('#modal-nombre').textContent = nombre;
                    modalVerMensaje.querySelector('#modal-correo').textContent = correo;
                    modalVerMensaje.querySelector('#modal-telefono').textContent = telefono;
                    modalVerMensaje.querySelector('#modal-asunto').textContent = asunto;
                    modalVerMensaje.querySelector('#modal-mensaje').textContent = mensaje;
                });
            });
        </script>
    @endpush
</x-app-layout>
