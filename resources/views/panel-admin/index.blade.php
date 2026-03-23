<x-app-layout>
    @section('title', 'Usuarios: Inicio')
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
            <h2>Usuarios</h2>
            <p class="text-white">
                Aquí puedes ver los usuarios que tienen acceso al sistema.
                <br>
                <strong>
                    Para crear uno nuevo, pulsa el botón de Crear nuevo situado debajo de esta tarjeta.
                </strong>
            </p>
        </div>
        @can('crear-usuario')
        <div class="container d-flex justify-content-end">
            <a href="{{ route('panel-admin.create') }}" class="text-decoration-none">
                <button class="btn btn-custom-primary mt-3 mb-3 ml-3">
                    Crear nuevo
                </button>
            </a>
        </div>
        @endcan
        <table id="myTable" class="table w-100 table-hover align-middle">
            <thead>
                <tr>
                    <th>Información del usuario</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if ($users)
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex rounded-circle bg-light text-dark border py-2 px-2 mx-3">
                                        <i class="fa-regular fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                            {{ $user->name }}
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <span class="badge bg-light text-dark fs-6 border">
                                                {{ $user->email }}
                                            </span>
                                            @foreach ($user->roles as $role)
                                                <span class="badge bg-primary">
                                                    {{ ucfirst($role->name) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @canany(['editar-usuario', 'borrar-usuario'])
                                            <div class="flex justify-center rounded-lg text-lg flex-row" role="group">
                                                <!-- botón editar -->
                                                @can('editar-usuario')
                                                <a href="{{ route('panel-admin.edit', $user->id) }}" class="">
                                                    <button class="btn btn-outline-secondary" title="Editar elemento">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                </a>
                                                @endcan
                                                <!-- botón borrar -->
                                                @can('borrar-usuario')
                                                <form action="{{ route('panel-admin.destroy', $user->id) }}"
                                                    method="POST" class="formEliminar ms-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger"
                                                        title="Eliminar elemento">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        @else
                                            <p class="text-muted small">Sin permisos</p>
                                        @endcanany
                                    </div>
                                </div>


                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th>Información del usuario</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </tfoot>
        </table>
    </div>
</x-app-layout>
