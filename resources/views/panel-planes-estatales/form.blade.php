<x-app-layout>
    @section('title', isset($planesEst) ? 'Editar Documento' : 'Subir Documento')

    <div class="container py-3">

        {{-- CONTENEDOR PRINCIPAL: Estilo idéntico a la tarjeta del índice --}}
        <div class="tarjeta-admin p-4 rounded-3">

            {{-- 1. CABECERA INSTITUCIONAL --}}
            <div class="form-header py-3 mb-4">
                <h2 class="fw-bold m-0">
                    {{ isset($planesEst) ? 'Editar documento' : 'Subir documento' }}
                </h2>
                <p class="text-white mb-0 small opacity-75">
                    {{ isset($planesEst) ? 'Modifique la información y valide los cambios.' : 'Complete el formulario para registrar un nuevo documento.' }}
                </p>
            </div>

            <form
                action="{{ isset($planesEst) ? route('panel-planes-estatales.update', $planesEst->id) : route('panel-planes-estatales.store') }}"
                method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @if (isset($planesEst))
                    @method('PUT')
                @endif

                <div class="row g-4">

                    {{-- COLUMNA IZQUIERDA: DATOS (70%) --}}
                    <div class="col-lg-8 border-end-lg pe-lg-4">

                        {{-- Nombre --}}
                        <div class="mb-4">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-file-signature text-primary-integration"></i> Información
                                Principal
                            </div>

                            <div class="mb-3">
                                <label for="nombre" class="fw-bold mb-1">Nombre del documento: *</label>
                                <input name="nombre" type="text" id="nombre"
                                    placeholder="Ej: Plan Estatal de Desarrollo..."
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    value="{{ old('nombre', $planesEst->nombre ?? '') }}" required autofocus>
                                @error('nombre')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="periodo" class="fw-bold mb-1">Periodo: *</label>
                                    <input type="text" id="periodo" name="periodo" placeholder="YYYY-YYYY o YYYY"
                                        class="form-control @error('periodo') is-invalid @enderror"
                                        title="Formato válido: YYYY o YYYY-YYYY" pattern="\d{4}(-\d{4})?"
                                        value="{{ old('periodo', $planesEst->periodo ?? date('Y')) }}">
                                    @error('periodo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Clasificación --}}
                        <div class="mb-3">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-tags text-primary-integration"></i> Detalles del Archivo
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="gobernador" class="fw-bold mb-1"> Nombre del gobernador: *</label>
                                    <input name="gobernador" type="text" id="gobernador" placeholder="Jane Doe"
                                        class="form-control @error('gobernador') is-invalid @enderror"
                                        value="{{ old('gobernador', $planesEst->gobernador ?? '') }}"
                                        @error('gobernador') autofocus @enderror autofocus required>
                                    @error('gobernador')
                                        <small class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </small>
                                    @enderror
                                </div>
                                @if (isset($planesEst->anexos) && $planesEst->anexos->count() > 0)
                                    <div class="mb-4">
                                        <div class="custom-section-title">
                                            <i class="fa-solid fa-folder-tree text-primary-integration"></i> Recursos
                                            Relacionados
                                        </div>
                                        <div
                                            class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between shadow-sm">
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark">Anexos del Documento</h6>
                                                <p class="small text-muted mb-0">Gestione los archivos adicionales
                                                    vinculados a este plan.</p>
                                            </div>
                                            <a href="{{ route('panel-planes-estatales-anexos.index', $planesEst->id) }}"
                                                class="btn btn-custom-primary btn-sm px-3 py-2 shadow-sm">
                                                <i class="fa-solid fa-paperclip me-1"></i> Gestionar Anexos
                                            </a>
                                        </div>
                                    </div>
                                    @else
                                    <a href="{{ route('panel-planes-estatales-anexos.index', $planesEst->id) }}"
                                                class="btn btn-custom-primary btn-sm px-3 py-2 shadow-sm">
                                                <i class="fa-solid fa-paperclip me-1"></i> Gestionar Anexos
                                            </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- COLUMNA DERECHA: ACCIONES (30%) --}}
                    <div class="col-lg-4">

                        {{-- Zona de Carga --}}
                        <div class="mb-4">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-cloud-arrow-up text-primary-integration"></i> Archivo PDF
                            </div>

                            @if (isset($planesEst))
                                <div class="alert alert-light border shadow-sm mb-2 p-2">
                                    <small class="text-muted d-block text-uppercase"
                                        style="font-size: 0.7rem;">Documento Actual:</small>
                                    <a href="{{ asset('planesest/' . $planesEst->ruta_documento) }}" target="_blank"
                                        class="fw-bold text-decoration-none text-truncate d-block">
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
                                        {{ isset($planesEst) ? 'nuevo' : '' }}</div>
                                    <div class="small text-muted mb-2">Máximo 100MB</div>
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
                        <div class="mb-4">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-image text-primary-integration"></i> Portada
                            </div>
                            <div class="file-upload-wrapper overflow-hidden position-relative" style="height: 150px;">
                                <div id="portada-placeholder"
                                    class="upload-content text-center {{ isset($planesEst) && $planesEst->portada ? 'd-none' : '' }}">
                                    <div class="upload-icon">
                                        <i class="fa-solid fa-camera"></i>
                                    </div>
                                    <div class="fw-bold text-dark">Subir Portada</div>
                                    <div class="small text-muted mb-2">JPG, PNG (6MB máx)</div>
                                </div>

                                <img src="{{ isset($planesEst) && $planesEst->portada ? asset('portadaplanesest/' . $planesEst->portada) : '' }}"
                                    id="portadaPreview"
                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain {{ isset($planesEst) && $planesEst->portada ? '' : 'd-none' }}"
                                    style="z-index: 1;">

                                <input accept="image/*" type="file" id="portada" name="portada"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                    style="z-index: 2; cursor: pointer;"
                                    onchange="updateFileName(this, 'portadaNameDisplay', 'portadaPreview', 'portada-placeholder')">
                            </div>
                            <small id="portadaNameDisplay" class="d-none"></small>
                            @error('portada')
                                <small class="text-danger d-block mt-1 text-center">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Visibilidad (Solo Validador) --}}
                        @if (auth()->user()->validador == 1)
                            <div class="mb-4">
                                <div class="custom-section-title">
                                    <i class="fa-solid fa-eye text-primary-integration"></i> Visibilidad
                                </div>
                                <select
                                    class="form-select text-center fw-bold {{ old('publicado', $planesEst->publicado ?? 0) == 1 ? 'text-success border-success' : 'text-warning border-warning' }}"
                                    id="publicado" name="publicado" onchange="updateVisibilityStyle(this)">
                                    <option value="1" class="text-dark"
                                        {{ old('publicado', $planesEst->publicado ?? 0) == 1 ? 'selected' : '' }}>
                                        Publicado
                                    </option>
                                    <option value="0" class="text-dark"
                                        {{ old('publicado', $planesEst->publicado ?? 0) == 0 ? 'selected' : '' }}>
                                        Borrador
                                    </option>
                                </select>
                            </div>
                        @endif

                        <hr class="text-muted">

                        {{-- Botones de Acción --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-custom-primary shadow-sm py-2">
                                <i class="fa-solid fa-save me-2"></i>
                                {{ isset($planesEst) ? 'Guardar cambios' : 'Subir Documento' }}
                            </button>
                            <a href="{{ route('panel-planes-estatales.index') }}" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
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
            select.classList.remove('text-warning', 'border-warning');
            select.classList.add('text-success', 'border-success');
        } else {
            select.classList.remove('text-success', 'border-success');
            select.classList.add('text-warning', 'border-warning');
        }
    }
</script>
