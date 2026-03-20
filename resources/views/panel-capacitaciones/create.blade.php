<x-app-layout>
    @section('title', 'Capacitaciones municipales: Subir')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subir capacitación municipal') }}
        </h2>
    </x-slot>
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
    <div class="tarjeta-admin container">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Subir capacitación</h2>
            </div>
            <form action="{{ route('capacitaciones.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12 col-md-8 mb-3">
                            <label for="nombre" class="custom-section-title">
                                <i class="fa-solid fa-file-signature"></i>
                                Nombre de la Capacitación: *
                            </label>
                            <input name="nombre" type="text" id="nombre"
                                placeholder="Programa de Capacitación..."
                                class="w-100 form-control @error('nombre') is-invalid @enderror"
                                value="{{ old('nombre') }}" @error('nombre') autofocus @enderror autofocus required>
                            @error('nombre')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <label for="imagen_programa" class="custom-section-title">
                                <i class="fa-solid fa-file-signature"></i>
                                Imagen del Programa (Flyer): *
                            </label>
                            <input class="form-control @error('imagen_programa') is-invalid @enderror" type="file"
                                id="imagen_programa" name="imagen_programa" required>
                            <div id="imageHelp" class="form-text">
                                Formatos aceptados: JPG, PNG, WEBP. Tamaño máximo: 2MB.
                            </div>
                            @error('imagen_programa')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12 d-flex justify-content-evenly">
                    <a href="{{ route('capacitaciones.index') }}" class="btn btn-secondary mb-3 w-100">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success mb-3 w-100">
                         Guardar Capacitación
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "pagingType": "simple_numbers",
            "order": [],
            "language": {
                "search": "Buscar:",
                "lengthMenu": "Mostrar _MENU_ entradas",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                }
            }
        });
    });
</script>
