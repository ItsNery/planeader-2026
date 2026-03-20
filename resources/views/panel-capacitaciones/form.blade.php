<x-app-layout>
    @section('title', 'Capacitaciones municipales: ' . ($capacitacione->exists ? 'Editar' : 'Subir'))

    <div class="tarjeta-admin p-4 rounded-3">
        <div class="form-header py-3 mb-4">
            <h2 class="fw-bold m-0">
                {{ $capacitacione->exists ? 'Editar capacitación' : 'Subir capacitación' }}
            </h2>
            <p class="text-white mb-0 small opacity-75">
                {{ $capacitacione->exists ? 'Modifique la información y valide los cambios.' : 'Complete el formulario para registrar un nuevo programa.' }}
            </p>
        </div>
        <form
            action="{{ $capacitacione->exists ? route('capacitaciones.update', $capacitacione) : route('capacitaciones.store') }}"
            method="POST" enctype="multipart/form-data" novalidate id="form-capacitacion">
            @csrf
            @if ($capacitacione->exists)
                @method('PUT')
            @endif
            <div class="row g-4">
                <div class="col-lg-8 border-end-lg pe-lg-4">
                    {{-- Sección 1: Datos Generales --}}
                    <div class="mb-4">
                        <div class="custom-section-title">
                            <i class="fa-solid fa-file-signature text-primary-integration"></i> Información Principal
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="fw-bold mb-1">Nombre de la Capacitación: *</label>
                            <input name="nombre" type="text" id="nombre"
                                placeholder="Ej: Programa de Capacitación 2024"
                                class="form-control @error('nombre') is-invalid @enderror"
                                value="{{ old('nombre', $capacitacione->nombre ?? '') }}" required autofocus>
                            @error('nombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Sección 2: Documentos --}}
                    <div class="mb-4">
                        <div class="custom-section-title d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa-solid fa-folder-open text-primary-integration"></i> Documentos Relacionados
                            </div>
                            <button type="button" id="add-documento" class="btn btn-sm btn-outline-primary shadow-sm">
                                <i class="fa-solid fa-plus me-1"></i> Agregar Documento
                            </button>
                        </div>

                        <div id="documentos-container" class="mt-3">
                            @if ($capacitacione->exists)
                                @foreach ($capacitacione->documentos as $index => $documento)
                                    <div class="documento-row p-3 mb-3 bg-light border rounded position-relative shadow-sm transition-all"
                                        data-index="{{ $index }}">
                                        <input type="hidden" name="documentos[{{ $index }}][id]"
                                            value="{{ $documento->id }}">
                                        <div class="row g-3 align-items-center">
                                            <div class="col-md-5">
                                                <label class="small fw-bold text-muted mb-1">Nombre del
                                                    documento:</label>
                                                <input name="documentos[{{ $index }}][nombre]" type="text"
                                                    value="{{ $documento->nombre_display }}"
                                                    placeholder="Ej: Formato de inscripción"
                                                    class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="small fw-bold text-muted mb-1">Categoría/Día:</label>
                                                <select name="documentos[{{ $index }}][dia]"
                                                    class="form-select form-select-sm">
                                                    <option value="">General</option>
                                                    <option value="1"
                                                        {{ $documento->dia_agrupador == 1 ? 'selected' : '' }}>Día 1
                                                    </option>
                                                    <option value="2"
                                                        {{ $documento->dia_agrupador == 2 ? 'selected' : '' }}>Día 2
                                                    </option>
                                                    <option value="3"
                                                        {{ $documento->dia_agrupador == 3 ? 'selected' : '' }}>Día 3
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="small fw-bold text-muted mb-1">Archivo:</label>
                                                <div class="d-flex align-items-center bg-white p-1 border rounded">
                                                    <a href="{{ asset('documentos/capacitacion-municipal/' . $documento->ruta_archivo) }}"
                                                        target="_blank" class="small text-truncate flex-grow-1">
                                                        <i class="fa-solid fa-file-pdf text-danger mx-2"></i>
                                                    </a>
                                                    <span
                                                        class="small text-truncate flex-grow-1">{{ Str::limit($documento->ruta_archivo, 15) }}</span>
                                                    <input name="documentos[{{ $index }}][archivo]"
                                                        type="file" class="form-control form-control-sm d-none"
                                                        id="doc_file_{{ $index }}">
                                                    <button type="button"
                                                        class="btn btn-sm btn-link text-primary p-0 px-2"
                                                        onclick="document.getElementById('doc_file_{{ $index }}').click(); this.parentElement.querySelector('span').innerText = 'Cambiar...'">
                                                        <i class="fa-solid fa-upload"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-1 text-end">
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger remove-documento mt-3"
                                                    data-id="{{ $documento->id }}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div id="deleted-documentos"></div>
                    </div>
                </div>

                <div class="col-lg-4">
                    {{-- Sección 3: Imagen del Programa --}}
                    <div class="mb-4">
                        <div class="custom-section-title">
                            <i class="fa-solid fa-image text-primary-integration"></i> Flyer / Imagen
                        </div>
                        <div class="file-upload-wrapper overflow-hidden position-relative" style="height: 250px;">
                            {{-- Placeholder --}}
                            <div id="flyer-placeholder"
                                class="upload-content text-center {{ $capacitacione->exists && $capacitacione->imagen_programa ? 'd-none' : '' }}">
                                <div class="upload-icon">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                                <div class="fw-bold text-dark">Subir Flyer</div>
                                <div class="small text-muted mb-2">JPG, PNG, WEBP. Máx 2MB</div>
                            </div>

                            {{-- Preview Overlay --}}
                            <img id="preview-flyer"
                                src="{{ $capacitacione->exists && $capacitacione->imagen_programa ? asset('documentos/capacitacion-municipal/' . $capacitacione->imagen_programa) : '#' }}"
                                alt="Vista previa"
                                class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain {{ $capacitacione->exists && $capacitacione->imagen_programa ? '' : 'd-none' }}"
                                style="z-index: 1;">

                            <input type="file" id="imagen_programa" name="imagen_programa" accept="image/*"
                                class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                style="z-index: 2; cursor: pointer;"
                                onchange="updateFileName(this, 'flyerNameDisplay', 'preview-flyer', 'flyer-placeholder')">
                        </div>
                        <small id="flyerNameDisplay" class="d-block text-center mt-2 text-success fw-bold"></small>
                        @error('imagen_programa')
                            <small class="text-danger d-block text-center mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Sección 4: Visibilidad --}}
                    @if (auth()->user()->validador == 1)
                        <div class="mb-4">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-eye text-primary-integration"></i> Visibilidad
                            </div>
                            <select
                                class="form-select text-center fw-bold {{ old('publicado', $capacitacione->publicado ?? 0) == 1 ? 'text-success border-success' : 'text-warning border-warning' }}"
                                name="publicado" onchange="updateVisibilityStyle(this)">
                                <option value="1"
                                    {{ old('publicado', $capacitacione->publicado ?? 0) == 1 ? 'selected' : '' }}>
                                    Publicado</option>
                                <option value="0"
                                    {{ old('publicado', $capacitacione->publicado ?? 0) == 0 ? 'selected' : '' }}>
                                    Borrador</option>
                            </select>
                            @error('publicado')
                                <small class="text-danger d-block text-center mt-1">{{ $message }}</small>
                            @enderror
                            <p class="text-muted small mt-1">
                                Defina si la capacitación será visible para el público general.
                            </p>
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-custom-primary shadow-sm py-2">
                            <i class="fa-solid fa-save me-2"></i>
                            {{ $capacitacione->exists ? 'Guardar cambios' : 'Crear capacitación' }}
                        </button>
                        <a href="{{ route('capacitaciones.index') }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        let docIndex = {{ $capacitacione->exists ? $capacitacione->documentos->count() : 0 }};

        document.getElementById('add-documento').addEventListener('click', function() {
            const container = document.getElementById('documentos-container');
            const row = document.createElement('div');
            row.className =
                'documento-row p-3 mb-3 bg-white border border-primary-integration border-opacity-25 rounded position-relative shadow-sm transition-all animate__animated animate__fadeInUp';
            row.setAttribute('data-index', docIndex);

            row.innerHTML = `
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <label class="small fw-bold text-muted mb-1">Nombre del documento:</label>
                    <input name="documentos[${docIndex}][nombre]" type="text" placeholder="Ej: Guía de estudio" class="form-control form-control-sm border-primary-integration" required>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold text-muted mb-1">Categoría/Día:</label>
                    <select name="documentos[${docIndex}][dia]" class="form-select form-select-sm border-primary-integration">
                        <option value="">General</option>
                        <option value="1">Día 1</option>
                        <option value="2">Día 2</option>
                        <option value="3">Día 3</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold text-muted mb-1">Archivo:</label>
                    <input name="documentos[${docIndex}][archivo]" type="file" accept=".pdf,.doc,.docx,.xls,.xlsx" class="form-control form-control-sm border-primary-integration" required>
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-documento mt-3">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
        `;
            container.appendChild(row);
            docIndex++;
        });

        document.getElementById('documentos-container').addEventListener('click', function(e) {
            if (e.target.closest('.remove-documento')) {
                const btn = e.target.closest('.remove-documento');
                const row = btn.closest('.documento-row');
                const id = btn.getAttribute('data-id');

                if (id) {
                    const deletedIdsContainer = document.getElementById('deleted-documentos');
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'deleted_documentos[]';
                    input.value = id;
                    deletedIdsContainer.appendChild(input);
                }

                row.classList.add('animate__animated', 'animate__fadeOutDown');
                setTimeout(() => row.remove(), 500);
            }
        });

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
