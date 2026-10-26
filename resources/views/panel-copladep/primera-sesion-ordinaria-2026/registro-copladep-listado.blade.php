<x-app-layout>
    @php($esSegunda = ($sesion ?? 'primera') === 'segunda')
    @section('title', 'Registro de asistencia de sesión ordinaria de COPLADEP: Listado')
    @if ($message = Session::get('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: '{{ $message }}'
                });
            });
        </script>
    @endif
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.bootstrap5.min.css">
    @endpush
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3">
            <h2>Listado de participantes registrados</h2>
            <p class="text-white">
                Aquí ver las personas registradas en el formulario de la
                <a href="{{ url($esSegunda ? '/copladep/segunda-sesion-ordinaria' : '/copladep/primera-sesion-ordinaria') }}" class="text-white">{{ $esSegunda ? 'segunda' : 'primera' }} sesión ordinaria
                    2026</a>.
            </p>
            <strong>
                Para un nuevo registro, pulsa el botón de Nuevo registro situado debajo de esta tarjeta.
            </strong>
        </div>

        <div class="container d-flex justify-content-end">
            @if (! $esSegunda)
            <a href="{{ route('copladep-registro-invitados-monitor.index') }}" class="mx-2">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                    Ver monitor
                </button>
            </a>
            @endif
            <a href="{{ route($esSegunda ? 'copladep-registro-segunda.create' : 'copladep-registro.create') }}" class="">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                    Nuevo registro
                </button>
            </a>
            <a href="{{ route($esSegunda ? 'copladep-registro-segunda-invitados.index' : 'copladep-registro-invitados.index') }}" class="mx-2">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                    Ver invitados
                </button>
            </a>
        </div>
        <div class="container table-responsive">
            <table id="registrosCopladepTable" class="table w-100 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tipo de Asistencia</th>
                        <th>Invitado Oficial (Titular)</th>
                        <th>Datos del Asistente</th>
                        <th>Municipio</th>
                        <th class="text-center">Firma o rúbrica</th>
                        <th>Fecha de Registro</th>
                        <th>Nombre de quien asiste</th>
                        <th>Cargo</th>
                        <th>Sexo</th>
                        <th>Correo Electrónico</th>
                        <th>Tel. oficina</th>
                        <th>Tel. celular</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registros as $registro)
                        <tr>
                            <td>{{ $registro->id }}</td>
                            <td class="text-center">
                                @if($registro->tipo_asistente == 'titular')
                                    <span class="badge bg-success">Titular</span>
                                @else
                                    <span class="badge bg-warning text-dark">Representante</span>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $registro->invitado->nombre_completo ?? 'N/A' }}</td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                            {{ $registro->nombre_completo }}
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 align-items-center mb-1">
                                            <span class="badge bg-light text-dark border">
                                                {{ $registro->cargo }}
                                            </span>
                                        </div>
                                        <div class="text-muted mt-1" style="font-size: 0.85rem;">
                                            <div class="mb-1"><i class="bi bi-envelope"></i>
                                                {{ $registro->correo_electronico }}</div>
                                            <div class="d-flex flex-wrap gap-3">
                                                @if($registro->telefono_oficina && $registro->telefono_oficina != 'ND')
                                                    <span><i class="bi bi-telephone"></i>
                                                        {{ $registro->telefono_oficina }}</span>
                                                @endif
                                                @if($registro->telefono_celular && $registro->telefono_celular != 'ND')
                                                    <span><i class="bi bi-phone"></i> {{ $registro->telefono_celular }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-light text-black border">
                                    {{ $registro->catMunicipio->nombre_municipio ?? 'N/A' }}
                                </span>
                            </td>

                            <td class="text-center">
                                @if($registro->firma)
                                    <img src="{{ $registro->firma }}" alt="Firma o rúbrica de {{ $registro->nombre_completo }}"
                                        class="firma-img" title="{{ $registro->nombre_completo }}">
                                @else
                                    <span class="badge bg-secondary">Sin firma</span>
                                @endif
                            </td>

                            <td>{{ $registro->created_at->format('d/m/Y H:i') }}</td>

                            <td>{{ $registro->nombre_completo }}</td>
                            <td>{{ $registro->cargo }}</td>
                            <td>{{ $registro->sexo }}</td>
                            <td>{{ $registro->correo_electronico }}</td>
                            <td>{{ $registro->telefono_oficina ?? 'ND'}}</td>
                            <td>{{ $registro->telefono_celular ?? 'ND'}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tipo de Asistencia</th>
                        <th>Invitado Oficial (Titular)</th>
                        <th>Datos del Asistente</th>
                        <th>Municipio</th>
                        <th class="text-center">Firma o rúbrica</th>
                        <th>Fecha de Registro</th>
                        <th>Nombre de quien asiste</th>
                        <th>Cargo</th>
                        <th>Sexo</th>
                        <th>Correo Electrónico</th>
                        <th>Tel. oficina</th>
                        <th>Tel. celular</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
        <script>
            $(document).ready(function () {
                if (!$.fn.DataTable.isDataTable('#registrosCopladepTable')) {
                    $('#registrosCopladepTable').DataTable({
                        responsive: true,
                        dom: 'Bfrtip',
                        "columnDefs": [
                            // Ocultamos las columnas 7 a la 12 en la interfaz web
                            { "visible": false, "targets": [5, 7, 8, 9, 10, 11, 12] }
                        ],
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                title: 'Registros_COPLADEP',
                                text: '<i class="bi bi-file-earmark-spreadsheet"></i> Exportar a Excel',
                                className: 'btn btn-success btn-sm',
                                exportOptions: {
                                    columns: [0, 1, 2, 7, 4, 8, 9, 10, 11, 12]
                                }
                            },
                            {
                                extend: 'csvHtml5',
                                title: 'Registros_COPLADEP',
                                text: '<i class="bi bi-filetype-csv"></i> Exportar a CSV',
                                className: 'btn btn-info btn-sm text-white',
                                exportOptions: {
                                    columns: [0, 1, 2, 7, 4, 8, 9, 10, 11, 12]
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                title: 'Registros_COPLADEP',
                                text: '<i class="bi bi-filetype-pdf"></i> Exportar a PDF',
                                orientation: 'landscape',
                                className: 'btn btn-danger btn-sm text-white',
                                exportOptions: {
                                    columns: [0, 1, 2, 7, 4, 8, 9, 10, 11, 12]
                                }
                            }
                        ],
                        language: {
                            "search": "Buscar:",
                            "lengthMenu": "Mostrar _MENU_ entradas",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                            "emptyTable": "No hay datos disponibles en la tabla",
                            "paginate": {
                                "previous": "Anterior",
                                "next": "Siguiente"
                            }
                        },
                        order: [[0, 'desc']]
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
