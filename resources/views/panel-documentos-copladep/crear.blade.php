<x-app-layout>
    @section('title', 'COPLADEP: Subir')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subir documentos de COPLADEP') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Subir documento</h2>
            </div>

            <form action="{{ route('panel-documentos-copladep.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i> Nombre del
                                documento: *
                            </div>
                            <input name="nombre" type="text" id="nombre"
                                placeholder="Acta, programa o informe de comite"
                                class="w-100 form-control @error('nombre') is-invalid @enderror"
                                value="{{ old('nombre') }}" @error('nombre') autofocus @enderror autofocus required>
                            @error('nombre')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="custom-section-title"><i class="fa-solid fa-calendar-check"></i>
                                Año: *
                            </div>
                            <input type="number" id="anio" name="anio" placeholder="YYYY" pattern="\d{4}?"
                                value="{{ old('anio') }}" title="Formato válido: YYYY" min="2010"
                                class="w-100 form-control @error('anio') is-invalid @enderror">
                            @error('anio')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>

                    </div>

                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-folder-plus"></i>
                        Seleccione el tipo de
                        documento: *
                    </div>
                    <select id="tipo_documento" name="tipo_documento"
                        class="w-100 form-control @error('tipo_documento') is-invalid @enderror">
                        <option value="" disabled selected>Seleccione</option>
                        @foreach ($tiposDocumentos as $tipoDocumento)
                            <option value="{{ $tipoDocumento }}">{{ $tipoDocumento }}</option>
                        @endforeach
                    </select>
                    @error('tipo_documento')
                        <small class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3" id="tipo_acta_container" style="display: none;">
                    <div class="custom-section-title"><i class="fa-solid fa-folder-plus"></i>
                        Seleccione el tipo de
                        acta: *
                    </div>
                    <select id="tipo_acta" name="tipo_acta" class="w-100 form-control">
                        <option value="" disabled selected>Seleccione</option>
                        <option value="Ordinaria">Ordinaria</option>
                        <option value="Extraordinaria">Extraordinaria</option>
                    </select>
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-file"></i>
                        Cargue el documento: *
                    </div>
                    <input accept=".pdf" type="file" id="file" name="ruta_documento"
                        placeholder="Cargue el documento"
                        class="form-control @error('ruta_documento') is-invalid @enderror">
                    @error('ruta_documento')
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
                        <a href="{{ route('panel-documentos-subcomites.index') }}" class="btn btn-secondary mb-3 w-100">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-success mb-3 w-100">
                            Subir
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tipoDocumentoSelect = document.getElementById('tipo_documento');
        var tipoActaContainer = document.getElementById('tipo_acta_container');

        tipoDocumentoSelect.addEventListener('change', function() {
            if (this.value === 'Acta') {
                tipoActaContainer.style.display = 'block';
            } else {
                tipoActaContainer.style.display = 'none';
            }
        });
    });
</script>
