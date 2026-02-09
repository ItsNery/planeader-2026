<x-app-layout>
    @section('title', 'Planes Municipales: Editar')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Planes Municipales') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Editar plan</h2>
            </div>
            <form id="form-update-comite" action="{{ route('panel-planes-municipales.update', $planesMun->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i>
                                Nombre del documento: *
                            </div>
                            <input name="nombre" value="{{ old('nombre') ? old('nombre') : $planesMun->nombre }}"
                                type="text" id="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                placeholder="Plan Municipal de Desarrollo de...">
                            @error('nombre')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i>
                                Periodo: *
                            </div>
                            <input type="text" id="periodo" name="periodo" placeholder="AAAA-AAAA"
                                value="{{ $planesMun->periodo }}"
                                class="form-control @error('periodo') is-invalid @enderror"
                                @error('periodo') autofocus @enderror>
                            @error('periodo')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-building"></i>
                        Municipio: *
                    </div>
                    <select id="municipio_id" name="municipio_id" class="form-control">
                        <option value="" disabled>Seleccione</option>
                        @foreach ($municipios as $id => $nombre)
                            <option value="{{ $id }}" {{ $id == $planesMun->municipio_id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('municipio_id')
                        <small class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="custom-section-title"><i class="fa-solid fa-building"></i>
                                Actual plan: *
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <input name="ruta_documento" value="{{ $planesMun->ruta_documento }}"
                                        type="text" id="ruta_documento" disabled class="form-control w-100">

                                </div>
                                <div class="col-md-4">
                                    <a target="_blank" class="btn btn-info w-100"
                                        href="/planesmun/{{ $planesMun->ruta_documento }}">Ver</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-section-title"><i class="fa-solid fa-building"></i>
                                Cargue el nuevo plan:
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
                                <option value="0"
                                    {{ $planesMun->publicado == 0 ? 'selected' : '' }}>No
                                </option>
                                <option value="1"
                                    {{ $planesMun->publicado == 1 ? 'selected' : '' }}>Sí
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
                        <a href="{{ route('panel-planes-municipales.index') }}" class="btn btn-secondary w-100">Cancelar</a>
                        <button type="submit" class="btn btn-primary w-100">Subir</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

