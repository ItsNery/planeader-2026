<x-app-layout>
    @section('title', 'Programas Derivados: Subida Masiva')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subida Masiva de Programas Derivados') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Subir Múltiples Programas</h2>
                <p class="text-white">
                    Sube varios programas a la vez. Todos compartirán el mismo Plan Estatal y Tipo.
                    <br>
                    <strong>El nombre de cada programa se tomará del nombre de cada archivo PDF.</strong>
                </p>
            </div>

            <form action="{{ route('panel-programas-derivados.storeMassive') }}" method="POST"
                enctype="multipart/form-data" novalidate>
                @csrf

                <fieldset class="border p-3 mb-3">
                    <legend class="w-auto px-2">Datos Comunes</legend>
                    <div class="mb-3">
                        <div class="custom-section-title"><i class="fa-solid fa-file-invoice"></i>
                            Seleccione el tipo (para todos): *
                        </div>
                        <select id="tipo_derivado" name="tipo_derivado"
                            class="form-control @error('tipo_derivado') is-invalid @enderror"
                            @error('tipo_derivado') autofocus @enderror required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach ($tiposProgDer as $tipoProgDer)
                                <option value="{{ $tipoProgDer }}">{{ $tipoProgDer }}</option>
                            @endforeach
                        </select>
                        @error('tipo_derivado')
                            <small class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="custom-section-title"><i class="fa-solid fa-book"></i>
                            Seleccione el plan estatal (para todos): *
                        </div>
                        <select id="planestatal_id" name="planestatal_id"
                            class="form-control @error('planestatal_id') is-invalid @enderror"
                            @error('planestatal_id') autofocus @enderror required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach ($planes_estatales as $plan_estatal)
                                <option value="{{ $plan_estatal->id }}">{{ $plan_estatal->nombre }}</option>
                            @endforeach
                        </select>
                        @error('planestatal_id')
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
                                <option value="0" selected>No</option>
                            </select>
                            @error('publicado')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif
                </fieldset>

                <fieldset class="border p-3 mb-3">
                    <legend class="w-auto px-2">Programas</legend>

                    @error('programas')
                        <small class="invalid-feedback d-block"><strong>{{ $message }}</strong></small>
                    @enderror

                    @error('programas.*.nombre')
                        <small class="invalid-feedback d-block"><strong>{{ $message }}</strong></small>
                    @enderror
                    @error('programas.*.pdf')
                        <small class="invalid-feedback d-block"><strong>{{ $message }}</strong></small>
                    @enderror
                    @error('programas.*.portada')
                        <small class="invalid-feedback d-block"><strong>{{ $message }}</strong></small>
                    @enderror

                    <div id="programas-container">
                        @error('programas.*.pdf')
                            <small class="invalid-feedback d-block"><strong>{{ $message }}</strong></small>
                        @enderror
                        @error('programas.*.portada')
                            <small class="invalid-feedback d-block"><strong>{{ $message }}</strong></small>
                        @enderror
                    </div>

                    <button type="button" id="add-programa-btn" class="btn btn-info btn-sm mt-2">
                        <i class="fa-solid fa-plus"></i> Añadir Programa
                    </button>
                </fieldset>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('panel-programas-derivados.index') }}"
                                class="btn btn-secondary w-100 my-1">
                                Cancelar
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success w-100 my-1">Subir Lote</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const container = document.getElementById('programas-container');
        const addButton = document.getElementById('add-programa-btn');

        // ✨ 1. Añadimos un contador global para los pares
        let pairCounter = 0;

        function addProgramaPair() {

            // ✨ 2. Usamos el contador 'pairCounter' en los atributos 'name'
            var pairHtml = `
                <div class="programa-pair mb-3 border p-3 rounded position-relative" style="background-color: #f8f9fa;">
                    
                    <div class="mb-2">
                        <label class="form-label fw-bold">Nombre del Programa: *</label>
                        <input type="text" name="programas[${pairCounter}][nombre]" class="form-control" placeholder="Ej: Programa Sectorial de Salud" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold">Documento PDF: *</label>
                        <input type="file" name="programas[${pairCounter}][pdf]" class="form-control" accept=".pdf" required>
                    </div>
                    
                    <div class="mb-2">
                        <label class="form-label fw-bold">Portada (Imagen): *</label>
                        <input type="file" name="programas[${pairCounter}][portada]" class="form-control" accept=".jpg,.png,.svg,.jpeg" required>
                    </div>
                    
                    <button type="button" class="btn btn-danger btn-sm remove-pair-btn position-absolute" style="top: 10px; right: 10px;">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', pairHtml);

            // ✨ 3. Incrementamos el contador para la próxima fila
            pairCounter++;
        }

        // --- MANEJADORES DE EVENTOS ---

        addButton.addEventListener('click', function() {
            addProgramaPair();
        });

        container.addEventListener('click', function(event) {
            const removeButton = event.target.closest('.remove-pair-btn');
            if (removeButton) {
                removeButton.closest('.programa-pair').remove();
            }
        });

        // (No añadimos una fila al inicio, dejamos que el usuario lo haga)

    });
</script>
