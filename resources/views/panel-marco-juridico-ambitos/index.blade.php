<x-app-layout>
    @section('title', 'Ámbitos del Marco Jurídico: Inicio')

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
                    title: 'Error',
                    text: '{{ $message }}'
                });
            });
        </script>
    @endif

    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3">
            <h2>Ámbitos del Marco Jurídico</h2>
            <p class="text-white">
                Aquí puedes gestionar los diferentes ámbitos (ej: Internacional, Nacional, Estatal, Municipal) 
                que organizan los documentos en la sección del 
                <a href="{{ url('/marcojuridico') }}" class="text-white fw-bold">
                    Marco Jurídico
                </a>.
                <br>
                <strong>
                    Para registrar uno nuevo, pulsa el botón de "Crear ámbito" situado debajo de esta tarjeta.
                </strong>
            </p>
        </div>
        <div class="container d-flex justify-content-end">
            <a href="{{ route('panel-marco-juridico-ambitos.create') }}" class="btn btn-custom-primary mt-3 mb-3 ml-3">
                <i class="fa-solid fa-plus me-1"></i> Crear ámbito
            </a>
        </div>
        <div class="container table-responsive">
            <table id="myTable" class="table w-100 table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 100px;">Orden</th>
                        <th>Información del ámbito</th>
                        <th>Portada asignada</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ambitos as $ambito)
                        <tr>
                            <td class="fw-bold text-center" style="font-size: 1.1rem;">
                                {{ $ambito->orden }}
                            </td>
                            <td>
                                <div>
                                    <div class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">
                                        {{ $ambito->nombre }}
                                    </div>
                                    <div class="small text-muted">
                                        Slug: <code>{{ $ambito->slug }}</code>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($ambito->portada)
                                    <img src="{{ asset('portadas-marcojuridico/' . $ambito->portada) }}"
                                        class="img-thumbnail imagen-lista object-fit-contain" style="max-height: 60px; max-width: 120px;">
                                @else
                                    <span class="text-muted small">
                                        <i class="fa-regular fa-image me-1"></i>Sin portada específica
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('panel-marco-juridico-ambitos.edit', $ambito->id) }}"
                                            class="btn btn-outline-secondary" title="Editar elemento">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>

                                        @if (Auth::user()->validador)
                                            <form action="{{ route('panel-marco-juridico-ambitos.destroy', $ambito->id) }}"
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
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">Orden</th>
                        <th>Información del ámbito</th>
                        <th>Portada asignada</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-app-layout>
