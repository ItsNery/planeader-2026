<x-app-layout>
    @section('title', 'Programas Derivados: Editar')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Programas Derivados') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Editar programa</h2>
            </div>
            <form id="form-update-programa"
                action="{{ route('panel-programasderivados.update', $programasDerivados->id) }}" method="POST"
                enctype="multipart/form-data" novalidate>
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i>
                                Nombre del documento: *
                            </div>
                            <input name="nombre"
                                value="{{ old('nombre') ? old('nombre') : $programasDerivados->nombre }}" type="text"
                                id="fname" class="form-control @error('nombre') is-invalid @enderror"
                                placeholder="Programa Derivado de...">
                            @error('nombre')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="custom-section-title"><i class="fa-solid fa-sort"></i>
                                Seleccione el tipo: *
                            </div>
                            <select id="tipo_derivado" name="tipo_derivado"
                                class="form-control @error('tipo_derivado') is-invalid @enderror">
                                <option value="" disabled>Seleccione</option>
                                @foreach ($tiposProgDer as $tipoProgDer)
                                    <option value="{{ $tipoProgDer }}"
                                        {{ $tipoProgDer == $programasDerivados->tipo_derivado ? 'selected' : '' }}>
                                        {{ $tipoProgDer }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_derivado')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-book"></i>
                        Seleccione el plan estatal: *
                    </div>
                    <select id="planestatal_id" name="planestatal_id"
                        class="form-control @error('planestatal_id') is-invalid @enderror">
                        <option value="" disabled>Seleccione</option>
                        @foreach ($planes_estatales as $plan_estatal_id => $plan_estatal_nombre)
                            <option value="{{ $plan_estatal_id }}"
                                {{ $plan_estatal_id == $programasDerivados->planestatal_id ? 'selected' : '' }}>
                                {{ $plan_estatal_nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('planestatal_id')
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
                                <div class="col-md-8">
                                    <input name="ruta_documento" value="{{ $programasDerivados->ruta_documento }}"
                                        type="text" id="ruta_documento" disabled class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <a target="_blank" class="btn btn-info w-100"
                                        href="/progderi/{{ $programasDerivados->ruta_documento }}">Ver</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-section-title"><i class="fa-solid fa-file-pdf"></i>
                                Subir nuevo: *
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
                    <div class="row">
                        <div class="col-md-8">
                            <div class="custom-section-title"><i class="fa-solid fa-image"></i>
                                Portada actual: *
                            </div>
                            <div class="container d-flex justify-content-center">
                                <img src="/portadaprogder/{{ $programasDerivados->portada }}" width="200px"
                                    id="imagenSeleccionada">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-section-title"><i class="fa-solid fa-images"></i>
                                Subir nueva: *
                            </div>
                            <div class="input-group">
                                <input accept=".jpg,.png,.svg,.jpeg,.webp" name="portada" id="portada" type='file'
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
                            <option value="0" {{ $programasDerivados->publicado == 0 ? 'selected' : '' }}>No
                            </option>
                            <option value="1" {{ $programasDerivados->publicado == 1 ? 'selected' : '' }}>Sí
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
                            <a href="{{ route('panel-programasderivados.index') }}"
                                class='btn btn-secondary w-100'>Cancelar</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" form="form-update-programa"
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
