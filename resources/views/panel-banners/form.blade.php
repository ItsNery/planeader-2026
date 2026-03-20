<x-app-layout>
    @section('title', isset($banner->id) ? 'Editar Banner' : 'Nuevo Banner')
    <div class="container py-3">
        <div class="tarjeta-admin p-4 rounded-3 bg-white">
            <div class="form-header py-3 mb-4">
                <h2 class="fw-bold m-0">
                    {{ isset($banner->id) ? 'Editar banner' : 'Subir banner' }}
                </h2>
                <p class="text-white mb-0 small opacity-75">
                    {{ isset($banner->id) ? 'Modifique la información y valide los cambios.' : 'Complete el formulario para registrar un nuevo banner.' }}
                </p>
            </div>
            <form
                action="{{ isset($banner->id) ? route('panel-banners.update', $banner->id) : route('panel-banners.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($banner->id))
                    @method('PUT')
                @endif
                <div class="row g-4">
                    <div class="col-lg-8 border-end-lg pe-lg-4">
                        <div class="custom-section-title mb-3">
                            <i class="fa-solid fa-file-signature text-primary-integration"></i> Información
                            Principal
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="fw-bold mb-1">Título del banner: *</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                id="nombre" name="nombre" required
                                value="{{ old('nombre', $banner->nombre ?? '') }}"
                                placeholder="Ej: Banner del día de...">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="fw-bold mb-1">Descripción: *</label>
                            <textarea name="descripcion" id="descripcion" cols="4" rows="4"
                                class="form-control @error('descripcion') is-invalid @enderror"
                                @error('descripcion') autofocus @enderror>{{ old('descripcion', $banner->descripcion ?? '') }}</textarea>
                            @error('descripcion')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="custom-section-title">
                            <i class="fa-solid fa-tags text-primary-integration"></i> Detalles del Banner
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="enlace" class="fw-bold mb-1">Enlace: *</label>
                                <input type="text" id="enlace" name="enlace"
                                    value="{{ old('enlace', $banner->enlace ?? '') }}"
                                    class="form-control @error('enlace') is-invalid @enderror"
                                    placeholder="https://sitioweb.com.mx o #" @error('enlace') autofocus @enderror>
                                @error('enlace')
                                    <small class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="estado" class="fw-bold mb-1">Estado: *</label>
                                <select id="estado" name="estado"
                                    class="form-control @error('estado') is-invalid @enderror">
                                    <option value="" disabled>Seleccione</option>
                                    @foreach ($estados_banner as $estado)
                                        <option value="{{ $estado }}"
                                            {{ old('estado', $banner->estado ?? '') == $estado ? 'selected' : '' }}>
                                            {{ $estado }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('estado')
                                    <small class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="seccion" class="fw-bold mb-1">Sección: *</label>
                                <select id="seccion" name="seccion"
                                    class="form-control @error('seccion') is-invalid @enderror">
                                    <option value="" disabled>Seleccione</option>
                                    @foreach ($secciones as $seccion)
                                        <option value="{{ $seccion }}"
                                            {{ old('seccion', $banner->seccion ?? '') == $seccion ? 'selected' : '' }}>
                                            {{ $seccion }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('estado')
                                    <small class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="orden" class="fw-bold mb-1">Orden: *</label>
                                <select class="form-control @error('orden') is-invalid @enderror" id="orden"
                                    name="orden" required>
                                    <option value="" disabled>Seleccione</option>
                                    @foreach ($ordenesDisponibles as $orden)
                                        <option value="{{ $orden }}"
                                            {{ $orden == $banner->orden ? 'selected' : '' }}
                                            {{ in_array($orden, $ordenesExistentes) && $orden != $banner->orden ? 'disabled' : '' }}>
                                            {{ $orden }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('orden')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-4">
                            <div class="custom-section-title mb-3">
                                <i class="fa-solid fa-image text-primary-integration"></i> Banner
                            </div>
                            <div class="file-upload-wrapper overflow-hidden position-relative @error('imagen') is-invalid @enderror"
                                style="height: 120px;">
                                <div id="img-placeholder"
                                    class="upload-content text-center {{ isset($imagen->imagen) ? 'd-none' : '' }}">
                                    <i class="fa-solid fa-camera fs-2 mb-2"></i>
                                    <div class="fw-bold small">Subir imagen</div>
                                </div>
                                <img src="{{ isset($banner->imagen) ? asset('baners/' . $banner->imagen) : '' }}"
                                    id="imgPreview"
                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain {{ isset($banner->imagen) ? '' : 'd-none' }}">

                                <input type="file" name="imagen" id="imagen" accept="image/*"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                    style="cursor: pointer;"
                                    onchange="updateFileName(this, 'imgNameDisplay', 'imgPreview', 'img-placeholder')">
                            </div>
                            @error('imagen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small id="imgNameDisplay"
                                class="d-block text-center mt-2 text-success fw-bold small"></small>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('panel-banners.index') }}"
                                class="btn btn-outline-secondary px-4">Cancelar</a>
                            <button type="submit" class="btn btn-custom-primary px-5 shadow-sm">
                                <i class="fa-solid fa-save me-2"></i>
                                {{ isset($banner->id) ? 'Actualizar' : 'Guardar' }}
                            </button>
                        </div>
                    </div>
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
