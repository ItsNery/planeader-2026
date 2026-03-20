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
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Editar capacitación</h2>
            </div>
            <form action="{{ route('capacitaciones.update', $capacitacione) }}" method="POST"
                enctype="multipart/form-data" id="form-update-capacitacion">
                @csrf
                @method('PUT')
                <div class="mb-3 row">
                    <div class="col-12">
                        <div class="custom-section-title">
                            1. Datos Generales
                        </div>
                    </div>
                    <div class="col-12 col-md-8 my-2">
                        <label for="nombre" class="custom-section-title">
                            Nombre de la Capacitación: *
                        </label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                            name="nombre" value="{{ old('nombre', $capacitacione->nombre) }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-4 my-2">
                        <label for="imagen_programa" class="custom-section-title">
                            Cambiar Imagen del Programa
                            (Opcional)
                        </label>
                        <input class="form-control @error('imagen_programa') is-invalid @enderror" type="file"
                            id="imagen_programa" name="imagen_programa">
                        @error('imagen_programa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Sube una nueva imagen solo si deseas reemplazar la actual.</div>
                        <div>
                            <label class="form-label">
                                Imagen Actual:
                            </label><br>
                            <img src="{{ asset('documentos/capacitacion-municipal/' . $capacitacione->imagen_programa) }}"
                                alt="Imagen actual" class="img-thumbnail" style="max-width: 250px;">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="custom-section-title">
                            2. Gestionar Documentos Existentes
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card-body">
                            @if ($capacitacione->documentos->isNotEmpty())
                                <ul class="list-group">
                                    @foreach ($capacitacione->documentos as $documento)
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <div>
                                                <i class="fas fa-file-alt me-2"></i>
                                                {{ $documento->nombre_display }}
                                                <small class="text-muted fst-italic">- Día:
                                                    {{ $documento->dia_agrupador ?? 'General' }}</small>
                                            </div>
                                            <div>
                                                <a href="{{ asset('documentos/capacitacion-municipal/' . $documento->ruta_archivo) }}"
                                                    class="btn btn-sm btn-outline-success" target="_blank">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                {{-- Formulario individual para eliminar cada documento --}}
                                                <a href="{{ route('documentos.destroy', $documento) }}"
                                                    class="btn btn-sm btn-outline-danger btn-delete-documento"
                                                    data-nombre="{{ $documento->nombre_display }}">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </a>
                                            </div>

                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-center text-muted">Aún no se han subido documentos para esta
                                    capacitación.
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 my-2">
                        <div class="custom-section-title">
                            3. Añadir Nuevos Documentos
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card-body">
                            <div id="contenedor-nuevos-documentos">
                                {{-- Este es el bloque que se clonará --}}
                                <div class="documento-input-group mb-3 p-3 border rounded">
                                    <div class="mb-2">
                                        <label class="form-label">Nombre del Documento</label>
                                        <input type="text" name="nuevos_documentos[0][nombre]" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Archivo</label>
                                        <input type="file" name="nuevos_documentos[0][archivo]" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Agrupar por Día (opcional)</label>
                                        <select name="nuevos_documentos[0][dia]" class="form-select">
                                            <option value="">Sin día (General)</option>
                                            <option value="1">Día 1</option>
                                            <option value="2">Día 2</option>
                                            <option value="3">Día 3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="btn-agregar-documento" class="btn btn-outline-success mt-2">
                                <i class="fas fa-plus"></i> Añadir otro documento
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 my-2">
                        <a href="{{ route('capacitaciones.index') }}" class="btn btn-secondary w-100">
                            Cancelar
                        </a>
                    </div>
                    <div class="col-md-6 my-2">
                        <button type="submit" form="form-update-capacitacion" class="btn btn-success w-100">
                            Actualizar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <form id="form-delete-documento" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnAgregar = document.getElementById('btn-agregar-documento');
        const contenedor = document.getElementById('contenedor-nuevos-documentos');
        let index = 1;

        btnAgregar.addEventListener('click', function() {
            // Clonamos el primer grupo de inputs
            const nuevoGrupo = contenedor.children[0].cloneNode(true);

            // Limpiamos los valores de los inputs clonados
            nuevoGrupo.querySelector('input[type="text"]').value = '';
            nuevoGrupo.querySelector('input[type="file"]').value = '';
            nuevoGrupo.querySelector('select').selectedIndex = 0;

            // Actualizamos los atributos 'name' con el nuevo índice
            nuevoGrupo.querySelector('input[type="text"]').name = `nuevos_documentos[${index}][nombre]`;
            nuevoGrupo.querySelector('input[type="file"]').name =
                `nuevos_documentos[${index}][archivo]`;
            nuevoGrupo.querySelector('select').name = `nuevos_documentos[${index}][dia]`;

            // Añadimos el nuevo grupo al contenedor
            contenedor.appendChild(nuevoGrupo);

            index++;
        });
        // AÑADE ESTE NUEVO BLOQUE DE CÓDIGO
        const deleteButtons = document.querySelectorAll('.btn-delete-documento');
        const deleteForm = document.getElementById('form-delete-documento');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                // Prevenimos que el enlace navegue a la URL
                event.preventDefault();

                const nombreDocumento = this.dataset.nombre;
                const deleteUrl = this.href;

                // Preguntamos al usuario si está seguro
                if (confirm(
                        `¿Estás seguro de que quieres eliminar el documento "${nombreDocumento}"?`
                    )) {
                    // Configuramos la acción del formulario fantasma
                    deleteForm.action = deleteUrl;

                    // Enviamos el formulario fantasma
                    deleteForm.submit();
                }
            });
        });
    });
</script>
