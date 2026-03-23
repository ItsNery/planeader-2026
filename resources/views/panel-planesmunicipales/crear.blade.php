<x-app-layout>
    @section('title', 'Planes Municipales: Subir')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subir Planes Municipales') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Subir plan</h2>
            </div>
            <form action="{{ route('panel-planesmunicipales.store') }}" method="POST" enctype="multipart/form-data"
                novalidate>
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
                        <a href="{{ route('panel-planesmunicipales.index') }}" class="btn btn-secondary w-100">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-success w-100">
                            Subir
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
