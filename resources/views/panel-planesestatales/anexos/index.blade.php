<x-app-layout>
    @section('title', 'Anexos de ' . $planEstatal->nombre)
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Anexos de ') . $planEstatal->nombre }}
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
                <div class="container d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('panel-planesestatales-anexos.create', $planEstatal->id) }}" class="">
                            <button class="btn btn-primary mt-3 mb-3 ml-3">Agregar Anexo</button>
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('panel-planesestatales.index') }}" class="btn btn-secondary mt-3 mb-3 mr-3">
                            Volver a Planes
                        </a>
                    </div>
                </div>
                <div class="container table-responsive">
                    <table id="myTable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Orden</th>
                                <th>Título</th>
                                <th>Documento</th>
                                <th>Imagen</th>
                                <th>¿Publicado?</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anexos as $anexo)
                                <tr>
                                    <td>{{ $anexo->orden }}</td>
                                    <td>{{ $anexo->titulo }}</td>
                                    <td>
                                        @if ($anexo->es_enlace)
                                            <a href="{{ $anexo->ruta_documento }}" target="_blank">
                                                <img src="/imagen/pdf.png" alt="PDF" width="30px">
                                            </a>
                                        @else
                                            <a href="/documentos/planesest/anexos/{{ $anexo->ruta_documento }}?v={{ $anexo->updated_at->timestamp }}"
                                                target="_blank">
                                                <img src="/imagen/pdf.png" alt="PDF" width="30px">
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <img src="/img/ped/anexos/{{ $anexo->imagen }}?v={{ $anexo->updated_at->timestamp }}"
                                            width="60px">
                                    </td>
                                    <td>
                                        @if (Auth::user()->validador)
                                            <form
                                                action="{{ route('update-publicado-plan-estatal-anexo', $anexo->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <select name="publicado" class="form-select"
                                                    onchange="this.form.submit()">
                                                    <option value="1" {{ $anexo->publicado ? 'selected' : '' }}>Sí
                                                    </option>
                                                    <option value="0" {{ !$anexo->publicado ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </form>
                                        @else
                                            {{ $anexo->publicado ? 'Sí' : 'No' }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex justify-center rounded-lg text-lg" role="group">
                                            <a href="{{ route('panel-planesestatales-anexos.edit', [$planEstatal->id, $anexo->id]) }}"
                                                class="btn btn-secondary mr-2">
                                                Editar
                                            </a>
                                            <form
                                                action="{{ route('panel-planesestatales-anexos.destroy', [$planEstatal->id, $anexo->id]) }}"
                                                method="POST" class="formEliminar">
                                                @csrf
                                                @method('DELETE')
                                                <button style="color: black" type="submit"
                                                    class="btn btn-danger">Borrar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.formEliminar')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault()
                    event.stopPropagation()
                    Swal.fire({
                        title: '¿Confirma la eliminación de este anexo?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#20c997',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Confirmar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
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
