{{-- resources/views/registros/listado.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Registros - Capacitación Municipal</title>
    <link rel="shortcut icon" href="https://puebla.gob.mx/templates/dst_puebla_2024/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Estilos de DataTables y Buttons --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    {{-- jQuery (DataTables lo necesita) --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    {{-- Scripts de DataTables y Buttons --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script> {{-- Necesario para exportar a Excel --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> {{-- Opcional, para PDF --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> {{-- Opcional, para PDF --}}
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script> {{-- Opcional, para Imprimir --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/estilos-registro-capacitacion.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

</head>

<body>
    <section class="container contenedor-listado mt-4">
        <div class="container-xl">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Participantes</li>
                            </ol>
                        </nav>
                        <h1>Listado de Participantes Registrados</h1>
                        <p class="text-muted">Programa de Capacitación Municipal - Segundo Semestre {{ $year }}
                        </p>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <a href="{{ route('registro.create') }}" class="btn btn-primary-custom text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Registrar Nuevo Participante
                        </a>
                    </div>
                </div>
            </div>

            {{-- Pestañas de Bootstrap --}}
            <ul class="nav nav-tabs mt-4" id="registrosTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="dia1-tab" data-bs-toggle="tab" data-bs-target="#dia1-tab-pane"
                        type="button" role="tab" aria-controls="dia1-tab-pane" aria-selected="true">
                        Día 1 (Martes 18 de Noviembre de {{ $year }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="dia2-tab" data-bs-toggle="tab" data-bs-target="#dia2-tab-pane"
                        type="button" role="tab" aria-controls="dia2-tab-pane" aria-selected="false">
                        Día 2 (Miércoles 19 de Noviembre de {{ $year }})
                    </button>
                </li>
            </ul>

            {{-- Contenido de las Pestañas --}}
            <div class="tab-content" id="registrosTabContent">
                {{-- Pestaña Día 1 --}}
                <div class="tab-pane fade show active" id="dia1-tab-pane" role="tabpanel" aria-labelledby="dia1-tab"
                    tabindex="0">
                    @include('partials.tabla-registros', [
                        'registros' => $registrosDia1,
                        'tableId' => 'registrosTableDia1',
                        'dia' => '18 de noviembre',
                    ])
                </div>

                {{-- Pestaña Día 2 --}}
                <div class="tab-pane fade" id="dia2-tab-pane" role="tabpanel" aria-labelledby="dia2-tab" tabindex="0">
                    @include('partials.tabla-registros', [
                        'registros' => $registrosDia2,
                        'tableId' => 'registrosTableDia2',
                        'dia' => '19 de noviembre',
                    ])
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            function initializeDataTable(tableId, dia) {
                $('#' + tableId).DataTable({
                    responsive: true,
                    dom: 'Bfrtip', // Define dónde se colocarán los botones
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'Registros Participantes - ' + dia + ' - {{ $year }}',
                            text: '<i class="bi bi-file-earmark-spreadsheet"></i> Exportar a Excel'
                        },
                        {
                            extend: 'csvHtml5',
                            title: 'Registros Participantes - ' + dia + ' - {{ $year }}',
                            text: '<i class="bi bi-filetype-csv"></i> Exportar a CSV'
                        }
                    ],
                    language: {
                        "search": "Buscar:",
                        "lengthMenu": "Mostrar _MENU_ entradas",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                        "paginate": {
                            "previous": "Anterior",
                            "next": "Siguiente"
                        }

                    }
                });
            }

            initializeDataTable('registrosTableDia1', '21 Mayo');
            initializeDataTable('registrosTableDia2', '22 Mayo');
            // initializeDataTable('registrosTableDia3', '23 Mayo');

            // Asegurarse de que DataTables se redibuje cuando se muestra una pestaña (si hay problemas de ancho)
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();
            });
        });
    </script>
</body>

</html>
