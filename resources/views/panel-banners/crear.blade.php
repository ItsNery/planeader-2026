<x-app-layout>
    @section('title', 'Banners: Subir')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subir Banner') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Subir banner</h2>
            </div>
            <form action="{{ route('panel-banners.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i> Nombre del
                            banner: *
                        </div>
                        <input name="nombre" type="text" id="fname" placeholder="Inserte el nombre del banner"
                            class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}"
                            @error('nombre') autofocus @enderror autofocus required>
                        @error('nombre')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="custom-section-title"><i class="fa-solid fa-link"></i>
                            Enlace:
                        </div>
                        <input type="url" id="enlace" name="enlace"
                            placeholder="Inserte el enlace a la página a la cual redirigirá su banner en un formato: https://www.sitio.com"
                            class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('enlace') }}"
                            @error('enlace') autofocus @enderror autofocus required>
                        @error('enlace')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-file-lines"></i>
                        Descripción: *
                    </div>
                    <input type="text" id="descripcion" name="descripcion"
                        placeholder="Inserte una descripción del banner que subirá"
                        class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion') }}"
                        @error('descripcion') autofocus @enderror autofocus required>
                    @error('descripcion')
                        <small class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-image"></i>
                        Cargue la imagen: *
                    </div>
                    <div class="container d-flex justify-content-center">
                        <img id="imagenSeleccionada" style="max-height: 300px;">
                    </div>
                    <input accept=".jpg,.png,.svg,.jpeg" name="imagen" id="imagen" type='file'
                        class="hidden form-control @error('imagen') is-invalid @enderror"
                        @error('imagen') autofocus @enderror required />
                    @error('imagen')
                        <small class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                    <div class="container">
                        <div class="text-muted">
                            Recuerda que para conservar la estructura, la imagen debe tener un tamaño
                            de 1300 pixeles de largo por 320 pixeles de ancho.
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-4">
                        <div class="custom-section-title"><i class="fa-solid fa-circle-check"></i>
                            Seleccione el estado del banner: *
                        </div>
                        <select id="estado" name="estado" class="form-control @error('estado') is-invalid @enderror"
                            @error('estado') autofocus @enderror required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach ($estado_banner as $estado)
                                <option value="{{ $estado }}">{{ $estado }}</option>
                            @endforeach
                        </select>
                        @error('estado')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                        <div class="container">
                            <div class="text-muted">
                                Se consideran tres estados: Activo, Inactivo y Pendiente. Activo indica
                                que se debe mostrar, Inactivo que se suspendió su publicación y Pendiente que
                                aun no se tiene claro su estado.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="custom-section-title"><i class="fa-solid fa-sort"></i>
                            Seleccione la sección donde se mostrará: *
                        </div>
                        <select id="seccion" name="seccion" class="form-control @error('estado') is-invalid @enderror"
                            @error('seccion') autofocus @enderror required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach ($secciones as $seccion)
                                <option value="{{ $seccion }}">{{ $seccion }}</option>
                            @endforeach
                        </select>
                        @error('seccion')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="custom-section-title"><i class="fa-solid fa-sort"></i> Orden *</div>
                        <select class="form-control @error('orden') is-invalid @enderror" id="orden" name="orden"
                            required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach ($ordenesDisponibles as $orden)
                                <option value="{{ $orden }}"
                                    {{ in_array($orden, $ordenesExistentes) ? 'disabled' : '' }}>
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
                        <button type="submit" class="btn btn-success w-100"
                            style="background-color: green">Subir</button>
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
