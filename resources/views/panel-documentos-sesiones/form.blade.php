<x-app-layout>
    @section('title', isset($documento->id) ? 'Editar Documento de Sesión' : 'Nuevo Documento de Sesión')

    <div class="container py-3">
        <div class="tarjeta-admin p-4 rounded-3 bg-white">
            <div class="form-header py-3 mb-4">
                <h2 class="fw-bold m-0">
                    {{ isset($documento->id) ? 'Editar documento' : 'Subir documento' }}
                </h2>
                <p class="text-white mb-0 small opacity-75">
                    {{ isset($documento->id) ? 'Modifique la información y valide los cambios.' : 'Complete el formulario para registrar un nuevo documento de sesión.' }}
                </p>
            </div>
            <form
                action="{{ isset($documento->id) ? route('panel-documentos-sesiones.update', $documento->id) : route('panel-documentos-sesiones.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($documento->id))
                    @method('PUT')
                @endif

                <div class="row g-4">
                    {{-- Información Principal --}}
                    <div class="col-lg-8 border-end-lg pe-lg-4">
                        <div class="custom-section-title mb-3">
                            <i class="fa-solid fa-file-signature text-primary-integration"></i> Información
                            Principal
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="fw-bold mb-1">Nombre del documento: *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                id="nombre" name="nombre" required
                                value="{{ old('nombre', $documento->nombre ?? '') }}"
                                placeholder="Ej: Convocatoria Primera Sesión Ordinaria 2026">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sesion" class="fw-bold mb-1">Sesión: *</label>
                            <input type="text" class="form-control @error('sesion') is-invalid @enderror"
                                id="sesion" name="sesion" required
                                value="{{ old('sesion', $documento->sesion ?? '') }}"
                                placeholder="Ej: Primera Sesión Ordinaria 2026">
                            @error('sesion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted mt-1 d-block">Nombre de la sesión a la que pertenece este
                                documento.</small>
                        </div>

                        <div class="mb-3">
                            <label for="orden" class="fw-bold mb-1">Orden de aparición: *</label>
                            <select class="form-select @error('orden') is-invalid @enderror" id="orden"
                                name="orden">
                                <option value="" disabled
                                    {{ old('orden', $documento->orden ?? '') == '' ? 'selected' : '' }}>
                                    Seleccione</option>
                                @foreach ($ordenesDisponibles as $ordenSeleccionado)
                                    <option value="{{ $ordenSeleccionado }}"
                                        {{ old('orden', $documento->orden ?? '') == $ordenSeleccionado ? 'selected' : '' }}
                                        {{ in_array($ordenSeleccionado, $ordenesExistentes) && ($documento->orden ?? '') != $ordenSeleccionado ? 'disabled' : '' }}>
                                        {{ $ordenSeleccionado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('orden')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted mt-1 d-block">Determina la posición en la vista
                                pública.</small>
                        </div>
                    </div>

                    {{-- Archivos y Visibilidad --}}
                    <div class="col-lg-4">
                        <div class="mb-4">
                            <div class="custom-section-title mb-3">
                                <i class="fa-solid fa-cloud-arrow-up text-primary-integration"></i> Archivo
                            </div>

                            @if (isset($documento->ruta_documento))
                                <div class="alert alert-light border shadow-sm p-3 d-flex align-items-center mb-3">
                                    <i class="fa-regular fa-file-lines text-danger fs-3 me-3"></i>
                                    <div class="overflow-hidden">
                                        <small class="text-muted d-block text-uppercase"
                                            style="font-size: 0.65rem;">Actual:</small>
                                        <a href="{{ asset('documentos/sesiones/' . $documento->ruta_documento) }}"
                                            target="_blank"
                                            class="fw-bold text-dark text-decoration-none text-truncate d-block">
                                            Ver PDF cargado
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="file-upload-wrapper overflow-hidden position-relative @error('ruta_documento') is-invalid @enderror"
                                style="height: 120px;">
                                <div id="doc-placeholder" class="upload-content text-center">
                                    <i class="fa-regular fa-file-lines fs-2 mb-2"></i>
                                    <div class="fw-bold small">Subir documento</div>
                                </div>
                                <div id="doc-filename-container"
                                    class="position-absolute top-0 start-0 w-100 h-100 d-none d-flex flex-column align-items-center justify-content-center bg-light">
                                    <i class="fa-solid fa-file-circle-check text-success fs-3 mb-1"></i>
                                    <small id="docNameDisplay"
                                        class="fw-bold text-success px-2 text-center text-truncate w-100"></small>
                                </div>
                                <input type="file" name="ruta_documento" id="ruta_documento"
                                    accept=".pdf,.doc,.docx,.ppt,.pptx,.webp,.jpg,.jpeg,.png,.svg"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                    style="cursor: pointer;"
                                    onchange="updateFileName(this, 'docNameDisplay', null, 'doc-placeholder', 'doc-filename-container')">
                            </div>
                            @error('ruta_documento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block text-center mt-1">
                                PDF, DOC, DOCX, PPT, WEBP, JPG, JPEG, PNG, SVG (50MB máx)
                            </small>
                        </div>

                        <div class="mb-4">
                            <div class="custom-section-title mb-3">
                                <i class="fa-solid fa-image text-primary-integration"></i> Portada (opcional)
                            </div>

                            <div class="file-upload-wrapper overflow-hidden position-relative @error('portada') is-invalid @enderror"
                                style="height: 120px;">
                                <div id="img-placeholder"
                                    class="upload-content text-center {{ isset($documento->portada) ? 'd-none' : '' }}">
                                    <i class="fa-solid fa-camera fs-2 mb-2"></i>
                                    <div class="fw-bold small">Subir Portada</div>
                                </div>
                                <img src="{{ isset($documento->portada) ? asset('imagen/sesiones/' . $documento->portada) : '' }}"
                                    id="imgPreview"
                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain {{ isset($documento->portada) ? '' : 'd-none' }}">

                                <input type="file" name="portada" id="portada" accept="image/*"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                    style="cursor: pointer;"
                                    onchange="updateFileName(this, 'imgNameDisplay', 'imgPreview', 'img-placeholder')">
                            </div>
                            @error('portada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small id="imgNameDisplay"
                                class="d-block text-center mt-2 text-success fw-bold small"></small>
                        </div>

                        <div class="mb-3">
                            <div class="custom-section-title mb-3">
                                <i class="fa-solid fa-eye text-primary-integration"></i> Visibilidad
                            </div>
                            <select class="form-select @error('publicado') is-invalid @enderror" id="publicado"
                                name="publicado">
                                <option value="1"
                                    {{ old('publicado', $documento->publicado ?? '') == '1' ? 'selected' : '' }}>
                                    Publicado</option>
                                <option value="0"
                                    {{ old('publicado', $documento->publicado ?? '0') == '0' ? 'selected' : '' }}>
                                    Borrador</option>
                            </select>
                            @error('publicado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('panel-documentos-sesiones.index') }}"
                        class="btn btn-outline-secondary px-4">Cancelar</a>
                    <button type="submit" class="btn btn-custom-primary px-5 shadow-sm">
                        <i class="fa-solid fa-save me-2"></i>
                        {{ isset($documento->id) ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateFileName(input, displayId, previewId = null, placeholderId = null, overlayId = null) {
            const display = document.getElementById(displayId);
            const preview = previewId ? document.getElementById(previewId) : null;
            const placeholder = placeholderId ? document.getElementById(placeholderId) : null;
            const overlay = overlayId ? document.getElementById(overlayId) : null;

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
                } else if (overlay && placeholder) {
                    overlay.classList.remove('d-none');
                    overlay.classList.add('d-flex');
                    placeholder.classList.add('d-none');
                }
            }
        }
    </script>
</x-app-layout>
