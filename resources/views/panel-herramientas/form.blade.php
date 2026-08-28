<x-app-layout>
    @section('title',
        $herramienta->exists
        ? 'Herramientas de Planeación: Editar Documento'
        : 'Herramientas de
        Planeación: Subir Documento')
        <div class="tarjeta-admin p-4 rounded-3">
            <div class="form-header py-3 mb-4">
                <h2 class="fw-bold m-0">
                    {{ $herramienta->exists ? 'Editar documento' : 'Subir documento' }}
                </h2>
                <p class="text-white mb-0 small opacity-75">
                    {{ $herramienta->exists ? 'Modifique la información y valide los cambios.' : 'Complete el formulario para registrar un nuevo documento.' }}
                </p>
            </div>
            <form
                action="{{ $herramienta->exists ? route('panel-herramientas.update', $herramienta->id) : route('panel-herramientas.store') }}"
                method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @if ($herramienta->exists)
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
                                <label for="titulo" class="fw-bold mb-1">Título del la herramienta: *</label>
                                <input name="titulo" type="text" id="titulo" placeholder="Ej: Guía de..."
                                    class="form-control @error('titulo') is-invalid @enderror"
                                    value="{{ old('titulo', $herramienta->titulo ?? '') }}" required autofocus>
                                @error('titulo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="fw-bold mb-1">Descripción:</label>
                                <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $herramienta->descripcion) }}</textarea>
                                @error('descripcion')
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
                                            {{ old('orden', $herramienta->orden ?? '') == $ordenSeleccionado ? 'selected' : '' }}
                                            {{ in_array($ordenSeleccionado, $ordenesExistentes) && $ordenSeleccionado != ($herramienta->orden ?? -1) ? 'disabled' : '' }}>
                                            {{ $ordenSeleccionado }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('orden')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="custom-section-title d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fa-solid fa-paperclip text-primary-integration"></i> Anexos
                                </div>
                                <button type="button" id="add-anexo" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-plus me-1"></i> Agregar Anexo
                                </button>
                            </div>

                            <div id="anexos-container" class="mt-3">
                                @if ($herramienta->exists)
                                    @foreach ($herramienta->anexos as $index => $anexo)
                                        <div class="anexo-row p-3 mb-3 bg-light border rounded position-relative shadow-sm transition-all"
                                            data-index="{{ $index }}">
                                            <input type="hidden" name="anexos[{{ $index }}][id]"
                                                value="{{ $anexo->id }}">
                                            <div class="row g-3 align-items-center">
                                                <div class="col-md-5">
                                                    <label class="small fw-bold text-muted mb-1">Título del anexo:</label>
                                                    <input name="anexos[{{ $index }}][titulo]" type="text"
                                                        value="{{ $anexo->titulo }}"
                                                        placeholder="Ej: Anexo 1 - Tablas estadísticas"
                                                        class="form-control form-control-sm">
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="small fw-bold text-muted mb-1">Archivo actual:</label>
                                                    <div class="d-flex align-items-center bg-white p-1 border rounded">
                                                        <a href="{{ asset('documentos/herramientas/anexos/' . $anexo->archivo) }}"
                                                            target="_blank" title="{{ $anexo->titulo }}">
                                                            <i class="fa-solid fa-file-arrow-down text-danger mx-2"></i>
                                                        </a>
                                                        <span
                                                            class="small text-truncate flex-grow-1">{{ $anexo->archivo }}</span>
                                                        <input name="anexos[{{ $index }}][archivo]" type="file"
                                                            class="form-control form-control-sm d-none"
                                                            id="anexo_file_{{ $index }}"
                                                            accept=".pdf,.zip,.rar,.doc,.docx,.xls,.xlsx"
                                                            onchange="validateFileSize(this, 10)">
                                                        <button type="button"
                                                            class="btn btn-sm btn-link text-primary p-0 px-2"
                                                            onclick="document.getElementById('anexo_file_{{ $index }}').click(); this.parentElement.querySelector('span').innerText = 'Cambiar archivo...'">
                                                            <i class="fa-solid fa-upload"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label class="small fw-bold text-muted mb-1">Orden:</label>
                                                    <input name="anexos[{{ $index }}][orden]" type="number"
                                                        value="{{ $anexo->orden }}"
                                                        class="form-control form-control-sm text-center">
                                                </div>
                                                <div class="col-md-1 text-end">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger remove-anexo mt-3"
                                                        data-id="{{ $anexo->id }}">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div id="deleted-anexos"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-4">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-cloud-arrow-up text-primary-integration"></i> Archivo PDF
                            </div>
                            @if (isset($herramienta) && $herramienta->archivo)
                                <div class="alert alert-light border shadow-sm mb-2 p-2">
                                    <small class="text-muted d-block text-uppercase" style="font-size: 0.7rem;">Documento
                                        Actual:</small>
                                    <a href="{{ asset('documentos/herramientas/' . $herramienta->archivo) }}"
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
                                        {{ isset($herramienta) ? 'nuevo' : '' }}</div>
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

                                <input accept=".pdf" type="file" id="archivo" name="archivo"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                    style="z-index: 2; cursor: pointer;"
                                    onchange="if (validateFileSize(this, 10)) updateFileName(this, 'fileNameDisplay', null, 'pdf-placeholder', 'pdf-filename-container')">
                            </div>
                            @error('archivo')
                                <small class="text-danger d-block mt-1 text-center">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-image text-primary-integration"></i> Portada
                            </div>
                            <div class="file-upload-wrapper overflow-hidden position-relative" style="height: 200px;">
                                {{-- Placeholder --}}
                                <div id="portada-placeholder"
                                    class="upload-content text-center {{ $herramienta->exists && $herramienta->imagen ? 'd-none' : '' }}">
                                    <div class="upload-icon">
                                        <i class="fa-solid fa-camera"></i>
                                    </div>
                                    <div class="fw-bold text-dark">Subir Imagen</div>
                                    <div class="small text-muted mb-2">JPG, PNG, WEBP</div>
                                </div>

                                {{-- Preview Overlay --}}
                                <img id="preview-portada"
                                    src="{{ $herramienta->exists && $herramienta->imagen ? asset('imagen/herramientas/' . $herramienta->imagen) : '#' }}"
                                    alt="Vista previa"
                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain {{ $herramienta->exists && $herramienta->imagen ? '' : 'd-none' }}"
                                    style="z-index: 1;">

                                <input type="file" id="imagen" name="imagen" accept="image/*"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                    style="z-index: 2; cursor: pointer;"
                                    onchange="if (validateFileSize(this, 6)) updateFileName(this, 'portadaNameDisplay', 'preview-portada', 'portada-placeholder')">
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
                                    class="form-select text-center fw-bold {{ old('publicado', $herramienta->publicado ?? 0) == 1 ? 'text-success border-success' : 'text-warning border-warning' }}"
                                    name="publicado" onchange="updateVisibilityStyle(this)">
                                    <option value="1"
                                        {{ old('publicado', $herramienta->publicado ?? 0) == 1 ? 'selected' : '' }}>
                                        Publicado</option>
                                    <option value="0"
                                        {{ old('publicado', $herramienta->publicado ?? 0) == 0 ? 'selected' : '' }}>
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
                            <button type="submit" class="btn btn-custom-primary shadow-sm py-2">
                                <i class="fa-solid fa-save me-2"></i>
                                {{ isset($herramienta) ? 'Guardar cambios' : 'Subir Documento' }}
                            </button>
                            <a href="{{ route('panel-herramientas.index') }}" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <script>
            let anexoIndex = {{ $herramienta->exists ? $herramienta->anexos->count() : 0 }};

            document.getElementById('add-anexo').addEventListener('click', function() {
                const container = document.getElementById('anexos-container');
                const row = document.createElement('div');
                row.className =
                    'anexo-row p-3 mb-3 bg-white border border-primary-integration border-opacity-25 rounded position-relative shadow-sm transition-all animate__animated animate__fadeInUp';
                row.setAttribute('data-index', anexoIndex);

                row.innerHTML = `
                    <div class="row g-3 align-items-center">
                        <div class="col-md-5">
                            <label class="small fw-bold text-muted mb-1">Título del anexo:</label>
                            <input name="anexos[${anexoIndex}][titulo]" type="text" placeholder="Ej: Anexo A - Documentación extra" class="form-control form-control-sm border-primary-integration" required>
                        </div>
                        <div class="col-md-5">
                            <label class="small fw-bold text-muted mb-1">Archivo:</label>
                            <input name="anexos[${anexoIndex}][archivo]" type="file" accept=".pdf,.zip,.rar,.doc,.docx,.xls,.xlsx" class="form-control form-control-sm border-primary-integration" onchange="validateFileSize(this, 10)" required>
                        </div>
                        <div class="col-md-1">
                            <label class="small fw-bold text-muted mb-1">Orden:</label>
                            <input name="anexos[${anexoIndex}][orden]" type="number" value="${anexoIndex + 1}" class="form-control form-control-sm text-center">
                        </div>
                        <div class="col-md-1 text-end">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-anexo mt-3">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(row);
                anexoIndex++;
            });

            document.getElementById('anexos-container').addEventListener('click', function(e) {
                if (e.target.closest('.remove-anexo')) {
                    const btn = e.target.closest('.remove-anexo');
                    const row = btn.closest('.anexo-row');
                    const id = btn.getAttribute('data-id');

                    if (id) {
                        const deletedIdsContainer = document.getElementById('deleted-anexos');
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'deleted_anexos[]';
                        input.value = id;
                        deletedIdsContainer.appendChild(input);
                    }

                    row.classList.add('animate__animated', 'animate__fadeOutDown');
                    setTimeout(() => row.remove(), 500);
                }
            });

            function validateFileSize(input, maxSizeInMb) {
                input.setCustomValidity('');

                if (!input.files || !input.files[0]) {
                    return true;
                }

                if (input.files[0].size > maxSizeInMb * 1024 * 1024) {
                    input.value = '';
                    input.setCustomValidity(`El archivo no debe superar ${maxSizeInMb} MB.`);
                    input.reportValidity();
                    return false;
                }

                return true;
            }

            function updateFileName(input, displayId, previewId = null, placeholderId = null, overlayId = null) {
                const display = document.getElementById(displayId);
                const preview = previewId ? document.getElementById(previewId) : null;
                const placeholder = placeholderId ? document.getElementById(placeholderId) : null;
                const overlay = overlayId ? document.getElementById(overlayId) : null;

                if (input.files && input.files[0]) {
                    if (display) display.innerText = input.files[0].name;

                    if (preview) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.classList.remove('d-none');
                            if (placeholder) placeholder.classList.add('d-none');
                        }
                        reader.readAsDataURL(input.files[0]);
                    } else if (overlay && placeholder) {
                        overlay.classList.remove('d-none');
                        overlay.classList.add('d-flex');
                        placeholder.classList.add('d-none');
                    }
                } else {
                    if (display) display.innerText = '';
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
    </x-app-layout>
