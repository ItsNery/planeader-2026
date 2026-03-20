<x-app-layout>
    @section('title', 'Banners: Editar')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Banners') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Editar banner</h2>
            </div>
            <form id="form-update-banner" action="{{ route('panel-banners.update', $banner->id) }}" method="POST"
                enctype="multipart/form-data" novalidate>
                @csrf
                @method('PATCH')
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i> Nombre del
                            banner: *
                        </div>
                        <input name="nombre" value="{{ old('nombre') ? old('nombre') : $banner->nombre }}"
                            type="text" id="fname" placeholder="Banner del..."
                            class="form-control @error('nombre') is-invalid @enderror">
                        @error('nombre')
                            <small class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="custom-section-title"><i class="fa-solid fa-link"></i>
                            Enlace:
                        </div>
                        <input type="text" id="fname" name="enlace" value="{{ $banner->enlace }}"
                            class="form-control @error('enlace') is-invalid @enderror"
                            placeholder="https://sitioweb.com.mx o #" @error('enlace') autofocus @enderror>
                        @error('enlace')
                            <small class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-file-lines"></i>
                        Descripción: *
                    </div>
                    <input type="text" id="fname" name="descripcion" value="{{ $banner->descripcion }}"
                        class="form-control @error('descripcion') is-invalid @enderror"
                        @error('descripcion') autofocus @enderror>
                    @error('descripcion')
                        <small class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="custom-section-title"><i class="fa-solid fa-image"></i>
                                Banner actual: *
                            </div>
                            <div class="container d-flex justify-content-center">
                                <img src="/baners/{{ $banner->imagen }}" width="200px" id="imagenSeleccionada"
                                    title="{{ $banner->nombre }}" alt="Imagen del {{ $banner->descripcion }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-section-title"><i class="fa-solid fa-file-image"></i>
                                Subir nueva: *
                            </div>
                            <div class="input-group">
                                <input accept=".jpg,.png,.svg,.jpeg,.webp" name="imagen" id="imagen" type='file'
                                    class="form-control @error('imagen') is-invalid @enderror"
                                    @error('imagen') autofocus @enderror />

                                @error('imagen')
                                    <small class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-4">
                        <div class="custom-section-title"><i class="fa-solid fa-circle-check"></i>
                            Seleccione el estado del banner: *
                        </div>
                        <select id="estado" name="estado"
                            class="form-control @error('estado') is-invalid @enderror">
                            <option value="" disabled>Seleccione</option>
                            @foreach ($estados_banner as $estado)
                                <option value="{{ $estado }}"
                                    {{ $estado == $banner->estado ? 'selected' : '' }}>
                                    {{ $estado }}
                                </option>
                            @endforeach
                        </select>
                        @error('estado')
                            <small class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="custom-section-title"><i class="fa-solid fa-sort"></i>
                            Seleccione la sección donde se mostrará: *
                        </div>
                        <select id="seccion" name="seccion"
                            class="form-control @error('seccion') is-invalid @enderror">
                            <option value="" disabled>Seleccione</option>
                            @foreach ($secciones as $seccion)
                                <option value="{{ $seccion }}"
                                    {{ $seccion == $banner->seccion ? 'selected' : '' }}>
                                    {{ $seccion }}
                                </option>
                            @endforeach
                        </select>
                        @error('estado')
                            <small class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="custom-section-title"><i class="fa-solid fa-sort"></i> Orden *</div>
                        <select class="form-control @error('orden') is-invalid @enderror" id="orden" name="orden"
                            required>
                            <option value="" disabled>Seleccione</option>
                            @foreach ($ordenesDisponibles as $orden)
                                <option value="{{ $orden }}" {{ $orden == $banner->orden ? 'selected' : '' }}
                                    {{ in_array($orden, $ordenesExistentes) && $orden != $banner->orden ? 'disabled' : '' }}>
                                    {{ $orden }}
                                </option>
                            @endforeach
                        </select>
                        @error('orden')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <a href="{{ route('panel-banners.index') }}" class="btn btn-secondary w-100">
                            Cancelar
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" form="form-update-banner" class="btn btn-success w-100">
                            Actualizar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function(e) {
        $('#imagen').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
