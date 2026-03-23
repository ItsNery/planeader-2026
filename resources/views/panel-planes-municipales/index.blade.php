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
        @can('crear-plan-municipal')
        <div class="container d-flex justify-content-end">
            <a href="{{ route('panel-planes-municipales.create') }}" class="text-decoration-none">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                    Subir
                    documento
                </button>
            </a>
        </div>
        @endcan
        <div class="container table-responsive">
            <table id="planesMunicipalesTable" class="table w-100 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Información del documento</th>
                        <th>Documento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
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

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#planesMunicipalesTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('panel-planes-municipales.index') }}",
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
                        [0, 'asc']
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
