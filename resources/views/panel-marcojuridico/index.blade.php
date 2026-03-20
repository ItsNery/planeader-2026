<x-app-layout>
    @section('title', 'Marco Jurídico: Inicio')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Documentos del Marco Jurídico') }}
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
                <div class="container ">
                    <a href="{{ route('panel-marco-juridico.create') }}" class="">
                        <button class="btn btn-primary mt-3 mb-3 ml-3">Subir
                            nuevo</button>
                    </a>
                </div>
                <div class="container table-responsive">
                    <table id="myTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Documento</th>
                                <th>Portada</th>
                                <th>Publicado?</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($documentos)
                            @foreach ($documentos as $documento)
                            <tr>
                                <td>{{ $documento->orden }}</td>
                                <td>{{ $documento->nombre }}</td>
                                <td><a href="/marco-juridico/{{ $documento->ruta_documento }}" target="_blank">
                                        <img class="justify-items-center" src="/imagen/pdf.png" alt="imagen de PDF" width="20%">
                                    </a></td>
                                <td>
                                    <img src="/portadas-marcojuridico/{{ $documento->portada }}" width="50%">
                                </td>
                                <td>
                                    @if (Auth::user()->validador)
                                    <!-- Mostrar un select si el usuario es validador -->
                                    <form action="{{ route('update-publicado', $documento->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="publicado" class="form-select" onchange="this.form.submit()">
                                            <option value="1" {{ $documento->publicado ? 'selected' : '' }}>Sí</option>
                                            <option value="0" {{ !$documento->publicado ? 'selected' : '' }}>No</option>
                                        </select>
                                    </form>
                                    @else
                                    <!-- Mostrar texto estático si el usuario no es validador -->
                                    {{ $documento->publicado ? 'Sí' : 'No' }}
                                    @endif
                                </td>
                                <td>
                                    <div class="flex justify-center rounded-lg text-lg" role="group">
                                        <!-- botón editar -->
                                        @if ($documento->publicado == 1)
                                        @if (Auth::user()->validador)
                                        <a href="{{ route('panel-marco-juridico.edit', $documento->id) }}" class="">
                                            <button class="btn btn-secondary">
                                                Editar
                                            </button></a>
                                        @else
                                        <span>No disponible</span>
                                        @endif
                                        @else
                                        <a href="{{ route('panel-marco-juridico.edit', $documento->id) }}" class="">
                                            <button class="btn btn-secondary">
                                                Editar
                                            </button></a>
                                        @endif
                                        <!-- botón borrar -->
                                        @if (Auth::user()->validador)
                                        <form action="{{ route('panel-marco-juridico.destroy', $documento->id) }}" method="POST" class="formEliminar">
                                            @csrf
                                            @method('DELETE')
                                            <button style="color: black" type="submit" class="btn btn-danger">Borrar</button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Documento</th>
                                <th>Portada</th>
                                <th>Publicado?</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
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
        $('#myTable').DataTable();
    });
</script>