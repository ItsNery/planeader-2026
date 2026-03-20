{{-- resources/views/partials/tabla-registros.blade.php --}}
<div class="card mt-3">
    <div class="card-header">
        <h2>Registros del {{ $dia }}</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="{{ $tableId }}" class="table table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>Correo Electrónico</th>
                        <th>Macrorregión</th>
                        <th>Microrregión</th>
                        <th>Municipio</th>
                        <th>Cargo</th>
                        <th>Sexo</th>
                        <th>Tel. Oficina</th>
                        <th>Tel. Celular</th>
                        {{-- <th>Fecha Registro</th> --}}
                        {{-- Puedes agregar una columna de acciones si la necesitas de nuevo --}}
                        {{-- <th>Acciones</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($registros as $registro)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $registro->nombre_completo }}</td>
                            <td>{{ $registro->correo_electronico }}</td>
                            <td>{{ $registro->catMunicipio ? $registro->catMunicipio->nombre_macrorregion : 'N/D' }}
                            </td>
                            <td>{{ $registro->catMunicipio ? $registro->catMunicipio->nombre_microrregion : 'N/D' }}
                            </td>
                            <td>{{ $registro->catMunicipio ? $registro->catMunicipio->nombre_municipio : 'N/D' }}</td>
                            <td>{{ $registro->cargo }}</td>
                            <td>{{ $registro->sexo }}</td>
                            <td>{{ $registro->telefono_oficina ?? '-' }}</td>
                            <td>{{ $registro->telefono_celular ?? '-' }}</td>
                            {{-- <td>{{ $registro->created_at->format('d/m/Y H:i') }}</td> --}}
                            {{--
                            <td>
                                <a href="#" class="btn btn-sm btn-info">Ver</a>
                                <a href="#" class="btn btn-sm btn-warning">Editar</a>
                            </td>
                            --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-3">
                                No hay personas registradas para esta fecha todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
