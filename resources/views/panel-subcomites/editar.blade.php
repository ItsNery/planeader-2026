<x-app-layout>
    @section('title', 'Subcomités: Editar')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Subcomites') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Editar subcomité</h2>
            </div>
            <form id="form-update-comite" action="{{ route('panel-subcomites.update', $subcomites->id) }}" method="POST"
                enctype="multipart/form-data" novalidate>
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i>
                        Nombre del subcomité: *
                    </div>
                    <input name="nombre" value="{{ old('nombre') ? old('nombre') : $subcomites->nombre }}"
                        type="text" id="fname" placeholder="Subcomité de ..."
                        class="form-control @error('nombre') is-invalid @enderror">
                    @error('nombre')
                        <small class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-bullseye"></i>
                        Objetivo: *
                    </div>
                    <textarea class="form-control @error('objetivo') is-invalid @enderror" name="objetivo" id="objetivo" rows="4"
                        placeholder="Escribe el objetivo" @error('objetivo') autofocus @enderror required>{{ old('objetivo', $subcomites->objetivo) }}</textarea>
                    @error('objetivo')
                        <small class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <div class="custom-section-title"><i class="fa-solid fa-sort"></i>
                            Seleccione el tipo de subcomite: *
                        </div>
                        <select id="tipo_subcomite" name="tipo_subcomite"
                            class="form-control @error('tipo_subcomite') is-invalid @enderror">
                            <option value="" disabled>Seleccione</option>
                            @foreach ($tipos_subcomites as $tipo_subcomite)
                                <option value="{{ $tipo_subcomite }}"
                                    {{ $tipo_subcomite == $subcomites->tipo_subcomite ? 'selected' : '' }}>
                                    {{ $tipo_subcomite }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_subcomite')
                            <small class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="custom-section-title"><i class="fa-solid fa-book"></i>
                            Seleccione el plan estatal: *
                        </div>
                        <select id="planestatal_id" name="planestatal_id"
                            class="form-control @error('planestatal_id') is-invalid @enderror">
                            <option value="" disabled>Seleccione</option>
                            @foreach ($planes_estatales as $plan_estatal)
                                <option value="{{ $plan_estatal->id }}"
                                    {{ $plan_estatal->id == $subcomites->planestatal_id ? 'selected' : '' }}>
                                    {{ $plan_estatal->nombre }}
                                </option>
                            @endforeach
                            @error('planestatal_id')
                                <small class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-8">
                        <div class="custom-section-title"><i class="fa-solid fa-image"></i>
                            Actual ícono: *
                        </div>
                        <div class="container d-flex justify-content-center">
                            <img src="/icono_subcomites/{{ $subcomites->icono }}" width="200px" id="iconoSeleccionado"
                                title="{{ $subcomites->nombre }}" alt="Icono del {{ $subcomites->icono }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="custom-section-title"><i class="fa-solid fa-images"></i>
                            Subir nuevo: *
                        </div>
                        <div class="input-group">
                            <input accept=".jpg,.png,.svg,.jpeg" name="icono" id="icono" type='file'
                                class="form-control @error('icono') is-invalid @enderror"
                                @error('icono') autofocus @enderror required />

                            @error('icono')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-8">
                        <div class="custom-section-title"><i class="fa-solid fa-image"></i>
                            Actual conformación: *
                        </div>
                        <div class="container d-flex justify-content-center">
                            <img src="/subcomitesconformacion/{{ $subcomites->conformacion }}" width="200px"
                                id="imagenSeleccionada" title="{{ $subcomites->icono }}"
                                alt="Conformación del {{ $subcomites->icono }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="custom-section-title"><i class="fa-solid fa-image"></i>
                            Subir nueva: *
                        </div>
                        <div class="input-group">
                            <input accept=".jpg,.png,.svg,.jpeg" name="conformacion" id="conformacion" type='file'
                                class="form-control @error('conformacion') is-invalid @enderror"
                                @error('conformacion') autofocus @enderror required />

                            @error('conformacion')
                                <small class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>


                @if (Auth::user()->validador)
                    <div class="mb-3">
                        <div class="col-md-12">
                            <div class="custom-section-title"><i class="fa-solid fa-circle-check"></i>
                                ¿El documento puede ser
                                publicado?
                            </div>
                            <select class="form-control @error('publicado') is-invalid @enderror" id="publicado"
                                name="publicado" required>
                                <option value="0" {{ $subcomites->publicado == 0 ? 'selected' : '' }}>No
                                </option>
                                <option value="1" {{ $subcomites->publicado == 1 ? 'selected' : '' }}>Sí
                                </option>
                            </select>
                            @error('publicado')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="mb-3 row">
                    <div class="col-md-6">
                        <a href="{{ route('panel-subcomites.index') }}" class="btn btn-secondary w-100">
                            Cancelar
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" form="form-update-comite" class="btn btn-primary w-100">
                            Subir
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function(e) {
        $('#conformacion').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
    $(document).ready(function(e) {
        $('#icono').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#iconoSeleccionado').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
