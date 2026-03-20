<x-app-layout>
    @section('title', 'Planes Estatales de Desarrollo: Editar')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Planes Estatales') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3 d-flex justify-content-between align-items-center">
                <h2>Editar plan</h2>
                <a href="{{ route('panel-planes-estatales-anexos.index', $planesEst->id) }}" class="btn btn-info">
                    <i class="fa-solid fa-paperclip"></i> Gestionar Anexos
                </a>
            </div>
            <form id="form-update-plan-estatal" action="{{ route('panel-planes-estatales.update', $planesEst->id) }}"
                method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i>
                                Nombre del documento: *
                            </div>
                            <input name="nombre" value="{{ old('nombre') ? old('nombre') : $planesEst->nombre }}"
                                type="text" id="fname" class="form-control @error('nombre') is-invalid @enderror"
                                placeholder="Plan Estatal de...">
                            @error('nombre')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="custom-section-title"><i class="fa-solid fa-calendar-week"></i>
                                Periodo: *
                            </div>
                            <input type="text" id="fname" name="periodo" value="{{ $planesEst->periodo }}"
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
                    <div class="custom-section-title"><i class="fa-solid fa-person-chalkboard"></i>
                        Gobernador: *
                    </div>
                    <input type="text" id="fname" name="gobernador" value="{{ $planesEst->gobernador }}"
                        class="form-control @error('gobernador') is-invalid @enderror"
                        @error('gobernador') autofocus @enderror placeholder="Jane Doe">
                    @error('gobernador')
                        <small class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="custom-section-title"><i class="fa-solid fa-file"></i>
                                Archivo actual: *
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input name="ruta_documento" value="{{ $planesEst->ruta_documento }}" type="text"
                                        id="ruta_documento" disabled class="form-control w-100">
                                </div>
                                <div class="col-md-6">
                                    <a target="_blank" class="btn btn-info w-100"
                                        href="/planesest/{{ $planesEst->ruta_documento }}">Ver</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-section-title"><i class="fa-solid fa-file-pdf"></i>
                                Subir nuevo: *
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
                    <div class="row">
                        <div class="col-md-8">
                            <div class="custom-section-title"><i class="fa-solid fa-image"></i>
                                Portada actual: *
                            </div>
                            <div class="container d-flex justify-content-center">
                                <img src="/portadaplanesest/{{ $planesEst->portada }}" width="200px"
                                    id="imagenSeleccionada">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-section-title"><i class="fa-solid fa-file-image"></i>
                                Subir nueva: *
                            </div>
                            <div class="input-group">
                                <input accept=".jpg,.png,.svg,.jpeg" name="portada" id="portada" type='file'
                                    class="form-control @error('portada') is-invalid @enderror"
                                    @error('portada') autofocus @enderror required />

                                @error('portada')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                @if (auth()->user()->validador == 1)
                    <div class="mb-3">
                        <div class="custom-section-title"><i class="fa-solid fa-check-circle"></i>
                            ¿Se puede publicar?
                        </div>
                        <select class="form-control @error('publicado') is-invalid @enderror" id="publicado"
                            name="publicado" required>
                            <option value="0" {{ $planesEst->publicado == 0 ? 'selected' : '' }}>No
                            </option>
                            <option value="1" {{ $planesEst->publicado == 1 ? 'selected' : '' }}>Sí
                            </option>
                        </select>
                        @error('publicado')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @endif

                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('panel-planes-estatales.index') }}"
                                class='btn btn-secondary w-100'>Cancelar</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" form="form-update-plan-estatal"
                                class="btn btn-primary w-100">Subir</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
<script>
    $(document).ready(function(e) {
        $('#portada').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
