<x-app-layout>
    @section('title', 'Subcomités: Subir')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear subcomites') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Crear subcomité</h2>
            </div>
            <form action="{{ route('panel-subcomites.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i>
                        Nombre del subcomité: *
                    </div>
                    <input name="nombre" type="text" id="fname" placeholder="Subcomité de... *"
                        class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}"
                        @error('nombre') autofocus @enderror autofocus required>
                    @error('nombre')
                        <small class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-bullseye"></i>
                        Objetivo: *
                    </div>
                    <textarea id="objetivo" name="objetivo" placeholder="Objetivo del subcomité...*"
                        class="form-control @error('periodo') is-invalid @enderror" required>{{ old('objetivo') }}</textarea>
                    @error('objetivo')
                        <small class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <div class="custom-section-title"><i class="fa-solid fa-icons"></i>
                            Subir icono: *
                        </div>
                        <div class="container d-flex justify-content-center">
                            <img id="iconoElegido" style="max-height: 300px;">
                        </div>
                        <input accept=".jpg,.png,.svg,.jpeg" name="icono" id="icono" type='file'
                            class="hidden form-control @error('icono') is-invalid @enderror"
                            @error('icono') autofocus @enderror required />
                        @error('icono')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="custom-section-title"><i class="fa-solid fa-person-rays"></i>
                            Subir imagen de conformación: *
                        </div>
                        <div class="container d-flex justify-content-center">
                            <img id="imagenSeleccionada" style="max-height: 300px;">
                        </div>
                        <input accept=".jpg,.png,.svg,.jpeg" name="conformacion" id="conformacion" type='file'
                            class="hidden form-control @error('conformacion') is-invalid @enderror"
                            @error('conformacion') autofocus @enderror required />
                        @error('conformacion')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <div class="custom-section-title"><i class="fa-solid fa-sort"></i>
                            Seleccione el tipo: *
                        </div>
                        <select id="tipo_subcomite" name="tipo_subcomite"
                            class="form-control @error('tipo_subcomite') is-invalid @enderror"
                            @error('tipo_subcomite') autofocus @enderror required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach ($tipos_subcomites as $tipo_subcomite)
                                <option value="{{ $tipo_subcomite }}">{{ $tipo_subcomite }}</option>
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
                            Seleccione el Plan Estatal de Desarrollo: *
                        </div>
                        <select id="planestatal_id" name="planestatal_id"
                            class="form-control @error('municipio_id') is-invalid @enderror"
                            @error('planestatal_id') autofocus @enderror required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach ($planes_estatales as $planes)
                                <option value="{{ $planes->id }}">{{ $planes->nombre }}</option>
                            @endforeach
                        </select>
                        @error('planestatal_id')
                            <small class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
                @if (auth()->user()->validador == 1)
                    <div class="mb-3">
                        <div class="custom-section-title"><i class="fa-solid fa-check-circle"></i>
                            ¿El subcomité puede ser publicado?
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
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <a href="{{ route('panel-subcomites.index') }}" class="btn btn-secondary w-100">
                            Cancelar
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success w-100">Subir</button>
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
                $('#iconoElegido').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
