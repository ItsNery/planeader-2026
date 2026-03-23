<x-app-layout>
    @section('title', 'Documentos de Subcomités: Inicio')
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
            <h2>Documentos de subcomités</h2>
            <p class="text-white">
                Aquí ver los documentos relacionados algún
                <a href="{{ route('panel-subcomites.index') }}" class="text-white">subcomité</a>, recuerda primero crear
                el subcomité.
            </p>
            <strong>
                Para subir uno nuevo, pulsa el botón de Subir documento situado debajo de esta tarjeta.
            </strong>
        </div>
        @can('crear-doc-subcomite')
            <div class="container d-flex justify-content-end">
                <a href="{{ route('panel-documentos-subcomites.create') }}" class="">
                    <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                        Subir documento
                    </button>
                </a>
            </div>
        @endcan
        <div class="container table-responsive">
            <table id="subcomitesTable" class="table w-100 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Información del documento</th>
                        <th>Documento</th>
                        <th>Subcomité</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Subcomité</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#subcomitesTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('panel-documentos-subcomites.index') }}",
                    columns: [{
                            data: 'info',
                            name: 'nombre'
                        },
                        {
                            data: 'documento',
                            name: 'documento',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'subcomite_nombre',
                            name: 'subcomite.nombre'
                        },
                        {
                            data: 'estado',
                            name: 'estado',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'acciones',
                            name: 'acciones',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    language: {
                        search: "Buscar:",
                        lengthMenu: "Mostrar _MENU_ entradas",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                        infoEmpty: "Mostrando 0 a 0 de 0 entradas",
                        infoFiltered: "(filtrado de _MAX_ entradas totales)",
                        paginate: {
                            previous: "Anterior",
                            next: "Siguiente"
                        },
                        processing: "Procesando...",
                        emptyTable: "No hay datos disponibles en la tabla",
                        zeroRecords: "No se encontraron coincidencias"
                    },
                    order: [
                        [0, 'desc']
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
