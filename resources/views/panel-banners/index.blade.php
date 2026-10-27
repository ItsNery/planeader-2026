<x-app-layout>
    @section('title', 'Banners: Inicio')
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
            <h2>Banners</h2>
            <p class="text-white">
                Aquí puedes ver los banners que van en la sección de
                <a href="{{ url('/inicio') }}" class="text-white">
                    inicio</a>.
                <br>
                <strong>
                    Para subir uno nuevo, pulsa el botón de Subir banner situado debajo de esta tarjeta.
                </strong>
            </p>
        </div>
        <div class="container d-flex justify-content-end flex-wrap gap-2">
            @can('editar-banner')
                <a href="{{ route('panel-banners.orden') }}" class="btn btn-outline-secondary mt-3 mb-3">
                    <i class="fa-solid fa-arrow-down-up-across-line me-1"></i>Reordenar banners
                </a>
            @endcan
            @can('crear-banner')
                <a href="{{ route('panel-banners.create') }}" class="btn btn-custom-primary mt-3 mb-3">
                    <i class="fa-solid fa-upload me-1"></i>Subir banner
                </a>
            @endcan
        </div>
        <table id="myTable" class="table w-100 table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>
                        Información del banner
                    </th>
                    <th class="text-center">
                        Enlace
                    </th>
                    <th class="text-center">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($banners)
                    @foreach ($banners as $banner)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{ $banner->orden }}
                                    <img src="{{ asset('baners/' . $banner->imagen) }}"
                                        class="img-thumbnail mx-2 imagen-lista">
                                    <div>
                                        <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                            {{ $banner->nombre }}
                                        </div>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <span class="badge bg-light text-dark border">
                                                {{ $banner->seccion }}
                                            </span>
                                            @if ($banner->estado == 'Activo')
                                                <span class="badge bg-success">
                                                    {{ $banner->estado }}
                                                </span>
                                                @elseif($banner->estado == 'Inactivo')
                                                <span class="badge bg-danger">
                                                    {{ $banner->estado }}
                                                </span>
                                            @else
                                                <span class="badge bg-info">
                                                    {{ $banner->estado }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ $banner->enlace }}" target="_blank" title=" {{ $banner->nombre }}"
                                    rel="noopener">
                                    <i class="fa-solid fa-up-right-from-square fs-2"></i>
                                </a>
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('panel-banners.edit', $banner->id) }}"
                                            class="text-decoration-none">
                                            <button class="btn btn-outline-secondary" title="Editar elemento">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                        </a>
                                        @if (Auth::user()->validador)
                                            <form action="{{ route('panel-banners.destroy', $banner->id) }}"
                                                method="POST" class="formEliminar ms-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"
                                                    title="Eliminar elemento">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th>
                        Información del banner
                    </th>
                    <th class="text-center">
                        Enlace
                    </th>
                    <th class="text-center">
                        Acciones
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</x-app-layout>
