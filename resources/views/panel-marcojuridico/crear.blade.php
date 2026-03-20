<x-app-layout>
    @section('title', 'Marco Jurídico: Subir')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subir documento del Marco Jurídico') }}
        </h2>
    </x-slot>
    <div class="container bg-white">
        <div class="form-container py-3">
            <div class="form-header py-3">
                <h2>Subir documento</h2>
            </div>
            <form action="{{ route('panel-marcojuridico.store') }}" method="POST" enctype="multipart/form-data"
                novalidate>
                @csrf
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-file-signature"></i> 
                        Nombre del documento: *
                    </div>
                    <input name="nombre" type="text" id="fname" placeholder="Nombre del Archivo"
                        class="form-control @error('nombre') is-invalid @enderror"
                        value="{{ old('nombre') }}" @error('nombre') autofocus @enderror autofocus required>
                    @error('nombre')
                        <small class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </small>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-file"></i>
                        Cargue el documento:
                    </div>
                    <div class="input-group">
                        <input accept=".pdf" type="file" id="ruta_documento" name="ruta_documento"
                            class="form-control @error('ruta_documento') is-invalid @enderror"
                            @error('ruta_documento') autofocus @enderror required>
                        @error('ruta_documento')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                        <label class="input-group-text" for="ruta_documento">Seleccionar PDF</label>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-image"></i>
                        Cargue la portada:
                    </div>
                    <div class="input-group">
                        <input accept=".jpg,.png,.svg,.jpeg" type="file" id="portada" name="portada"
                            class="form-control @error('portada') is-invalid @enderror"
                            @error('portada') autofocus @enderror required>
                        @error('portada')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                        <label class="input-group-text" for="portada">Seleccionar Imagen</label>
                    </div>

                    <div class="d-flex justify-content-center my-3">
                        <img id="imagenSeleccionada" style="max-height: 300px;">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-section-title"><i class="fa-solid fa-sort"></i>
                        Orden:
                    </div>
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
                        <a href="{{ route('panel-marcojuridico.index') }}" class="btn btn-secondary mb-3 w-100">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-success mb-3 w-100" style="background-color: green"
                            onclick="return VerifyUploadSizeIsOK()">Subir</button>
                    </div>
                </div>
            </form>
        </div>
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
<script type="text/javascript">
    function VerifyUploadSizeIsOK() {
        var UploadFieldID = "ruta_documento";
        var MaxSizeInBytes = 500000000;
        var fld = document.getElementById(UploadFieldID);
        if (fld.files && fld.files.length == 1 && fld.files[0].size > MaxSizeInBytes) {
            alert("El archivo no deber ser mayor a " + parseInt(MaxSizeInBytes / 1024 / 1024) + "MB");
            return false;
        }
        return true;
    } // function VerifyUploadSizeIsOK()
</script>
