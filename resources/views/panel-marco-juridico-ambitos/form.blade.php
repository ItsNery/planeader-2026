<x-app-layout>
    @section('title', isset($ambito->id) ? 'Editar Ámbito de Marco Jurídico' : 'Nuevo Ámbito de Marco Jurídico')

    <div class="container py-3">
        <div class="tarjeta-admin p-4 rounded-3 bg-white">
            <div class="form-header py-3 mb-4">
                <h2 class="fw-bold m-0">
                    {{ isset($ambito->id) ? 'Editar ámbito' : 'Crear nuevo ámbito' }}
                </h2>
                <p class="text-white mb-0 small opacity-75">
                    {{ isset($ambito->id) ? 'Modifique la información del ámbito y valide los cambios.' : 'Complete el formulario para registrar un nuevo ámbito.' }}
                </p>
            </div>
            
            <form
                action="{{ isset($ambito->id) ? route('panel-marco-juridico-ambitos.update', $ambito->id) : route('panel-marco-juridico-ambitos.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($ambito->id))
                    @method('PUT')
                @endif

                <div class="row g-4">
                    {{-- Información Principal --}}
                    <div class="col-lg-8 border-end-lg pe-lg-4">
                        <div class="custom-section-title mb-3">
                            <i class="fa-solid fa-folder-open text-primary-integration"></i> Datos Generales
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="fw-bold mb-1">Nombre del ámbito: *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                id="nombre" name="nombre" required
                                value="{{ old('nombre', $ambito->nombre ?? '') }}"
                                placeholder="Ej: Internacional, Nacional, Estatal, Municipal...">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="orden" class="fw-bold mb-1">Orden de aparición: *</label>
                            <select class="form-select @error('orden') is-invalid @enderror" id="orden"
                                name="orden" required>
                                <option value="" disabled
                                    {{ old('orden', $ambito->orden ?? '') == '' ? 'selected' : '' }}>
                                    Seleccione</option>
                                @foreach ($ordenesDisponibles as $ordenSeleccionado)
                                    <option value="{{ $ordenSeleccionado }}"
                                        {{ old('orden', $ambito->orden ?? '') == $ordenSeleccionado ? 'selected' : '' }}
                                        {{ in_array($ordenSeleccionado, $ordenesExistentes) && ($ambito->orden ?? '') != $ordenSeleccionado ? 'disabled' : '' }}>
                                        {{ $ordenSeleccionado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('orden')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted mt-1 d-block">Determina la posición/orden en que se mostrará este ámbito en la vista pública.</small>
                        </div>
                    </div>

                    {{-- Portada del Ámbito --}}
                    <div class="col-lg-4">
                        <div class="mb-4">
                            <div class="custom-section-title mb-3">
                                <i class="fa-solid fa-image text-primary-integration"></i> Imagen de Portada
                            </div>

                            <div class="file-upload-wrapper overflow-hidden position-relative @error('portada') is-invalid @enderror"
                                style="height: 150px;">
                                <div id="portada-placeholder"
                                    class="upload-content text-center {{ isset($ambito->portada) ? 'd-none' : '' }}">
                                    <i class="fa-solid fa-camera fs-2 mb-2"></i>
                                    <div class="fw-bold small">Subir Portada</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">(Opcional, máx. 6MB)</div>
                                </div>
                                <img src="{{ isset($ambito->portada) ? asset('portadas-marcojuridico/' . $ambito->portada) : '' }}"
                                    id="portadaPreview"
                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain {{ isset($ambito->portada) ? '' : 'd-none' }}">

                                <input type="file" name="portada" id="portada" accept="image/*"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                    style="cursor: pointer;"
                                    onchange="updateFileName(this, 'portadaNameDisplay', 'portadaPreview', 'portada-placeholder')">
                            </div>
                            @error('portada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small id="portadaNameDisplay"
                                class="d-block text-center mt-2 text-success fw-bold small"></small>
                            <small class="text-muted d-block text-center mt-1">Formatos permitidos: jpeg, png, svg, jpg, webp.</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('panel-marco-juridico-ambitos.index') }}"
                        class="btn btn-outline-secondary px-4">Cancelar</a>
                    <button type="submit" class="btn btn-custom-primary px-5 shadow-sm">
                        <i class="fa-solid fa-save me-2"></i>
                        {{ isset($ambito->id) ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateFileName(input, displayId, previewId = null, placeholderId = null) {
            const display = document.getElementById(displayId);
            const preview = previewId ? document.getElementById(previewId) : null;
            const placeholder = placeholderId ? document.getElementById(placeholderId) : null;

            if (input.files && input.files[0]) {
                if (display) display.innerText = input.files[0].name;

                if (preview && placeholder) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                        placeholder.classList.add('d-none');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        }
    </script>
</x-app-layout>
