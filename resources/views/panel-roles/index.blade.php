<x-app-layout>
    @section('title', 'Roles: Inicio')
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
    
    @if ($message = Session::get('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: '{{ $message }}'
                });
            });
        </script>
    @endif

    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3">
            <h2>Roles y Permisos</h2>
            <p class="text-white">
                Aquí puedes gestionar los roles del sistema y asignarles permisos específicos.
                <br>
                <strong>
                    Para crear uno nuevo, pulsa el botón de Crear nuevo rol situado debajo de esta tarjeta.
                </strong>
            </p>
        </div>
        @can('crear-rol')
        <div class="container d-flex justify-content-end">
            <a href="{{ route('panel-roles.create') }}" class="text-decoration-none">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                    Crear nuevo rol
                </button>
            </a>
        </div>
        @endcan
        <table id="myTable" class="table w-100 table-hover align-middle">
            <thead>
                <tr>
                    <th>Rol</th>
                    <th>Permisos</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark" style="font-size: 1.05rem;">
                                {{ ucfirst($role->name) }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach ($role->permissions as $permission)
                                    <span class="badge bg-light text-dark border small">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    @can('editar-rol')
                                    <a href="{{ route('panel-roles.edit', $role->id) }}" class="">
                                        <button class="btn btn-outline-secondary" title="Editar elemento">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                    </a>
                                    @endcan
                                    
                                    @can('borrar-rol')
                                    @if($role->name !== 'super-admin')
                                    <form action="{{ route('panel-roles.destroy', $role->id) }}"
                                        method="POST" class="formEliminar ms-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger"
                                            title="Eliminar elemento">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @endcan
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
