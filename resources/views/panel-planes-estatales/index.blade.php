<x-app-layout>
    @section('title', 'Planes Estatales de Desarrollo: Inicio')
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
            <h2>Planes Estatales de Desarrollo</h2>
            <p class="text-white">
                Aquí puedes ver los documentos que van en la sección de
                <a href="{{ url('/ped') }}" class="text-white">
                    Plan Estatal
                </a>, al igual que consultar los anteriores.
                <br>
                <strong>
                    Para subir uno nuevo, pulsa el botón de Subir documento situado debajo de esta tarjeta.
                </strong>
            </p>
        </div>
        <div class="container d-flex justify-content-end">
            <a href="{{ route('panel-planes-estatales.create') }}" class="text-decoration-none">
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
                        <th>¿Publicado?</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($planesEst)
                        @foreach ($planesEst as $planEstatal)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('portadaplanesest/' . $planEstatal->portada) }}"
                                            class="img-thumbnail mx-2 imagen-lista">
                                        <div>
                                            <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                                {{ $planEstatal->nombre }}
                                            </div>
                                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                                <span class="text-muted fw-bold small">
                                                    <i
                                                        class="fa-regular fa-calendar me-1"></i>{{ $planEstatal->periodo }}
                                                </span>
                                                <span class="badge bg-light text-dark border">
                                                    {{ $planEstatal->gobernador }}
                                                </span>
                                                <span class="badge bg-light text-dark border">
                                                    {{ $planEstatal->anexos->count() }} anexo (s)
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ asset('planesest/' . $planEstatal->ruta_documento) }}" target="_blank"
                                        title="Ver documento {{ $planEstatal->nombre }}">
                                        <i class="fa-solid fa-file-pdf fs-2"></i>
                                    </a>
                                </td>
                                <td class="text-center" style="width: 150px;">
                                    @if (Auth::user()->validador)
                                        <form action="{{ route('update-publicado-plan-estatal', $planEstatal->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="publicado" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                <option value="1" {{ $planEstatal->publicado ? 'selected' : '' }}>
                                                    Publicado
                                                </option>
                                                <option value="0"
                                                    {{ !$planEstatal->publicado ? 'selected' : '' }}>
                                                    Borrador
                                                </option>
                                            </select>
                                        </form>
                                    @else
                                        <span
                                            class="badge {{ $planEstatal->publicado ? 'bg-success' : 'bg-warning' }}">
                                            {{ $planEstatal->publicado ? 'Publicado' : 'Borrador' }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            @if ($planEstatal->publicado == 1)
                                                @if (Auth::user()->validador)
                                                    <a
                                                        href="{{ route('panel-planes-estatales.edit', $planEstatal->id) }}">
                                                        <button class="btn btn-outline-secondary"
                                                            title="Editar elemento">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </button>
                                                    </a>
                                                @else
                                                    <span><i class="fa-solid fa-ban"></i></span>
                                                @endif
                                            @else
                                                <a href="{{ route('panel-planes-estatales.edit', $planEstatal->id) }}">
                                                    <button class="btn btn-outline-secondary" title="Editar elemento">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                </a>
                                            @endif

                                            @if (Auth::user()->validador)
                                                <form
                                                    action="{{ route('panel-planes-estatales.destroy', $planEstatal->id) }}"
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
                        <th>¿Publicado?</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-app-layout>
<script>
    (function() {
        'use strict'
        //debemos crear la clase formEliminar dentro del form del boton borrar
        //recordar que cada registro a eliminar esta contenido en un form  
        var forms = document.querySelectorAll('.formEliminar')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault()
                    event.stopPropagation()
                    Swal.fire({
                        title: '¿Confirma la eliminación del registro?',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                            Swal.fire('¡Eliminado!',
                                'El registro ha sido eliminado exitosamente.', 'success');
                        }
                    })
                }, false)
            })
    })()
</script>
