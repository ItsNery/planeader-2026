<x-app-layout>
    @section('title', $programa->exists ? 'Editar Programa Estatal' : 'Subir Programa Estatal')
    <div class="container py-3">
        <div class="tarjeta-admin p-4 rounded-3 bg-white">
            <div class="form-header py-3 mb-4">
                <h2 class="fw-bold m-0">
                    {{ $programa->exists ? 'Editar Programa Estatal' : 'Subir Programa Estatal' }}
                </h2>
                <p class="text-white mb-0 small opacity-75">
                    {{ $programa->exists ? 'Modifique la información y valide los cambios.' : 'Complete el formulario para registrar un nuevo programa.' }}
                </p>
            </div>
            <form method="POST"|
                action="{{ $programa->exists ? route('panel-programas-estatales.update', $programa->id) : route('panel-programas-estatales.store') }}"
                novalidate enctype="multipart/form-data">
                @csrf
                @if ($programa->exists)
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
                                <label for="nombre" class="fw-bold mb-1">Nombre del programa: *</label>
                                <input name="nombre" type="text" id="nombre" placeholder="Ej: Programa de..."
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    value="{{ old('nombre', $programa->nombre ?? '') }}" required autofocus>
                                @error('nombre')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-tags text-primary-integration"></i> Detalles del documento
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="planestatal_id" class="fw-bold mb-1">Seleccione el periodo de gobierno:
                                        *</label>
                                    <select id="planestatal_id" name="planestatal_id"
                                        class="form-control @error('planestatal_id') is-invalid @enderror"
                                        @error('planestatal_id') autofocus @enderror required>
                                        <option value="" disabled selected>Seleccione</option>
                                        @foreach ($planes_estatales as $plan_estatal)
                                            <option value="{{ $plan_estatal->id }}"
                                                {{ old('planestatal_id', $programa->planestatal_id) == $plan_estatal->id ? 'selected' : '' }}>
                                                {{ $plan_estatal->periodo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('planestatal_id')
                                        <small class="invalid-feedback d-block">
                                            <strong>{{ $message }}</strong>
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-4">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-image text-primary-integration"></i> Portada: *
                            </div>
                            <div class="file-upload-wrapper overflow-hidden position-relative" style="height: 200px;">
                                {{-- Placeholder --}}
                                <div id="portada-placeholder"
                                    class="upload-content text-center {{ $programa->exists && $programa->portada ? 'd-none' : '' }}">
                                    <div class="upload-icon">
                                        <i class="fa-solid fa-camera"></i>
                                    </div>
                                    <div class="fw-bold text-dark">Subir Imagen</div>
                                    <div class="small text-muted mb-2">JPG, PNG, WEBP</div>
                                </div>

                                {{-- Preview Overlay --}}
                                <img id="preview-portada"
                                    src="{{ $programa->exists && $programa->portada ? asset('img/portadas-programas-estatales/' . $programa->portada) : '#' }}"
                                    alt="Vista previa"
                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain {{ $programa->exists && $programa->portada ? '' : 'd-none' }}"
                                    style="z-index: 1;">

                                <input type="file" id="portada" name="portada" accept="image/*"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                    style="z-index: 2; cursor: pointer;"
                                    onchange="updateFileName(this, 'portadaNameDisplay', 'preview-portada', 'portada-placeholder')">
                            </div>

                            <small id="portadaNameDisplay"
                                class="d-block text-center mt-2 text-success fw-bold"></small>

                            @error('portada')
                                <small class="text-danger d-block text-center mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-cloud-arrow-up text-primary-integration"></i> Archivo PDF
                            </div>
                            @if (isset($programa) && $programa->ruta_documento)
                                <div class="alert alert-light border shadow-sm mb-2 p-2">
                                    <small class="text-muted d-block text-uppercase"
                                        style="font-size: 0.7rem;">Documento
                                        Actual:</small>
                                    <a href="{{ asset('programasEstatales/' . $programa->ruta_documento) }}"
                                        target="_blank" class="fw-bold text-decoration-none text-truncate d-block">
                                        <i class="fa-solid fa-file-pdf text-danger me-1"></i> Ver PDF Actual
                                    </a>
                                </div>
                            @endif
                            <div class="file-upload-wrapper overflow-hidden position-relative" style="height: 150px;">
                                {{-- Placeholder --}}
                                <div id="pdf-placeholder" class="upload-content text-center">
                                    <div class="upload-icon">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </div>
                                    <div class="fw-bold text-dark">Subir PDF
                                        {{ isset($programa) ? 'nuevo' : '' }}</div>
                                    <div class="small text-muted mb-2">Máximo 10MB</div>
                                </div>

                                {{-- Filename Display Overlay --}}
                                <div id="pdf-filename-container"
                                    class="position-absolute top-0 start-0 w-100 h-100 d-none d-flex flex-column align-items-center justify-content-center bg-light"
                                    style="z-index: 1;">
                                    <i class="fa-solid fa-file-circle-check fs-2 text-success mb-2"></i>
                                    <small id="fileNameDisplay"
                                        class="fw-bold text-success px-3 text-center text-truncate w-100"></small>
                                    <div class="mt-2 small text-muted">Click para cambiar</div>
                                </div>

                                <input accept=".pdf" type="file" id="ruta_documento" name="ruta_documento"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                    style="z-index: 2; cursor: pointer;"
                                    onchange="updateFileName(this, 'fileNameDisplay', null, 'pdf-placeholder', 'pdf-filename-container')">
                            </div>
                            @error('ruta_documento')
                                <small class="text-danger d-block mt-1 text-center">{{ $message }}</small>
                            @enderror
                        </div>
                        @if (auth()->user()->validador == 1)
                            <div class="mb-3">
                                <div class="custom-section-title">
                                    <i class="fa-solid fa-eye text-primary-integration"></i> Visibilidad
                                </div>
                                <select
                                    class="form-select text-center fw-bold {{ old('publicado', $programa->publicado ?? 0) == 1 ? 'text-success border-success' : 'text-info border-info' }}"
                                    id="publicado" name="publicado" required onchange="updateVisibilityStyle(this)">
                                    <option value="1"
                                        {{ old('publicado', $programa->publicado ?? 0) == 1 ? 'selected' : '' }}>
                                        Publicado
                                    </option>
                                    <option value="0"
                                        {{ old('publicado', $programa->publicado ?? 0) == 0 ? 'selected' : '' }}>
                                        Borrador
                                    </option>
                                </select>
                                @error('publicado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-custom-primary shadow-sm py-2">
                                <i class="fa-solid fa-save me-2"></i>
                                {{ $programa->exists ? 'Guardar cambios' : 'Subir programa' }}
                            </button>
                            <a href="{{ route('panel-programas-estatales.index') }}"
                                class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
<script>
    function updateFileName(input, displayId, previewId = null, placeholderId = null, overlayId = null) {
        const display = document.getElementById(displayId);
        const preview = previewId ? document.getElementById(previewId) : null;
        const placeholder = placeholderId ? document.getElementById(placeholderId) : null;
        const overlay = overlayId ? document.getElementById(overlayId) : null;

        if (input.files && input.files[0]) {
            display.innerText = input.files[0].name;

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
        } else {
            display.innerText = '';
            if (overlay) {
                overlay.classList.add('d-none');
                overlay.classList.remove('d-flex');
            }
            if (placeholder) placeholder.classList.remove('d-none');
        }
    }

    function updateVisibilityStyle(select) {
        if (select.value == '1') {
            select.classList.remove('text-info', 'border-info');
            select.classList.add('text-success', 'border-success');
        } else {
            select.classList.remove('text-success', 'border-success');
            select.classList.add('text-info', 'border-info');
        }
    }
</script>
