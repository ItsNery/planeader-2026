<x-app-layout>
    @section('title', 'Programas Derivados: Inicio')
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
            <h2>Programas Derivados</h2>
            <p class="text-white">
                Aquí puedes ver los programas derivados relacionados a algún
                <a href="{{ route('panel-planes-estatales.index') }}" class="text-white">
                    Plan
                    Estatal de Desarrollo
                </a>.
                <br>
                <strong>
                    Para crear uno nuevo de manera individual, pulsa el botón de Crear programa situado debajo de esta
                    tarjeta, en caso de que se desee hacerlo masivamente, pulsa el boton de Crear masivamente.
                </strong>
            </p>
        </div>
        <div class="container d-flex justify-content-end">
            @can('crear-programa-derivado')
            <a href="{{ route('panel-programas-derivados.createMassive') }}" class="text-decoration-none">
                <button class="btn btn-custom-secondary mt-3 mb-3 ml-3">
                    Crear masivamente
                </button>
            </a>
            <a href="{{ route('panel-programas-derivados.create') }}" class="text-decoration-none">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3 ms-1">
                    Crear programa
                </button>
            </a>
            @endcan
        </div>
        <div class="container table-responsive">
            <table id="programasDerivadosTable" class="table w-100 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Información del programa</th>
                        <th>Documento</th>
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
                $('#programasDerivadosTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('panel-programas-derivados.index') }}",
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
