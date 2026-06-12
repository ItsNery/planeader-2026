<x-app-layout>
    @section('title', isset($event->id) ? 'Editar Evento' : 'Crear Evento')

    <div class="container py-3">
        <div class="tarjeta-admin p-4 rounded-3 bg-white">
            <div class="form-header py-3 mb-4">
                <h2 class="fw-bold m-0">
                    {{ isset($event->id) ? 'Editar evento' : 'Crear evento' }}
                </h2>
                <p class="text-white mb-0 small opacity-75">
                    {{ isset($event->id) ? 'Modifique la información y valide los cambios.' : 'Complete el formulario para registrar un nuevo evento.' }}
                </p>
            </div>

            <form
                action="{{ isset($event->id) ? route('panel-eventos.update', $event->id) : route('panel-eventos.store') }}"
                method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @if (isset($event->id))
                    @method('PUT')
                @endif

                <div class="row g-4">

                    {{-- COLUMNA IZQUIERDA: DATOS --}}
                    <div class="col-lg-8 border-end-lg pe-lg-4">
                        <div class="custom-section-title mb-3">
                            <i class="fa-solid fa-calendar-check text-primary-integration"></i> Detalles del Evento
                        </div>

                        <div class="mb-3">
                            <label for="titulo" class="fw-bold mb-1">Título del evento: *</label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror"
                                id="titulo" name="titulo" required
                                value="{{ old('titulo', $event->titulo ?? '') }}"
                                placeholder="Ej: Segunda Sesión del Consejo..." autofocus>
                            @error('titulo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fecha_evento" class="fw-bold mb-1">Fecha del evento: *</label>
                            <input type="date" class="form-control @error('fecha_evento') is-invalid @enderror"
                                id="fecha_evento" name="fecha_evento" required
                                value="{{ old('fecha_evento', isset($event->fecha_evento) ? \Carbon\Carbon::parse($event->fecha_evento)->format('Y-m-d') : '') }}">
                            @error('fecha_evento')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- COLUMNA DERECHA: ICONO Y ACCIONES --}}
                    <div class="col-lg-4">
                        <div class="mb-4">
                            <div class="custom-section-title mb-3">
                                <i class="fa-solid fa-image text-primary-integration"></i> Ícono del Evento
                            </div>

                            <div class="file-upload-wrapper overflow-hidden position-relative @error('icono_evento') is-invalid @enderror"
                                style="height: 150px;">
                                <div id="img-placeholder"
                                    class="upload-content text-center {{ isset($event->icono_evento) ? 'd-none' : '' }}">
                                    <div class="upload-icon">
                                        <i class="fa-solid fa-camera fs-2"></i>
                                    </div>
                                    <div class="fw-bold small text-dark">Subir ícono</div>
                                    <div class="small text-muted mb-2">Máximo 6MB</div>
                                </div>
                                <img src="{{ isset($event->icono_evento) ? asset('imagen-eventos/' . $event->icono_evento) : '' }}"
                                    id="imgPreview"
                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain {{ isset($event->icono_evento) ? '' : 'd-none' }}">

                                <input type="file" name="icono_evento" id="icono_evento" accept="image/*"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                    style="cursor: pointer; z-index: 2;"
                                    onchange="updateFileName(this, 'imgNameDisplay', 'imgPreview', 'img-placeholder')">
                            </div>
                            @error('icono_evento')
                                <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                            @enderror
                            <small id="imgNameDisplay"
                                class="d-block text-center mt-2 text-success fw-bold small"></small>
                        </div>

                        <hr class="text-muted">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-custom-primary shadow-sm py-2">
                                <i class="fa-solid fa-save me-2"></i>
                                {{ isset($event->id) ? 'Guardar cambios' : 'Crear Evento' }}
                            </button>
                            <a href="{{ route('panel-eventos.index') }}"
                                class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateFileName(input, displayId, previewId = null, placeholderId = null) {
            const display = document.getElementById(displayId);
            const preview = previewId ? document.getElementById(previewId) : null;
            const placeholder = placeholderId ? document.getElementById(placeholderId) : null;

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
                }
            }
        }
    </script>
</x-app-layout>
