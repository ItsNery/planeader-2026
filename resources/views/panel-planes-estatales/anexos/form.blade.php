<x-app-layout>
    @section('title', $anexo->exists ? 'Editar Documento' : 'Subir Documento')

    <div class="tarjeta-admin p-4 rounded-3">
        <div class="form-header py-3 mb-4">
            <h2 class="fw-bold m-0">
                {{ $anexo->exists ? 'Editar documento' : 'Subir documento' }}
            </h2>
            <p class="text-white mb-0 small opacity-75">
                {{ $anexo->exists ? 'Modifique la información y valide los cambios.' : 'Complete el formulario para registrar un nuevo documento.' }}
            </p>
        </div>
        <form
            action="{{ $anexo->exists ? route('panel-planes-estatales-anexos.update', [$planEstatal->id, $anexo->id]) : route('panel-planes-estatales-anexos.store', $planEstatal->id) }}"
            method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @if ($anexo->exists)
                @method('PUT')
            @endif
            <div class="row g-4">
                <div class="col-lg-8 border-end-lg pe-lg-4">
                    <div class="mb-4">
                        <div class="custom-section-title">
                            <i class="fa-solid fa-file-signature text-primary-integration"></i> Información
                            Principal
                        </div>

                        <div class="mb-3">
                            <label for="titulo" class="fw-bold mb-1">Título del anexo: *</label>
                            <input name="titulo" type="text" id="titulo" placeholder="Ej: Anexo 1: Nombre..."
                                class="form-control @error('titulo') is-invalid @enderror"
                                value="{{ old('titulo', $anexo->titulo ?? '') }}" required autofocus>
                            @error('titulo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="orden" class="fw-bold mb-1">Orden de aparición: *</label>
                            <select class="form-select @error('orden') is-invalid @enderror" id="orden"
                                name="orden">
                                <option value="" disabled selected>Seleccione</option>
                                @foreach ($ordenesDisponibles as $ordenSeleccionado)
                                    <option value="{{ $ordenSeleccionado }}"
                                        {{ old('orden', $anexo->orden ?? '') == $ordenSeleccionado ? 'selected' : '' }}
                                        {{ in_array($ordenSeleccionado, $ordenesExistentes) ? 'disabled' : '' }}>
                                        {{ $ordenSeleccionado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('orden')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-tags text-primary-integration"></i> Detalles del Archivo
                            </div>
                            <label class="fw-bold mb-2 d-block">Tipo de anexo: *</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="es_enlace" id="tipo_archivo"
                                        value="0"
                                        {{ old('es_enlace', $anexo->es_enlace ?? 0) == 0 ? 'checked' : '' }}
                                        onchange="toggleAnexoType(0)">
                                    <label class="form-check-label" for="tipo_archivo">
                                        Archivo (PDF)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="es_enlace" id="tipo_enlace"
                                        value="1"
                                        {{ old('es_enlace', $anexo->es_enlace ?? 0) == 1 ? 'checked' : '' }}
                                        onchange="toggleAnexoType(1)">
                                    <label class="form-check-label" for="tipo_enlace">
                                        Enlace (URL)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="container-archivo" class="mb-3"
                            style="{{ old('es_enlace', $anexo->es_enlace ?? 0) == 1 ? 'display: none;' : '' }}">
                            <label for="ruta_documento_archivo" class="fw-bold mb-1">Documento (PDF):
                                {{ !$anexo->exists ? '*' : '' }}</label>
                            <input type="file" name="ruta_documento_archivo" id="ruta_documento_archivo"
                                accept="application/pdf"
                                class="form-control @error('ruta_documento_archivo') is-invalid @enderror">
                            @if ($anexo->exists && !$anexo->es_enlace)
                                <small class="text-muted">Actual: {{ $anexo->ruta_documento }}</small>
                            @endif
                            @error('ruta_documento_archivo')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div id="container-enlace" class="mb-3"
                            style="{{ old('es_enlace', $anexo->es_enlace ?? 0) == 0 ? 'display: none;' : '' }}">
                            <label for="ruta_documento_enlace" class="fw-bold mb-1">Enlace (URL): *</label>
                            <input type="url" name="ruta_documento_enlace" id="ruta_documento_enlace"
                                value="{{ old('ruta_documento_enlace', $anexo->es_enlace ?? false ? $anexo->ruta_documento : '') }}"
                                class="form-control @error('ruta_documento_enlace') is-invalid @enderror"
                                placeholder="https://ejemplo.com/documento.pdf">
                            @error('ruta_documento_enlace')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="mb-4">
                        <div class="custom-section-title">
                            <i class="fa-solid fa-image text-primary-integration"></i> Portada
                        </div>
                        <div class="file-upload-wrapper overflow-hidden position-relative" style="height: 200px;">
                            {{-- Placeholder --}}
                            <div id="portada-placeholder"
                                class="upload-content text-center {{ $anexo->exists && $anexo->imagen ? 'd-none' : '' }}">
                                <div class="upload-icon">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                                <div class="fw-bold text-dark">Subir Imagen</div>
                                <div class="small text-muted mb-2">JPG, PNG, WEBP</div>
                            </div>

                            {{-- Preview Overlay --}}
                            <img id="preview-portada"
                                src="{{ $anexo->exists && $anexo->imagen ? asset('img/ped/anexos/' . $anexo->imagen) : '#' }}"
                                alt="Vista previa"
                                class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain {{ $anexo->exists && $anexo->imagen ? '' : 'd-none' }}"
                                style="z-index: 1;">

                            <input type="file" id="imagen" name="imagen" accept="image/*"
                                class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                style="z-index: 2; cursor: pointer;"
                                onchange="updateFileName(this, 'portadaNameDisplay', 'preview-portada', 'portada-placeholder')">
                        </div>

                        <small id="portadaNameDisplay" class="d-block text-center mt-2 text-success fw-bold"></small>

                        @error('imagen')
                            <small class="text-danger d-block text-center mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                    @if (auth()->user()->validador == 1)
                        <div class="mb-4">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-eye text-primary-integration"></i> Visibilidad
                            </div>
                            <select
                                class="form-select text-center fw-bold {{ old('publicado', $anexo->publicado ?? 0) == 1 ? 'text-success border-success' : 'text-warning border-warning' }}"
                                name="publicado" onchange="updateVisibilityStyle(this)">
                                <option value="1"
                                    {{ old('publicado', $anexo->publicado ?? 0) == 1 ? 'selected' : '' }}>
                                    Publicado</option>
                                <option value="0"
                                    {{ old('publicado', $anexo->publicado ?? 0) == 0 ? 'selected' : '' }}>
                                    Borrador</option>
                            </select>
                            @error('publicado')
                                <small class="text-danger d-block text-center mt-1">{{ $message }}</small>
                            @enderror
                            <p class="text-muted small mt-1">
                                Defina si el anexo será visible para el público general.
                            </p>
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-custom-primary py-2 fw-bold">
                            <i class="fa-solid fa-save me-2"></i>
                            {{ $anexo->exists ? 'Guardar cambios' : 'Subir Documento' }}
                        </button>
                        <a href="{{ route('panel-planes-estatales-anexos.index', $planEstatal->id) }}"
                            class="btn btn-outline-secondary py-2 fw-bold">
                            Regresar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function toggleAnexoType(type) {
            const containerArchivo = document.getElementById('container-archivo');
            const containerEnlace = document.getElementById('container-enlace');
            const inputArchivo = document.getElementById('ruta_documento_archivo');
            const inputEnlace = document.getElementById('ruta_documento_enlace');

            if (type === 1) { // Enlace
                containerArchivo.style.display = 'none';
                containerEnlace.style.display = 'block';
                inputEnlace.required = true;
                inputArchivo.required = false;
            } else { // Archivo
                containerArchivo.style.display = 'block';
                containerEnlace.style.display = 'none';
                inputEnlace.required = false;
                // Only required on create, but we handle it via backend and HTML5 if needed
            }
        }

        function updateFileName(input, displayId, previewId, placeholderId) {
            const display = document.getElementById(displayId);
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                }
                reader.readAsDataURL(input.files[0]);
                display.textContent = input.files[0].name;
            }
        }
    </script>
</x-app-layout>
