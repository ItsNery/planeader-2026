<x-app-layout>
    @section('title', isset($documento) ? 'Editar Documento' : 'Subir Documento')

    <div class="container py-3">

        {{-- CONTENEDOR PRINCIPAL: Estilo idéntico a la tarjeta del índice --}}
        <div class="tarjeta-admin p-4 rounded-3">

            {{-- 1. CABECERA INSTITUCIONAL --}}
            <div class="form-header py-3 mb-4">
                <h2 class="fw-bold m-0">
                    {{ isset($documento) ? 'Editar documento' : 'Subir documento' }}
                </h2>
                <p class="text-white mb-0 small opacity-75">
                    {{ isset($documento) ? 'Modifique la información y valide los cambios.' : 'Complete el formulario para registrar un nuevo documento de insumos del PED.' }}
                </p>
            </div>

            <form
                action="{{ isset($documento) ? route('panel-documentos-insumo-ped.update', $documento->id) : route('panel-documentos-insumo-ped.store') }}"
                method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @if (isset($documento))
                    @method('PUT')
                @endif

                <div class="row g-4">

                    {{-- COLUMNA IZQUIERDA: DATOS (70%) --}}
                    <div class="col-lg-8 border-end-lg pe-lg-4">

                        {{-- Información Principal --}}
                        <div class="mb-4">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-file-signature text-primary-integration"></i> Información
                                Principal
                            </div>

                            <div class="mb-3">
                                <label for="titulo" class="fw-bold mb-1">Título del documento: *</label>
                                <input name="titulo" type="text" id="titulo"
                                    placeholder="Ej: Árbol de problemas del Eje 1..."
                                    class="form-control @error('titulo') is-invalid @enderror"
                                    value="{{ old('titulo', $documento->titulo ?? '') }}" required>
                                @error('titulo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- Detalles del archivo --}}
                        <div class="mb-3">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-tags text-primary-integration"></i> Detalles del Archivo
                            </div>
                            <div class="mb-3">
                                <label for="tipo" class="fw-bold mb-1">Tipo de documento: *</label>
                                <select name="tipo" id="tipo"
                                    class="form-select @error('tipo') is-invalid @enderror" required>
                                    <option value="">-- Selecciona un tipo --</option>
                                    <option value="arbol-problemas"
                                        {{ old('tipo', $documento->tipo ?? '') === 'arbol-problemas' ? 'selected' : '' }}>
                                        Árbol de Problemas
                                    </option>
                                    <option value="fichas-indicadores"
                                        {{ old('tipo', $documento->tipo ?? '') === 'fichas-indicadores' ? 'selected' : '' }}>
                                        Fichas de Indicadores
                                    </option>
                                </select>
                                @error('tipo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="plan_estatal_id" class="fw-bold mb-1">Plan Estatal: *</label>
                                <select name="plan_estatal_id" id="plan_estatal_id"
                                    class="form-select @error('plan_estatal_id') is-invalid @enderror" required
                                    autofocus>
                                    <option value="">-- Selecciona un Plan Estatal --</option>
                                    @foreach ($planesEstatales as $plan)
                                        <option value="{{ $plan->id }}"
                                            {{ old('plan_estatal_id', $documento->plan_estatal_id ?? '') == $plan->id ? 'selected' : '' }}>
                                            {{ $plan->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('plan_estatal_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @if (isset($documento))
                                <div class="alert alert-light border shadow-sm mb-3 p-3">
                                    <small class="text-muted d-block text-uppercase"
                                        style="font-size: 0.7rem;">Documento Actual:</small>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($documento->formato === 'pdf')
                                            <i class="fa-solid fa-file-pdf text-danger fs-4"></i>
                                        @else
                                            <i class="fa-solid fa-file-excel text-success fs-4"></i>
                                        @endif
                                        <a href="{{ asset('insumos-ped/' . $documento->ruta_documento) }}"
                                            target="_blank" class="fw-bold text-decoration-none text-truncate">
                                            Ver Archivo Actual
                                        </a>
                                        <span
                                            class="badge bg-light text-dark ms-auto">{{ strtoupper($documento->formato) }}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="alert alert-info mb-3">
                                <i class="fa-solid fa-circle-info me-2"></i>
                                <strong>Nota:</strong> El formato se detectará automáticamente al subir el documento
                                (PDF o Excel).
                            </div>
                        </div>
                    </div>

                    {{-- COLUMNA DERECHA: ACCIONES (30%) --}}
                    <div class="col-lg-4">

                        {{-- Zona de Carga --}}
                        <div class="mb-4">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-cloud-arrow-up text-primary-integration"></i> Archivo
                                {{ isset($documento) ? 'Nuevo' : '' }}
                            </div>

                            <div class="file-upload-wrapper overflow-hidden position-relative" style="height: 150px;">
                                {{-- Placeholder --}}
                                <div id="file-placeholder" class="upload-content text-center">
                                    <div class="upload-icon">
                                        <i class="fa-solid fa-file"></i>
                                    </div>
                                    <div class="fw-bold text-dark">Subir Archivo
                                        {{ isset($documento) ? 'nuevo' : '' }}</div>
                                    <div class="small text-muted mb-2">PDF o Excel (Máximo 100MB)</div>
                                </div>

                                {{-- Filename Display Overlay --}}
                                <div id="filename-container"
                                    class="position-absolute top-0 start-0 w-100 h-100 d-none d-flex flex-column align-items-center justify-content-center bg-light"
                                    style="z-index: 1;">
                                    <i class="fa-solid fa-file-circle-check fs-2 text-success mb-2"></i>
                                    <small id="fileNameDisplay"
                                        class="fw-bold text-success px-3 text-center text-truncate w-100"></small>
                                    <div class="mt-2 small text-muted">Click para cambiar</div>
                                </div>

                                {{-- Hidden input --}}
                                <input type="file" name="ruta_documento" id="ruta_documento" accept=".pdf,.xls,.xlsx"
                                    class="position-absolute w-100 h-100 opacity-0" style="cursor: pointer;"
                                    @if (!isset($documento)) required @endif>
                            </div>
                            @error('ruta_documento')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Visibilidad (Solo Validador) --}}
                        @if (auth()->user()->validador == 1)
                            <div class="mb-4">
                                <div class="custom-section-title">
                                    <i class="fa-solid fa-eye text-primary-integration"></i> Visibilidad
                                </div>
                                <select
                                    class="form-select text-center fw-bold {{ old('publicado', $documento->publicado ?? 0) == 1 ? 'text-success border-success' : 'text-warning border-warning' }}"
                                    id="publicado" name="publicado" onchange="updateVisibilityStyle(this)">
                                    <option value="1" class="text-dark"
                                        {{ old('publicado', $documento->publicado ?? 0) == 1 ? 'selected' : '' }}>
                                        Publicado
                                    </option>
                                    <option value="0" class="text-dark"
                                        {{ old('publicado', $documento->publicado ?? 0) == 0 ? 'selected' : '' }}>
                                        Borrador
                                    </option>
                                </select>
                            </div>
                        @endif

                        {{-- Botones de acción --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-custom-primary py-2 fw-bold">
                                <i class="fa-solid fa-check me-2"></i>
                                {{ isset($documento) ? 'Actualizar' : 'Guardar' }} Documento
                            </button>
                            <a href="{{ route('panel-documentos-insumo-ped.index') }}"
                                class="btn btn-outline-secondary py-2 fw-bold">
                                <i class="fa-solid fa-arrow-left me-2"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .upload-content {
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-wrapper:hover .upload-content {
            background-color: #f8f9fa;
        }

        .upload-icon {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 10px;
        }
    </style>

    <script>
        document.getElementById('ruta_documento').addEventListener('change', function() {
            const fileName = this.files[0]?.name || '';
            const placeholder = document.getElementById('file-placeholder');
            const filenameContainer = document.getElementById('filename-container');
            const fileNameDisplay = document.getElementById('fileNameDisplay');

            if (fileName) {
                fileNameDisplay.textContent = fileName;
                placeholder.classList.add('d-none');
                filenameContainer.classList.remove('d-none');
            } else {
                placeholder.classList.remove('d-none');
                filenameContainer.classList.add('d-none');
            }
        });

        // Mostrar archivo cargado si existe (para edición)
        @if (isset($documento))
            const fileInput = document.getElementById('ruta_documento');
            if (fileInput.files.length === 0) {
                const event = new Event('change', {
                    bubbles: true
                });
                // Crear un DataTransfer para simular un archivo cargado
                const dataTransfer = new DataTransfer();
                const fileName = '{{ basename($documento->ruta_documento) }}';
                const extension = fileName.split('.').pop();

                // Crear un archivo ficticio
                const file = new File([''], fileName, {
                    type: 'application/' + extension
                });
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
                fileInput.dispatchEvent(event);
            }
        @endif

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
