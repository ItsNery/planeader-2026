{{-- resources/views/registros/listado.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Registros - Primera Sesión Ordinaria 2026 del COPLADEP</title>
    <link rel="shortcut icon" href="https://puebla.gob.mx/templates/dst_puebla_2024/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Estilos de DataTables y Buttons --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    {{-- jQuery (DataTables lo necesita) --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    {{-- Scripts de DataTables y Buttons --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/estilos-registro-capacitacion.css') }}">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .contenedor-listado {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .firma-img {
            max-height: 50px;
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 4px;
            padding: 2px;
        }
    </style>
</head>

<body>
    <section class="container contenedor-listado mt-4 mb-5">
        <div class="container-xl">
            <div class="page-header mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Participantes COPLADEP</li>
                            </ol>
                        </nav>
                        <h1>Listado de Participantes Registrados</h1>
                        <p class="text-muted">Programa COPLADEP</p>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        {{-- Asegúrate de que esta ruta coincida con la que creamos --}}
                        <a href="{{ route('copladep-registro.create') }}" class="btn btn-primary text-white">
                            <i class="bi bi-plus-circle me-1"></i> Registrar Nuevo Participante
                        </a>
                    </div>
                </div>
            </div>

            {{-- Tabla Única de Registros --}}
            <div class="table-responsive">
                <table id="registrosTable" class="table table-striped table-bordered display nowrap" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Municipio</th>
                            <th>Cargo</th>
                            <th>Sexo</th>
                            <th>Correo Electrónico</th>
                            <th>Celular</th>
                            <th>Firma o rúbrica</th>
                            <th>Fecha de Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registros as $registro)
                            <tr>
                                <td>{{ $registro->id }}</td>
                                <td>{{ $registro->nombre_completo }}</td>
                                {{-- Manejamos la relación con el municipio --}}
                                <td>{{ $registro->catMunicipio->nombre_municipio ?? 'N/A' }}</td>
                                <td>{{ $registro->cargo }}</td>
                                <td>{{ $registro->sexo }}</td>
                                <td>{{ $registro->correo_electronico }}</td>
                                <td>{{ $registro->telefono_celular }}</td>
                                <td class="text-center">
                                    @if($registro->firma)
                                        <img src="{{ $registro->firma }}" alt="Firma" class="firma-img">
                                    @else
                                        <span class="badge bg-secondary">Sin firma</span>
                                    @endif
                                </td>
                                <td>{{ $registro->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            $('#registrosTable').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Registros_COPLADEP',
                        text: '<i class="bi bi-file-earmark-spreadsheet"></i> Exportar a Excel',
                        className: 'btn btn-success btn-sm',
                        // Excluir la columna de la firma (índice 7) al exportar a Excel para evitar errores
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 8]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Registros_COPLADEP',
                        text: '<i class="bi bi-filetype-csv"></i> Exportar a CSV',
                        className: 'btn btn-info btn-sm text-white',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 8]
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
                order: [[0, 'desc']] // Ordenar por ID descendente por defecto (los más nuevos primero)
            });
        });
    </script>
</body>

</html>