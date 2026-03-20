<x-app-layout>
    @section('title', 'Documentos de Subcomités: Inicio')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Documentos del Subcomite') }}
        </h2>
    </x-slot>
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
    <div class="container py-12 mx-auto">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="" style="background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <div class="container py-3 px-3">
                    <h1 style="font-size: 1.3rem; font-weight:500" class="text-center">Bienvenido, Aquí podrás ver la
                        documentación de cada subcomité</h1>
                </div>
                <div class="container ">
                    <a href="{{ route('panel-documentos-subcomites.create') }}" class="">
                        <button class="btn btn-primary mt-3 mb-3 ml-3">Subir
                            nuevo</button>
                    </a>
                </div>
                <div class="container table-responsive">
                    <table id="myTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Año</th>
                                <th>Documento</th>
                                <th>Tipo/documento</th>
                                <th>Tipo acta</th>
                                <th>Subcomité</th>
                                <th>¿Publicado?</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($DocumentoSubcomites as $DocumentoSubcomite)
                            <tr>
                                <td>{{ $DocumentoSubcomite->nombre }}</td>
                                <td>{{ $DocumentoSubcomite->anio }}</td>
                                <td><a href="/documentosubcomites/{{ $DocumentoSubcomite->ruta_documento }}" target="_blank">
                                        <img class="justify-items-center" src="/imagen/pdf.png" alt="imagen de PDF" width="20%">
                                    </a></td>
                                <td>{{ $DocumentoSubcomite->tipo_documento }}</td>
                                <td>{{ $DocumentoSubcomite->tipo_acta ?: 'No aplica' }}</td>
                                <td>{{ $DocumentoSubcomite->subcomite->nombre }}</td>
                                <td>
                                    @if (Auth::user()->validador)
                                    <!-- Mostrar un select si el usuario es validador -->
                                    <form action="{{ route('update-publicado-documento-subcomite', $DocumentoSubcomite->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="publicado" class="form-select" onchange="this.form.submit()">
                                            <option value="1" {{ $DocumentoSubcomite->publicado ? 'selected' : '' }}>Sí
                                            </option>
                                            <option value="0" {{ !$DocumentoSubcomite->publicado ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                    </form>
                                    @else
                                    <!-- Mostrar texto estático si el usuario no es validador -->
                                    {{ $DocumentoSubcomite->publicado ? 'Sí' : 'No' }}
                                    @endif
                                </td>

                                <td>
                                    <div class="flex justify-center rounded-lg text-lg" role="group">
                                        @if ($DocumentoSubcomite->publicado == 1)
                                        @if (Auth::user()->validador)
                                        <a href="{{ route('panel-documentos-subcomites.edit', $DocumentoSubcomite->id) }}" class="">
                                            <button class="btn btn-secondary">
                                                Editar
                                            </button>
                                        </a>
                                        @else
                                        <span>No disponible</span>
                                        @endif
                                        @else
                                        <a href="{{ route('panel-documentos-subcomites.edit', $DocumentoSubcomite->id) }}" class="">
                                            <button class="btn btn-secondary">
                                                Editar
                                            </button>
                                        </a>
                                        @endif
                                        <!-- botón editar -->
                                        <!-- <a href="{{ route('panel-documentos-subcomites.edit', $DocumentoSubcomite->id) }}"
                                                class="">
                                                <button class="btn btn-secondary">
                                                    Editar
                                                </button></a> -->
                                        <!-- botón borrar -->
                                        @if (Auth::user()->validador)
                                        <form action="{{ route('panel-documentos-subcomites.destroy', $DocumentoSubcomite->id) }}" method="POST" class="formEliminar">
                                            @csrf
                                            @method('DELETE')
                                            <button style="color: black" type="submit" class="btn btn-danger">Borrar</button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Año</th>
                                <th>Documento</th>
                                <th>Tipo/documento</th>
                                <th>Tipo acta</th>
                                <th>Subcomité</th>
                                <th>¿Publicado?</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                {{-- <div>
                    {{ $DocumentoSubcomites->links() }}
            </div> --}}
        </div>
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
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "pagingType": "simple_numbers",
            "order": [],
            "language": {
                "search": "Buscar:",
                "lengthMenu": "Mostrar _MENU_ entradas",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                }
            }
        });
    });
</script>