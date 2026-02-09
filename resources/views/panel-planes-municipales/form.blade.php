<x-app-layout>
    @section('title', $planMun->exists ? 'Editar Documento' : 'Subir Documento')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.5/dist/css/tom-select.css" rel="stylesheet">

    <div class="tarjeta-admin p-4 rounded-3">
        <div class="form-header py-3 mb-4">
            <h2 class="fw-bold m-0">
                {{ $planMun->exists ? 'Editar documento' : 'Subir documento' }}
            </h2>
            <p class="text-white mb-0 small opacity-75">
                {{ $planMun->exists ? 'Modifique la información y valide los cambios.' : 'Complete el formulario para registrar un nuevo documento.' }}
            </p>
        </div>
        <form
            action="{{ $planMun->exists ? route('panel-planes-municipales.update', $planMun->id) : route('panel-planes-municipales.store') }}"
            method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @if ($planMun->exists)
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
                            <label for="nombre" class="fw-bold mb-1">Nombre del plan: *</label>
                            <input name="nombre" type="text" id="nombre"
                                placeholder="Ej: Plan Municipal de Desarrollo..."
                                class="form-control @error('nombre') is-invalid @enderror"
                                value="{{ old('nombre', $planMun->nombre ?? '') }}" required autofocus>
                            @error('nombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="periodo" class="fw-bold mb-1">Periodo: *</label>
                            <input type="text" id="periodo" name="periodo" placeholder="AAAA-AAAA"
                                pattern="\d{4}(-\d{4})?" title="Formato válido: YYYY o YYYY-YYYY"
                                class="form-control @error('periodo') is-invalid @enderror" value="{{ old('periodo', $planMun->periodo ?? '') }}"
                                @error('periodo') autofocus @enderror autofocus required>
                            @error('periodo')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="custom-section-title">
                            <i class="fa-solid fa-tags text-primary-integration"></i>
                            Detalles del archivo
                        </div>
                        <div class="mb-3">
                            <label for="municipio_id" class="fw-bold mb-1">Seleccione un municipio: *</label>
                            <select id="municipio_id" name="municipio_id"
                                class="form-control @error('municipio_id') is-invalid @enderror"
                                @error('municipio_id') autofocus @enderror required>
                                <option value="" disabled selected>Seleccione</option>
                                @foreach ($municipios as $municipio)
                                    <option value="{{ $municipio->id }}"
                                        {{ old('municipio_id', $planMun->municipio_id) == $municipio->id ? 'selected' : '' }}>
                                        {{ $municipio->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('municipio_id')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-4">
                        <div class="custom-section-title">
                            <i class="fa-solid fa-cloud-arrow-up text-primary-integration"></i> Archivo PDF
                        </div>

                        @if (isset($planMun) && $planMun->ruta_documento)
                            <div class="alert alert-light border shadow-sm mb-2 p-2">
                                <small class="text-muted d-block text-uppercase" style="font-size: 0.7rem;">Documento
                                    Actual:</small>
                                <a href="{{ asset('planesmun/' . $planMun->ruta_documento) }}" target="_blank"
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
                                <div class="small text-muted mb-2">Máximo 50MB</div>
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
                        <div class="mb-4">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-eye text-primary-integration"></i> Visibilidad
                            </div>
                            <select
                                class="form-select text-center fw-bold {{ old('publicado', $planMun->publicado ?? 0) == 1 ? 'text-success border-success' : 'text-info border-info' }}"
                                id="publicado" name="publicado" onchange="updateVisibilityStyle(this)">
                                <option value="1" class="text-dark"
                                    {{ old('publicado', $planMun->publicado ?? 0) == 1 ? 'selected' : '' }}>
                                    Publicado
                                </option>
                                <option value="0" class="text-dark"
                                    {{ old('publicado', $planMun->publicado ?? 0) == 0 ? 'selected' : '' }}>
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
                            {{ $planMun->exists ? 'Guardar cambios' : 'Subir Documento' }}
                        </button>
                        <a href="{{ route('panel-planes-municipales.index') }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </form>
        {{-- <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Subir plan</h2>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i>
                                Nombre del plan: *
                            </div>
                            <input name="nombre" type="text" id="nombre"
                                placeholder="Plan Municipal de Desarrollo de.."
                                class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}"
                                @error('nombre') autofocus @enderror autofocus required>
                            @error('nombre')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="custom-section-title"><i class="fa-solid fa-calendar-check"></i>
                                Periodo: *
                            </div>
                            <input type="text" id="periodo" name="periodo" placeholder="AAAA-AAAA"
                                pattern="\d{4}(-\d{4})?" title="Formato válido: YYYY o YYYY-YYYY"
                                class="form-control @error('periodo') is-invalid @enderror" value="{{ old('periodo') }}"
                                @error('periodo') autofocus @enderror autofocus required>
                            @error('periodo')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-file-pdf"></i>
                        Cargue el archivo: *
                    </div>
                    <div class="input-group">
                        <input accept=".pdf" type="file" id="ruta_documento" name="ruta_documento"
                            class="form-control @error('ruta_documento') is-invalid @enderror"
                            @error('ruta_documento') autofocus @enderror required>
                        <label class="input-group-text" for="ruta_documento">Seleccionar archivo</label>
                    </div>
                    @error('ruta_documento')
                        <small class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-building"></i>
                        Seleccione un municipio: *
                    </div>
                    <select id="municipio_id" name="municipio_id"
                        class="form-control @error('municipio_id') is-invalid @enderror"
                        @error('municipio_id') autofocus @enderror required>
                        <option value="" disabled selected>Seleccione</option>
                        @foreach ($municipios as $municipio)
                            <option value="{{ $municipio->id }}">{{ $municipio->nombre }}</option>
                        @endforeach
                    </select>
                    @error('municipio_id')
                        <small class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                @if (auth()->user()->validador == 1)
                    <div class="mb-3">
                        <div class="custom-section-title"><i class="fa-solid fa-check-circle"></i>
                            ¿Publicado? *
                        </div>
                        <select class="form-control @error('publicado') is-invalid @enderror" id="publicado"
                            name="publicado" required>
                            <option value="" disabled selected>Seleccione</option>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                        @error('publicado')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @endif
                <div class="mb-3">
                    <div class="col-md-12 d-flex justify-content-evenly">
                        <a href="{{ route('panel-planes-municipales.index') }}" class="btn btn-secondary w-100">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-success w-100">
                            Subir
                        </button>
                    </div>
                </div>
            </form>
        </div> --}}
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.5/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect("#municipio_id", {
        create: true,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
</script>
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
