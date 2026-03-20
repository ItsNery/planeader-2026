<x-app-layout>
    @section('title', 'Documentos de Subcomités: Editar')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar documentos de los Subcomités') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Editar documento</h2>
            </div>
            <form id="form-update-comite"
                action="{{ route('panel-documentossubcomites.update', $DocumentoSubcomites->id) }}" method="POST"
                enctype="multipart/form-data" novalidate>
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i>
                                Nombre del documento: *
                            </div>
                            <input type="text" name="nombre"
                                class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                                placeholder="Ingresa el nombre del documento"
                                value="{{ old('nombre', $DocumentoSubcomites->nombre) }}">
                            @error('nombre')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i>
                                Año: *
                            </div>
                            <input type="text" id="fname" name="anio" value="{{ $DocumentoSubcomites->anio }}"
                                class="form-control @error('anio') is-invalid @enderror" placeholder="AAAA">
                            @error('anio')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-person-chalkboard"></i>
                        Seleccione el subcomité: *
                    </div>
                    <select id="subcomite_id" name="subcomite_id"
                        class="form-control @error('subcomite_id') is-invalid @enderror">
                        <option value="" disabled selected>Seleccione</option>
                        @foreach ($nombreSubcomites as $nombreSubcomite)
                            <option value="{{ $nombreSubcomite->id }}"
                                {{ $nombreSubcomite->id == $DocumentoSubcomites->subcomite_id ? 'selected' : '' }}>
                                {{ $nombreSubcomite->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('subcomite_id')
                        <small class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="custom-section-title"><i class="fa-solid fa-circle-exclamation"></i>
                                Seleccione el tipo de documento: *
                            </div>
                            <select id="tipo_documento" name="tipo_documento" class="form-control">
                                <option value="" disabled>Seleccione</option>
                                @foreach ($tiposDocumentos as $tipoDocumento)
                                    <option value="{{ $tipoDocumento }}"
                                        {{ $tipoDocumento == $DocumentoSubcomites->tipo_documento ? 'selected' : '' }}>
                                        {{ $tipoDocumento }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_documento')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-md-4" id="tipo_acta_container" style="display: none;">
                            <div class="custom-section-title"><i class="fa-solid fa-circle-exclamation"></i>
                                Seleccione el tipo de acta: *
                            </div>
                            <select id="tipo_acta" name="tipo_acta" class="form-control">
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Ordinaria"
                                    {{ $DocumentoSubcomites->tipo_acta === 'Ordinaria' ? 'selected' : '' }}>
                                    Ordinaria</option>
                                <option value="Extraordinaria"
                                    {{ $DocumentoSubcomites->tipo_acta === 'Extraordinaria' ? 'selected' : '' }}>
                                    Extraordinaria</option>
                            </select>
                            @error('tipo_acta')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="custom-section-title"><i class="fa-solid fa-circle-exclamation"></i>
                                Archivo actual:
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <input name="ruta_documento" value="{{ $DocumentoSubcomites->ruta_documento }}"
                                        type="text" id="ruta_documento" disabled class="form-control">
                                </div>
                                <div class="col-md-4">

                                    <a target="_blank" class="btn btn-info  w-100"
                                        title="{{ $DocumentoSubcomites->nombre }}"
                                        href="/documentosubcomites/{{ $DocumentoSubcomites->ruta_documento }}">Ver</a>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="custom-section-title"><i class="fa-solid fa-file-circle-check"></i>
                                Subir nuevo archivo:
                            </div>
                            <input accept=".pdf" type="file" id="file" name="ruta_documento"
                                placeholder="Cargue el documento" class="form-control">
                            @error('ruta_documento')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    @if (Auth::user()->validador)
                        <div class="col-md-12">
                            <div class="custom-section-title"><i class="fa-solid fa-circle-check"></i>
                                ¿El documento puede ser
                                publicado?
                            </div>
                            <select class="form-control @error('publicado') is-invalid @enderror" id="publicado"
                                name="publicado" required>
                                <option value="0" {{ $DocumentoSubcomites->publicado == 0 ? 'selected' : '' }}>No
                                </option>
                                <option value="1" {{ $DocumentoSubcomites->publicado == 1 ? 'selected' : '' }}>Sí
                                </option>
                            </select>
                            @error('publicado')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <div class="col-md-12 d-flex justify-content-evenly">
                        <a href="{{ route('panel-documentossubcomites.index') }}"
                            class='btn btn-secondary w-100'>Cancelar</a>
                        <button type="submit" form="form-update-comite" class="btn btn-primary w-100">Subir</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

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

            // Verificar inicialmente el valor seleccionado en el primer select
            if (tipoDocumentoSelect.value === 'Acta') {
                tipoActaContainer.style.display = 'block';
            }
        });
    </script>
</x-app-layout>
