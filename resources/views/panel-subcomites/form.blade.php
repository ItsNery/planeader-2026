<x-app-layout>
    @section('title', $subcomite->exists ? 'Editar Subcomité' : 'Subir Subcomité')
    <div class="container py-3">
        <div class="tarjeta-admin p-4 rounded-3 bg-white">
            <div class="form-header py-3 mb-4">
                <h2 class="fw-bold m-0">
                    {{ $subcomite->exists ? 'Editar Subcomité' : 'Subir Subcomité' }}
                </h2>
                <p class="text-white mb-0 small opacity-75">
                    {{ $subcomite->exists ? 'Modifique la información y valide los cambios.' : 'Complete el formulario para registrar un nuevo subcomité.' }}
                </p>
            </div>
            <form method="POST"
                action="{{ $subcomite->exists ? route('panel-subcomites.update', $subcomite->id) : route('panel-subcomites.store') }}"
                novalidate enctype="multipart/form-data">
                @csrf
                @if ($subcomite->exists)
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
                                <label for="nombre" class="fw-bold mb-1">Nombre del subcomité: *</label>
                                <input name="nombre" type="text" id="nombre" placeholder="Ej: Subcomité de..."
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    value="{{ old('nombre', $subcomite->nombre ?? '') }}" required autofocus>
                                @error('nombre')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="objetivo" class="fw-bold mb-1">Objetivo: *</label>
                                <textarea id="objetivo" name="objetivo" placeholder="Objetivo del subcomité...*"
                                    class="form-control @error('objetivo') is-invalid @enderror" required>{{ old('objetivo', $subcomite->objetivo ?? '') }}</textarea>
                                @error('objetivo')
                                    <small class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-tags text-primary-integration"></i> Detalles del subcomité
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tipo_subcomite" class="fw-bold mb-1">Tipo: *</label>
                                    <select id="tipo_subcomite" name="tipo_subcomite"
                                        class="form-control @error('tipo_subcomite') is-invalid @enderror"
                                        @error('tipo_subcomite') autofocus @enderror required>
                                        <option value="" disabled selected>Seleccione</option>
                                        @foreach ($tipos_subcomites as $tipo_subcomite)
                                            <option value="{{ $tipo_subcomite }}"
                                                {{ old('tipo_subcomite', $subcomite->tipo_subcomite) == $tipo_subcomite ? 'selected' : '' }}>
                                                {{ $tipo_subcomite }}</option>
                                        @endforeach
                                    </select>
                                    @error('tipo_subcomite')
                                        <small class="invalid-feedback d-block">
                                            <strong>{{ $message }}</strong>
                                        </small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="planestatal_id" class="fw-bold mb-1">Plan Estatal de Desarrollo:
                                        *</label>
                                    <select id="planestatal_id" name="planestatal_id"
                                        class="form-control @error('municipio_id') is-invalid @enderror"
                                        @error('planestatal_id') autofocus @enderror required>
                                        <option value="" disabled selected>Seleccione</option>
                                        @foreach ($planes_estatales as $planes)
                                            <option value="{{ $planes->id }}"
                                                {{ old('planestatal_id', $subcomite->planestatal_id) == $planes->id ? 'selected' : '' }}>
                                                {{ $planes->nombre }}</option>
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
                                <i class="fa-solid fa-image text-primary-integration"></i> Icono: *
                            </div>
                            <div class="file-upload-wrapper overflow-hidden position-relative" style="height: 200px;">
                                {{-- Placeholder --}}
                                <div id="icono-placeholder"
                                    class="upload-content text-center {{ $subcomite->exists && $subcomite->icono ? 'd-none' : '' }}">
                                    <div class="upload-icon">
                                        <i class="fa-solid fa-camera"></i>
                                    </div>
                                    <div class="fw-bold text-dark">Subir Imagen</div>
                                    <div class="small text-muted mb-2">JPG, PNG, WEBP</div>
                                </div>

                                {{-- Preview Overlay --}}
                                <img id="preview-icono"
                                    src="{{ $subcomite->exists && $subcomite->icono ? asset('icono_subcomites/' . $subcomite->icono) : '#' }}"
                                    alt="Vista previa"
                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain {{ $subcomite->exists && $subcomite->icono ? '' : 'd-none' }}"
                                    style="z-index: 1;">

                                <input type="file" id="icono" name="icono" accept="image/*"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                    style="z-index: 2; cursor: pointer;"
                                    onchange="updateFileName(this, 'iconoNameDisplay', 'preview-icono', 'icono-placeholder')">
                            </div>

                            <small id="iconoNameDisplay" class="d-block text-center mt-2 text-success fw-bold"></small>

                            @error('icono')
                                <small class="text-danger d-block text-center mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <div class="custom-section-title">
                                <i class="fa-solid fa-image text-primary-integration"></i> Conformación del comité: *
                            </div>
                            <div class="file-upload-wrapper overflow-hidden position-relative" style="height: 200px;">
                                {{-- Placeholder --}}
                                <div id="conformacion-placeholder"
                                    class="upload-content text-center {{ $subcomite->exists && $subcomite->conformacion ? 'd-none' : '' }}">
                                    <div class="upload-icon">
                                        <i class="fa-solid fa-camera"></i>
                                    </div>
                                    <div class="fw-bold text-dark">Subir Imagen</div>
                                    <div class="small text-muted mb-2">JPG, PNG, WEBP</div>
                                </div>

                                {{-- Preview Overlay --}}
                                <img id="preview-conformacion"
                                    src="{{ $subcomite->exists && $subcomite->conformacion ? asset('subcomitesconformacion/' . $subcomite->conformacion) : '#' }}"
                                    alt="Vista previa"
                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain {{ $subcomite->exists && $subcomite->conformacion ? '' : 'd-none' }}"
                                    style="z-index: 1;">

                                <input type="file" id="conformacion" name="conformacion" accept="image/*"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                    style="z-index: 2; cursor: pointer;"
                                    onchange="updateFileName(this, 'conformacionNameDisplay', 'preview-conformacion', 'conformacion-placeholder')">
                            </div>

                            <small id="conformacionNameDisplay"
                                class="d-block text-center mt-2 text-success fw-bold"></small>

                            @error('conformacion')
                                <small class="text-danger d-block text-center mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                        @if (auth()->user()->validador == 1)
                            <div class="mb-3">
                                <div class="custom-section-title">
                                    <i class="fa-solid fa-eye text-primary-integration"></i> Visibilidad
                                </div>
                                <select
                                    class="form-select text-center fw-bold {{ old('publicado', $subcomite->publicado ?? 0) == 1 ? 'text-success border-success' : 'text-info border-info' }}"
                                    id="publicado" name="publicado" required onchange="updateVisibilityStyle(this)">
                                    <option value="1"
                                        {{ old('publicado', $subcomite->publicado ?? 0) == 1 ? 'selected' : '' }}>
                                        Publicado
                                    </option>
                                    <option value="0"
                                        {{ old('publicado', $subcomite->publicado ?? 0) == 0 ? 'selected' : '' }}>
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
                                {{ $subcomite->exists ? 'Guardar cambios' : 'Crear subcomité' }}
                            </button>
                            <a href="{{ route('panel-subcomites.index') }}"
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
